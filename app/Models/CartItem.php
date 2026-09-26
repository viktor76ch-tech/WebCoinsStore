<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'coin_id',
        'quantity',
        'price_at_add',
    ];

    protected $casts = [
        'price_at_add' => 'decimal:2',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class)->withTrashed();
    }

    public function subtotal(): float
    {
        return (float) $this->quantity * (float) $this->price_at_add;
    }
}
