<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    private const VIEWS = [
        'index'  => 'backend.category.index',
        'create' => 'backend.category.create',
        'show' => 'backend.category.show',
        'edit' => 'backend.category.edit',
    ];

    private const TABLE_NAME = 'categories';

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $data = Category::orderBy('created_at')
            ->with(['user' => function ($query){$query->select('id', 'name');}])
            ->paginate(5);
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
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $record = [
            'category_name' => $request->input('category_name'),
            'category_slug' => Str::slug($request->input('category_name')),
            'created_by'    => Auth::user()->id,
        ];
        return $this->handleResponse(! is_null(Category::create($record)), trans('general.stored', ['attribute' => trans('modules.category')]));
    }

    /**
     * Display the specified resource.
     * @param Category $category
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        return view(self::VIEWS['edit'], ['item' => $category]);
    }

    /**
     * Update the specified resource in storage.
     * @param CategoryRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        // Fetching the new data
        $record = [
            'category_name' => $request->input('category_name'),
            'category_slug' => Str::slug($request->input('category_name'))
        ];

        // update
        $updated = Category::where('id', $category->id)->update($record);
        return $this->handleResponse(! is_null($updated), trans('general.updated', ['attribute' => trans('modules.category')]));
    }

    /**
     * Remove the specified resource from storage.
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->delete()) toast(trans('general.success', ['attribute' => trans('modules.category')]),'success');
        else toast(trans('general.failed', ['attribute' => trans('modules.category')]),'error');
        return to_route('category.index');
    }

    /**
     * To Remove the whole data
     * @return RedirectResponse
     */
    public function truncate(): RedirectResponse
    {
        $query = `DELETE FROM `  . self::TABLE_NAME;
        DB::delete($query);
        toast(trans('general.success', ['attribute' => trans('modules.category')]),'success');
        return to_route('category.index');
    }

}
