<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'number',
        'total_price',
        'status',
        'payment_method',
        'payment_status',
        'payment_ref',
        'customer_name',
        'phone',
        'delivery_address',
        'comment',
        'paid_at',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateNumber(): string
    {
        return 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
    }

    public static function statuses(): array
    {
        return [
            'pending_payment' => 'Ожидает оплаты',
            'paid' => 'Оплачен',
            'processing' => 'В обработке',
            'shipped' => 'Отправлен',
            'completed' => 'Завершён',
            'cancelled' => 'Отменён',
        ];
    }

    public function statusLabel(): string
    {
        return self::statuses()[$this->status] ?? $this->status;
    }
}
