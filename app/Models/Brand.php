<?php

namespace App\Models;

use App\Traits\SerializeDateTime;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SerializeDateTime;
    protected $fillable = [
        'brand_name',
        'brand_slug',
        'brand_description',
        'brand_logo'
    ];

}
