<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModelRequest;
use App\Models\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ModelController extends Controller
{
    private const VIEWS = [
        'index'  => 'backend.model.index',
        'create' => 'backend.model.create',
        'show' => 'backend.model.show',
        'edit' => 'backend.model.edit',
    ];

    private const TABLE_NAME = "`models`";

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $data = Model::orderBy('created_at')
            ->paginate(self::PAGINATION_COUNT);
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
     * @param ModelRequest $request
     * @return JsonResponse
     */
    public function store(ModelRequest $request): JsonResponse
    {
        $record = [
            'model_name' => $request->input('model_name'),
            'model_slug' => Str::slug($request->input('model_name')),
            'created_by'    => Auth::user()->id,
        ];
        return $this->handleResponse(! is_null(Model::create($record)), trans('general.stored', ['attribute' => trans('modules.model')]));
    }

    /**
     * Display the specified resource.
     * @param Model $model
     */
    public function show(Model $model)
    {
        return view(self::VIEWS['show'], ['item' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Model $model
     * @return View
     */
    public function edit(Model $model): View
    {
        return view(self::VIEWS['edit'], ['item' => $model]);
    }

    /**
     * Update the specified resource in storage.
     * @param ModelRequest $request
     * @param Model $model
     * @return JsonResponse
     */
    public function update(ModelRequest $request, Model $model): JsonResponse
    {
        // Fetching the new data
        $record = [
            'model_name' => $request->input('model_name'),
            'model_slug' => Str::slug($request->input('model_name'))
        ];

        // update
        $updated = Model::where('id', $model->id)->update($record);
        return $this->handleResponse(! is_null($updated), trans('general.updated', ['attribute' => trans('modules.model')]));
    }

    /**
     * Remove the specified resource from storage.
     * @param Model $model
     * @return RedirectResponse
     */
    public function destroy(Model $model): RedirectResponse
    {
        if ($model->delete()) toast(trans('general.success', ['attribute' => trans('modules.model')]),'success');
        else toast(trans('general.failed', ['attribute' => trans('modules.model')]),'error');
        return to_route('model.index');
    }

    /**
     * To Remove the whole data
     * @return RedirectResponse
     */
    public function truncate(): RedirectResponse
    {
        $query = "DELETE FROM " . self::TABLE_NAME;
        DB::delete($query);
        toast(trans('general.success', ['attribute' => trans('modules.model')]),'success');
        return to_route('model.index');
    }

}
