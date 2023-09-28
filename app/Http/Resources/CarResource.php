<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'car_title' => $this->car_title,
            'distance_limit' => $this->distance_limit,
            'fees_for_extra_KM' => "$this->fees_for_extra_KM KM",
            'year' => $this->year,
            'price_per_day' => "$$this->price_per_day",
            'car_images' => json_decode($this->car_images),
            'category' => $this->category->category_name,
            'model' => $this->model->model_name,
            'brand' => $this->brand->brand_name,
        ];
    }
}
