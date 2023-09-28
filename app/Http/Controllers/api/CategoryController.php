<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Http\Resources\CategoryResource;
use App\Models\Branch;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(): Response
    {
        $selectedColumns = ['id', 'category_name', 'category_slug'];
        $data = Category::orderBy('created_at')
            ->simplePaginate(self::PAGINATION_COUNT,$selectedColumns);
        return response(CategoryResource::collection($data));
    }

    /**
     * Display the specified resource.
     * @param Category $category
     * @return Response
     */
    public function show(Category $category): Response
    {
        $data = CarResource::collection($category->cars->where('is_available', 1));
        return response($data);
    }
}
