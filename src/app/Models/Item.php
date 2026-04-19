<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $fillable = [
        'item_code',
        'name',
        'category_id',
        'stock',
        'location',
        'status',
        'note',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'available' => '在庫あり',
            'out_of_stock' => '在庫切れ',
            'discontinued' => '廃番',
            default => '不明',
        };
    }
}
