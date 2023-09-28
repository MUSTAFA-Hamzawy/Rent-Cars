<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'branch_name',
        'branch_address',
        'created_by',
        'available_times'
    ];

    protected function user(): BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }

    protected function payment_methods(): BelongsToMany{
        return $this->belongsToMany(PaymentMethod::class, 'branch_available_payment_methods', 'branch_id', 'method_id');
    }

    protected function cars(): HasMany{
        return $this->hasMany(Car::class);
    }
}
