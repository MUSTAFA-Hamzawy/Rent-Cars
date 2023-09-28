<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CarResource;
use App\Models\Brand;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(): Response
    {
        $selectedColumns = ['id', 'brand_name', 'brand_slug', 'brand_logo', 'brand_description'];
        $data = Brand::orderBy('created_at')
            ->simplePaginate(self::PAGINATION_COUNT,$selectedColumns);
        return response(BrandResource::collection($data));
    }

    /**
     * Display the specified resource.
     * @param Brand $brand
     * @return Response
     */
    public function show(Brand $brand): Response
    {
        $data = CarResource::collection($brand->cars->where('is_available', 1));
        return response($data);
    }
}
