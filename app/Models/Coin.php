<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coin extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',   // ← добавили
        'title',
        'description',
        'price',
        'quantity',
        'year',
        'country',
        'condition',
        'status',
        'image_url',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'year' => 'integer',
    ];

    public function category()   // ← добавили
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available' && $this->quantity > 0;
    }

    public function decrementStock(int $amount = 1): void
    {
        $this->quantity = max(0, $this->quantity - $amount);
        if ($this->quantity === 0) {
            $this->status = 'sold';
        }
        $this->save();
    }

    public function incrementStock(int $amount = 1): void
    {
        $this->quantity += $amount;
        if ($this->status === 'sold') {
            $this->status = 'available';
        }
        $this->save();
    }
}
