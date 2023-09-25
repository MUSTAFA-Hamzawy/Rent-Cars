<?php

namespace App\Models;

use App\Traits\SerializeDateTime;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    protected function cars(): HasMany{
        return $this->hasMany(Car::class);
    }

    public function getLogoSrc():string{
        return asset(config('filesystems.assets.images') . 'brand/' . $this->brand_logo);
    }

}
