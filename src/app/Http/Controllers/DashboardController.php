<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = Item::count();
        $availableItems = Item::where('status', 'available')->count();
        $outOfStockItems = Item::where('status', 'out_of_stock')->count();
        $discontinuedItems = Item::where('status', 'discontinued')->count();
        $totalCategories = Category::count();

        $recentItems = Item::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalItems',
            'availableItems',
            'outOfStockItems',
            'discontinuedItems',
            'totalCategories',
            'recentItems'
        ));
    }
}