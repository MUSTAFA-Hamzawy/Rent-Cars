<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\MyHelpers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class BrandController extends Controller
{
    const CRUD = [
        'index'  => 'brand.index',
        'create' => 'brand.create',
        'store' => 'brand.store',
        'show' => 'brand.show',
        'edit' => 'brand.edit',
        'update' => 'brand.edit',
        'destroy' => 'brand.destroy',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Brand::orderBy('created_at')->paginate(15);
        return view('backend.brand.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.brand.create');
    }


    /**
     * Store a newly created resource in storage.
     * @param BrandRequest $request
     * @return JsonResponse
     */
    public function store(BrandRequest $request): JsonResponse
    {
        $record = [
            'brand_name' => $request->input('brand_name'),
            'brand_slug' => Str::slug($request->input('brand_name')),
            'brand_description' => $request->input('brand_description'),
            'brand_logo' => MyHelpers::uploadImage($request->file('brand_logo'), 'app/public/media/images/brand'),
        ];
        return $this->handleResponse(! is_null(Brand::create($record)), 'brand is created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('backend.brand.edit', ['item' => $brand]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, Brand $brand): JsonResponse
    {
        $record = [
            'brand_name' => $request->brand_name,
            'brand_slug' => Str::slug($request->brand_name),
            'brand_description' => $request->brand_description
        ];

        if ($request->hasFile('brand_logo')){
            $record['brand_logo'] =  MyHelpers::uploadImage($request->file('brand_logo'), 'app/public/media/images/brand');
            MyHelpers::deleteImageFromStorage($brand->brand_logo, 'app/public/media/images/brand');
        }


        return $this->handleResponse(! is_null(Brand::where('id', $brand->id)->update($record)), 'brand is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand): RedirectResponse
    {
        if ($brand->delete()){
            // Removing the image from storage
            MyHelpers::deleteImageFromStorage($brand->brand_logo, 'app/public/media/images/brand');
            toast('Success Toast','success');
        }
        else toast('Failed','error');
        return to_route('brand.index');
    }
}
