<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModelRequest;
use App\Http\Requests\PaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PaymentMethodController extends Controller
{
    private const VIEWS = [
    'index'  => 'backend.payment_method.index',
    'create' => 'backend.payment_method.create',
    'show' => 'backend.payment_method.show',
    'edit' => 'backend.payment_method.edit',
    ];

    private const TABLE_NAME = "`payment_methods`";

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $data = PaymentMethod::orderBy('created_at')
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
     * @param PaymentMethodRequest $request
     * @return JsonResponse
     */
    public function store(PaymentMethodRequest $request): JsonResponse
    {
        $record = [
            'method_name' => $request->input('method_name'),
        ];
        return $this->handleResponse(! is_null(PaymentMethod::create($record)), trans('general.stored', ['attribute' => trans('modules.payment_method')]));
    }

    /**
     * Display the specified resource.
     * @param PaymentMethod $payment_method
     */
    public function show(PaymentMethod $payment_method)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param PaymentMethod $payment_method
     * @return View
     */
    public function edit(PaymentMethod $payment_method): View
    {
        return view(self::VIEWS['edit'], ['item' => $payment_method]);
    }

    /**
     * Update the specified resource in storage.
     * @param PaymentMethodRequest $request
     * @param PaymentMethod $payment_method
     * @return JsonResponse
     */
    public function update(PaymentMethodRequest $request, PaymentMethod $payment_method): JsonResponse
    {
        // Fetching the new data
        $record = [
            'method_name' => $request->input('method_name'),
        ];

        // update
        $updated = PaymentMethod::where('id', $payment_method->id)->update($record);
        return $this->handleResponse(! is_null($updated), trans('general.updated', ['attribute' => trans('modules.payment_method')]));
    }

    /**
     * Remove the specified resource from storage.
     * @param PaymentMethod $payment_method
     * @return RedirectResponse
     */
    public function destroy(PaymentMethod $payment_method): RedirectResponse
    {
        if ($payment_method->delete()) toast(trans('general.success', ['attribute' => trans('modules.payment_method')]),'success');
        else toast(trans('general.failed', ['attribute' => trans('modules.payment_method')]),'error');
        return to_route('payment_method.index');
    }

    /**
     * To Remove the whole data
     * @return RedirectResponse
     */
    public function truncate(): RedirectResponse
    {
        $query = "DELETE FROM " . self::TABLE_NAME;
        DB::delete($query);
        toast(trans('general.success', ['attribute' => trans('modules.payment_method')]),'success');
        return to_route('payment_method.index');
    }
}
