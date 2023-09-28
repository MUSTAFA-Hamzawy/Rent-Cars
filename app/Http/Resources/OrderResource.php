<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "total_cost" => $this->total_cost,
            "order_status" => $this->getOrderStatus($this->order_status),
            "user" => $this->user->name,
            "car" => $this->car->car_title,
            "payment_method" => $this->paymentMethod->method_name,
            "created_at" => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            "updated_at" => Carbon::parse($this->updated_at)->format('Y-m-d HiH:i:s')
        ];
    }

    private function getOrderStatus($status): string{
        return $status == 1 ? 'Confirmed' : ($status == 0 ? 'Pending' : 'Cancelled');
    }
}
