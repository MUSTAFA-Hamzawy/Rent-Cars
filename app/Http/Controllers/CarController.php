<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Category;
use App\Models\Model;
use App\MyHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CarController extends Controller
{
    private const TABLE_NAME = 'cars';
    private const VIEWS = [
        'index'  => 'backend.car.index',
        'create' => 'backend.car.create',
        'show' => 'backend.car.show',
        'edit' => 'backend.car.edit',
    ];
    private $images_dir;

    public function __construct()
    {
        $this->images_dir = config('filesystems.media.images') . 'car';
    }


    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $data = Car::orderBy('created_at')->paginate(self::PAGINATION_COUNT);
        return view(self::VIEWS['index'], ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        $branches   = Branch::all(['id', 'branch_name']);
        $brands     = Brand::all(['id', 'brand_name']);
        $categories = Category::all(['id', 'category_name']);
        $models     = Model::all(['id', 'model_name']);
        return view(self::VIEWS['create'],
            ['branches' => $branches,
             'brands' => $brands,
             'categories' => $categories,
             'models' => $models
            ]);
    }

    /**
     * To make sure that brand, branch, model, and category IDs are correct
     * @param CarRequest $request // Passed by ref because no need to make a copy of the request
     * @return bool
     */
    private function checkModelsExistance(CarRequest &$request): bool{
        return (
            Brand::where('id', $request->input('car_brand'))->exists() &&
            Branch::where('id', $request->input('car_branch'))->exists() &&
            Category::where('id', $request->input('car_category'))->exists() &&
            Model::where('id', $request->input('car_model'))->exists()
        );
    }

    /**
     * To save all uploaded images of the car, and implode their names as json object
     * @param array $images
     * @return string
     */
    private function saveCarImages(array $images) : string{
        $imagesAsJson = [];
        foreach($images as $image) $imagesAsJson[] =  MyHelpers::uploadImage($image, $this->images_dir);
        return json_encode($imagesAsJson);
    }

    /**
     * To remove old images of the car.
     * @param string $images
     */
    private function removeOldCarImages(string $images) : void{
        $imagesAsArray = json_decode($images);
        foreach($imagesAsArray as $image) MyHelpers::deleteImageFromStorage($image, $this->images_dir);
    }


    /**
     * Store a newly created resource in storage.
     * @param CarRequest $request
     * @return JsonResponse
     */
    public function store(CarRequest $request): JsonResponse
    {
        // Check that brand, branch, category, and model IDs are correct values
        if (! $this->checkModelsExistance($request))
            return $this->handleResponse(false, trans('Something went wrong, try again'));

        // prepare needed data
        $record = [
            'car_title' => $this->getCarTitle($request->input('car_brand'), $request->input('car_model'), $request->input('car_year')),
            'distance_limit' => $request->input('car_distance_limit') ?? 0,
            'fees_for_extra_KM' => $request->input('over_distance_fees') ?? 0,
            'year' => $request->input('car_year'),
            'car_color' => $request->input('car_color'),
            'price_per_day' => $request->input('car_rent_price'),
            'is_available' => $request->input('car_available') == "on" ? 1 : 0,
            'branch_id' => $request->input('car_branch'),
            'brand_id' => $request->input('car_brand'),
            'model_id' => $request->input('car_model'),
            'category_id' => $request->input('car_category'),
            'created_by' => Auth::id()
        ];

        // Save images
        if ($request->hasFile('car_images'))
            $record['car_images'] = $this->saveCarImages($request->file('car_images'));

        return $this->handleResponse(! is_null(Car::create($record)), trans('general.stored', ['attribute' => trans('modules.car')]));
    }

    /**
     * @param int $brandId
     * @param int $modelId
     * @param int $carYear
     * @return string
     * To generate a title for a car
     */
    private function getCarTitle(int $brandId, int $modelId, int $carYear): string{
        $brand = Brand::where('id', $brandId)->value('brand_name');
        $model = Model::where('id', $modelId)->value('model_name');
        return "$brand $model $carYear";
    }

    /**
     * Display the specified resource.
     * @param Car $car
     */
    public function show(Car $car)
    {
        return view(self::VIEWS['show'], ['item' => $car]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Car $car
     * @return View
     */
    public function edit(Car $car): View
    {
        $branches   = Branch::all(['id', 'branch_name']);
        $brands     = Brand::all(['id', 'brand_name']);
        $categories = Category::all(['id', 'category_name']);
        $models     = Model::all(['id', 'model_name']);
        return view(self::VIEWS['edit'],
            [   'branches' => $branches,
                'brands' => $brands,
                'categories' => $categories,
                'models' => $models,
                'item' => $car
            ]);
    }

    /**
     * Update the specified resource in storage.
     * @param CarRequest $request
     * @param Car $car
     * @return JsonResponse
     */
    public function update(CarRequest $request, Car $car): JsonResponse
    {
        // Check that brand, branch, category, and model IDs are correct values
        if (! $this->checkModelsExistance($request))
            return $this->handleResponse(false, trans('Something went wrong, try again'));

        // Fetching the new data
        $record = [
            'car_title' => $this->getCarTitle($request->input('car_brand'), $request->input('car_model'), $request->input('car_year')),
            'distance_limit' => $request->input('car_distance_limit') ?? 0,
            'fees_for_extra_KM' => $request->input('over_distance_fees') ?? 0,
            'year' => $request->input('car_year'),
            'car_color' => $request->input('car_color'),
            'price_per_day' => $request->input('car_rent_price'),
            'is_available' => $request->input('car_available') == "on" ? 1 : 0,
            'branch_id' => $request->input('car_branch'),
            'brand_id' => $request->input('car_brand'),
            'model_id' => $request->input('car_model'),
            'category_id' => $request->input('car_category'),
        ];

        // Handling file if it exists
        if ($request->hasFile('car_images')){
            $record['car_images'] = $this->saveCarImages($request->file('car_images'));
            $this->removeOldCarImages($car->car_images);
        }
        // update
        $updated = Car::where('id', $car->id)->update($record);
        return $this->handleResponse(! is_null($updated), trans('general.updated', ['attribute' => trans('modules.car')]));
    }

    /**
     * Remove the specified resource from storage.
     * @param Car $car
     * @return RedirectResponse
     */
    public function destroy(Car $car): RedirectResponse
    {
        if ($car->delete()){
            // Removing the image from storage
                $this->removeOldCarImages($car->car_images);
        }
        else toast(trans('general.failed', ['attribute' => trans('modules.car')]),'error');
        return to_route('car.index');
    }

    /**
     * To Remove the whole data
     * @return RedirectResponse
     */
    public function truncate(): RedirectResponse
    {
        $query = "DELETE FROM " . self::TABLE_NAME;
        DB::delete($query);
        File::deleteDirectory(storage_path($this->images_dir));
        toast(trans('general.success', ['attribute' => trans('modules.car')]),'success');
        return to_route('car.index');
    }
}
