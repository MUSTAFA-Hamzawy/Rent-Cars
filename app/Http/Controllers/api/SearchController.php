<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        // validation
        $validator = Validator::make($request->all(), ['key' => ['required', 'string', 'max:100']]);
        if ($validator->fails()) return response($validator->errors(), 400);

        // Fetching result
        $key = $validator->validated()['key'];
        $result = Car::where('is_available', 1)
                     ->where('car_title', 'like', "%$key%")->get();

        if (!$result->isEmpty()) return response(['data' => CarResource::collection($result)]);
        return response(['data' => "No data found"]);
    }

}
