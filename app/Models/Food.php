<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\FoodCategory;

class Food extends Model
{
    protected $table = "foods";

    public $timestamps = false;
    protected $fillable = [
        "name",
        "description",
        "category_id",
        "size",
        "price",
        "image",
        "stock_status",
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(FoodCategory::class, "category_id");
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
