<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Item::class);

        $keyword = $request->input('keyword');
        $categoryId = $request->input('category_id');

        $query = Item::with('category');

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('item_code', 'like', '%' . $keyword . '%')
                    ->orWhere('location', 'like', '%' . $keyword . '%');
            });
        }

        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        $items = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('items.index', compact('items', 'categories', 'keyword', 'categoryId'));
    }    /**
         * Show the form for creating a new resource.
         */
    public function create()
    {
        $this->authorize('create', Item::class);
        $categories = Category::orderBy('name')->get();

        return view('items.create', compact('categories'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Item::class);

        $validated = $request->validate([
            'item_code' => 'required|max:255|unique:items,item_code',
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'location' => 'nullable|max:255',
            'status' => 'required|in:available,out_of_stock,discontinued',
            'note' => 'nullable',
        ]);

        if ((int) $validated['stock'] === 0 && $validated['status'] !== 'discontinued') {
            $validated['status'] = 'out_of_stock';
        }

        if ((int) $validated['stock'] > 0 && $validated['status'] === 'out_of_stock') {
            $validated['status'] = 'available';
        }
        Item::create($validated);

        return redirect()->route('items.index')
            ->with('success', '備品を登録しました');
    }    /**
         * Display the specified resource.
         */
    public function show(Item $item)
    {
        $this->authorize('view', $item);

        $item->load('category');

        return view('items.show', compact('item'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $this->authorize('update', $item);
        $categories = Category::orderBy('name')->get();

        return view('items.edit', compact('item', 'categories'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $this->authorize('update', $item);

        $validated = $request->validate([
            'item_code' => 'required|max:255|unique:items,item_code,' . $item->id,
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'location' => 'nullable|max:255',
            'status' => 'required|in:available,out_of_stock,discontinued',
            'note' => 'nullable',
        ]);

        if ((int) $validated['stock'] === 0 && $validated['status'] !== 'discontinued') {
            $validated['status'] = 'out_of_stock';
        }

        if ((int) $validated['stock'] > 0 && $validated['status'] === 'out_of_stock') {
            $validated['status'] = 'available';
        }
        $item->update($validated);

        return redirect()->route('items.index')
            ->with('success', '備品を更新しました');
    }    /**
         * Remove the specified resource from storage.
         */
    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);
        $item->delete();

        return redirect()->route('items.index')
            ->with('success', '備品を削除しました');
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $this->authorize('viewAny', Item::class);

        $keyword = $request->input('keyword');
        $categoryId = $request->input('category_id');

        $query = Item::with('category');

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('item_code', 'like', '%' . $keyword . '%')
                    ->orWhere('location', 'like', '%' . $keyword . '%');
            });
        }

        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        $items = $query->latest()->get();

        $response = new StreamedResponse(function () use ($items) {
            $handle = fopen('php://output', 'w');

            // Excel文字化け対策
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'ID',
                '備品コード',
                '備品名',
                'カテゴリー',
                '在庫数',
                '保管場所',
                'ステータス',
                '備考',
                '作成日時',
            ]);

            foreach ($items as $item) {
                fputcsv($handle, [
                    $item->id,
                    $item->item_code,
                    $item->name,
                    $item->category?->name,
                    $item->stock,
                    $item->location,
                    $item->status_label,
                    $item->note,
                    $item->created_at,
                ]);
            }

            fclose($handle);
        });

        $fileName = 'items_' . now()->format('Ymd_His') . '.csv';

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return $response;
    }
}
