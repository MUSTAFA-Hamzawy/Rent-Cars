<?php

namespace App\Models;

use App\Traits\SerializeDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    use HasFactory, SerializeDateTime;
    protected $fillable = [
        'car_title',
        'distance_limit',
        'fees_for_extra_KM',
        'year',
        'car_color',
        'price_per_day',
        'car_images',
        'is_available',
        'branch_id',
        'brand_id',
        'model_id',
        'category_id',
        'created_by'
    ];

    protected function model():BelongsTo{
        return $this->belongsTo(Model::class, 'model_id');
    }
    protected function branch():BelongsTo{
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    protected function brand():BelongsTo{
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    protected function category():BelongsTo{
        return $this->belongsTo(Category::class, 'category_id');
    }
    protected function user():BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }
    public function getRandomImageSrc():string{
        $imagesAsArray = json_decode($this->car_images);
        $randomImage = $imagesAsArray[array_rand($imagesAsArray)];
        return asset(config('filesystems.assets.images') . 'car/' . $randomImage);
    }

    public function getCarImagesSrc():array{
        $prefix = asset(config('filesystems.assets.images')) . '/car/';
        return substr_replace(json_decode($this->car_images), $prefix, 0, 0);
    }

}
