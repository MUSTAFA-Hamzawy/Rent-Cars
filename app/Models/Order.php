<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected function car(): BelongsTo{
        return $this->belongsTo(Car::class, 'car_id');
    }

    protected function user(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function paymentMethod(): BelongsTo{
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
