<?php

namespace App\Models;

use App\Traits\SerializeDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory,SerializeDateTime;
    protected $fillable = [
        'method_name'
    ];
}
