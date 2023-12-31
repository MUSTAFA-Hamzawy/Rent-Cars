<?php

namespace App\Models;

use App\Traits\SerializeDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as ParentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Model extends ParentModel
{
    use HasFactory, SerializeDateTime;

    protected $fillable = [
        'model_name',
        'model_slug',
        'created_by',
    ];

    protected function user(): BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }

    protected function cars(): HasMany{
        return $this->hasMany(Car::class);
    }

}

