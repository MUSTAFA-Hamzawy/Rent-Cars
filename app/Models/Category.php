<?php

namespace App\Models;

use App\Traits\SerializeDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory, SerializeDateTime;
    protected $fillable = [
        'category_name',
        'category_slug',
        'created_by',
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }
}
