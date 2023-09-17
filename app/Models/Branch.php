<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'branch_name',
        'created_by',
        'available_times'
    ];

    protected function user(): BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }

    protected function payment_methods(): BelongsToMany{
        return $this->belongsToMany(PaymentMethod::class, 'branch_available_payment_methods', 'branch_id', 'method_id');
    }
}
