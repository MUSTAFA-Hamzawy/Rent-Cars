<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\MyHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OrderController extends Controller
{
    const VALIDATION_RULES = [
        "order_status" => ['required', 'numeric', 'min:-1', 'max:1'],
        "total_cost" => ['required', 'numeric'],
    ];
    private const TABLE_NAME = 'orders';
    private const VIEWS = [
        'index'  => 'backend.order.index',
        'show' => 'backend.order.show',
        'edit' => 'backend.order.edit',
    ];

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $data = Order::orderBy('created_at')->paginate(self::PAGINATION_COUNT);
        return view(self::VIEWS['index'], ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Order $order
     * @return View
     */
    public function edit(Order $order): View
    {
        return view(self::VIEWS['edit'], ['item' => $order]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Order $order
     * @return JsonResponse
     */
    public function update(Request $request, Order $order): JsonResponse
    {
        $data = $request->validate(self::VALIDATION_RULES);

        // update
        $updated = Order::where('id', $order->id)->update($data);
        return $this->handleResponse(! is_null($updated), trans('general.updated', ['attribute' => trans('modules.order')]));
        // TODO: send the customer email with the new edited order
    }

    /**
     * Remove the specified resource from storage.
     * @param Order $order
     * @return RedirectResponse
     */
    public function destroy(Order $order): RedirectResponse
    {
        $order->car->is_available = 1;
        $order->car->save();
        $order->delete();
        toast(trans('general.success', ['attribute' => trans('modules.order')]),'success');
        return to_route('order.index');
    }

    /**
     * To Remove the whole data
     * @return RedirectResponse
     */
    public function truncate(): RedirectResponse
    {
        $query = "DELETE FROM " . self::TABLE_NAME;
        DB::delete($query);
        toast(trans('general.success', ['attribute' => trans('modules.order')]),'success');
        return to_route('order.index');
    }
}
