<?php

namespace App\Models;

use App\Traits\SerializeDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PaymentMethod extends Model
{
    use HasFactory,SerializeDateTime;
    protected $fillable = [
        'method_name'
    ];

    protected function branches(): BelongsToMany{
        return $this->belongsToMany(Branch::class, 'branch_available_payment_methods', 'branch_id', 'method_id');
    }
}
