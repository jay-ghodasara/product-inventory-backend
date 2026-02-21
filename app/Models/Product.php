<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = ['category_id', 'name','sku','description','price','cost','','quantity_in_stock', 'minimum_stock_level','supplier_name','active'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function getProfitMarginAttribute()
    {
        return $this->price - $this->cost;
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('quantity_in_stock','<','minimum_stock_level');
    }

    public function needRecorder()
    {
        return $this->quantity_in_stock < $this->minimum_stock_level;
    }
}
