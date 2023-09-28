<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(): Response
    {
        $data = Car::orderBy('created_at')
            ->where('is_available', 1)
            ->simplePaginate(self::PAGINATION_COUNT);
        return response(CarResource::collection($data));
    }

    /**
     * Display the specified resource.
     * @param Car $car
     * @return Response
     */
    public function show(Car $car): Response
    {
        return response(new CarResource($car));
    }
}
