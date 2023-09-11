<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\MyHelpers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class BrandController extends Controller
{
    private const VIEWS = [
        'index'  => 'backend.brand.index',
        'create' => 'backend.brand.create',
        'show' => 'backend.brand.show',
        'edit' => 'backend.brand.edit',
    ];
    private $images_dir;

    public function __construct()
    {
        $this->images_dir = config('filesystems.media.images') . 'brand';
    }


    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $data = Brand::orderBy('created_at')->paginate(15);
        return view(self::VIEWS['index'], ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return view(self::VIEWS['create']);
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
            'brand_logo' => MyHelpers::uploadImage($request->file('brand_logo'), $this->images_dir),
        ];
        return $this->handleResponse(! is_null(Brand::create($record)), trans('general.stored', ['attribute' => trans('modules.brand')]));
    }

    /**
     * Display the specified resource.
     * @param Brand $brand
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param Brand $brand
     * @return View
     */
    public function edit(Brand $brand): View
    {
        return view(self::VIEWS['edit'], ['item' => $brand]);
    }

    /**
     * Update the specified resource in storage.
     * @param BrandRequest $request
     * @param Brand $brand
     * @return JsonResponse
     */
    public function update(BrandRequest $request, Brand $brand): JsonResponse
    {
        // TODO: need to check if there is any value changed or not
        // Fetching the new data
        $record = [
            'brand_name' => $request->brand_name,
            'brand_slug' => Str::slug($request->brand_name),
            'brand_description' => $request->brand_description
        ];

        // Handling file if it exists
        if ($request->hasFile('brand_logo')){
            $record['brand_logo'] =  MyHelpers::uploadImage($request->file('brand_logo'), $this->images_dir);
            MyHelpers::deleteImageFromStorage($brand->brand_logo, $this->images_dir);
        }

        // update
        $updated = Brand::where('id', $brand->id)->update($record);
        return $this->handleResponse(! is_null($updated), trans('general.updated', ['attribute' => trans('modules.brand')]));
    }

    /**
     * Remove the specified resource from storage.
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function destroy(Brand $brand): RedirectResponse
    {
        if ($brand->delete()){
            // Removing the image from storage
            MyHelpers::deleteImageFromStorage($brand->brand_logo, $this->images_dir);
            toast(trans('general.success', ['attribute' => trans('modules.brand')]),'success');
        }
        else toast(trans('general.failed', ['attribute' => trans('modules.brand')]),'error');
        return to_route('brand.index');
    }

    /**
     * To Remove the whole data
     * @return RedirectResponse
     */
    public function truncate(): RedirectResponse
    {
        Brand::truncate();
        File::deleteDirectory(storage_path($this->images_dir));
        toast(trans('general.success', ['attribute' => trans('modules.brand')]),'success');
        return to_route('brand.index');
    }
}
