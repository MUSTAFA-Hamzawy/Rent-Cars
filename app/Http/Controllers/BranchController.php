<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BranchController extends Controller
{
    private const VIEWS = [
        'index'  => 'backend.branch.index',
        'create' => 'backend.branch.create',
        'show' => 'backend.branch.show',
        'edit' => 'backend.branch.edit',
    ];

    private const TABLE_NAME = "branches";

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $data = Branch::orderBy('created_at')
            ->paginate(self::PAGINATION_COUNT);
        return view(self::VIEWS['index'], ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        $paymentMethods = PaymentMethod::all(['id', 'method_name']);
        return view(self::VIEWS['create'], ['paymentMethods' => $paymentMethods]);
    }

    /**
     * Store a newly created resource in storage.
     * @param BranchRequest $request
     * @return JsonResponse
     */
    public function store(BranchRequest $request): JsonResponse
    {
        $paymentMethods = $request->input('payment_methods') ?? [];
        $availableTimes = [
            'work_days' => array_values($request->input('work_days')),
            'work_hours_start' => $request->input('work_hours_start'),
            'work_hours_end' => $request->input('work_hours_end'),
        ];

        $record = [
            'branch_name' => $request->input('branch_name'),
            'available_times' => json_encode($availableTimes),
            'created_by'    => Auth::user()->id,
        ];

        $created = Branch::create($record);
        if (! is_null($created)){
            $this->updatePaymentMethods($created->id, $paymentMethods, true);
            return $this->handleResponse( true, trans('general.stored', ['attribute' => trans('modules.branch')]));
        }
        return $this->handleResponse( false, trans('general.stored', ['attribute' => trans('modules.branch')]));
    }

    /**
     * Display the specified resource.
     * @param Branch $branch
     */
    public function show(Branch $branch)
    {
        return view(self::VIEWS['show'], ['item' => $branch]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Branch $branch
     * @return View
     */
    public function edit(Branch $branch): View
    {
        $paymentMethods = PaymentMethod::all(['id', 'method_name']);
        $branch->available_times = json_decode($branch->available_times);
        return view(self::VIEWS['edit'], ['item' => $branch, 'paymentMethods' => $paymentMethods]);
    }

    /**
     * Update the specified resource in storage.
     * @param BranchRequest $request
     * @param Branch $branch
     * @return JsonResponse
     */
    public function update(BranchRequest $request, Branch $branch): JsonResponse
    {
        $paymentMethods = $request->input('payment_methods') ?? [];
        $availableTimes = [
            'work_days' => array_values($request->input('work_days')),
            'work_hours_start' => $request->input('work_hours_start'),
            'work_hours_end' => $request->input('work_hours_end'),
        ];
        $record = [
            'branch_name' => $request->input('branch_name'),
            'available_times' => json_encode($availableTimes),
        ];

        // update
        $updated = Branch::where('id', $branch->id)->update($record);
        $this->updatePaymentMethods($branch->id, $paymentMethods);
        return $this->handleResponse(! is_null($updated), trans('general.updated', ['attribute' => trans('modules.branch')]));
    }

    private function updatePaymentMethods(int $branchId, array $methods, bool $insert = false): void{
        if (!$branchId) return;

        // Handling Insert case
        if ($insert){
            foreach ($methods as $method)
                DB::table('branch_available_payment_methods')->insert(['branch_id' => $branchId, 'method_id' => $method]);
            return;
        }
        // Handling update case
        $storedMethods  = Branch::find($branchId)->payment_methods->pluck('id')->toArray();
        $methodsToBeRemoved  = array_values(array_diff($storedMethods, $methods));
        $methodsToBeInserted = array_values(array_diff($methods, $storedMethods));

        // inserting the new methods
        foreach ($methodsToBeInserted as $method) DB::table('branch_available_payment_methods')->insert(['branch_id' =>$branchId, 'method_id' => $method]);

        // removing methods
        foreach ($methodsToBeRemoved as $method)
            DB::table('branch_available_payment_methods')
                ->where('branch_id', $branchId)
                ->where('method_id',$method)->delete();

    }

    /**
     * Remove the specified resource from storage.
     * @param Branch $branch
     * @return RedirectResponse
     */
    public function destroy(Branch $branch): RedirectResponse
    {
        if ($branch->delete()) toast(trans('general.success', ['attribute' => trans('modules.branch')]),'success');
        else toast(trans('general.failed', ['attribute' => trans('modules.branch')]),'error');
        return to_route('branch.index');
    }

    /**
     * To Remove the whole data
     * @return RedirectResponse
     */
    public function truncate(): RedirectResponse
    {
        $query = "DELETE FROM "   . self::TABLE_NAME;
        DB::delete($query);
        toast(trans('general.success', ['attribute' => trans('modules.branch')]),'success');
        return to_route('branch.index');
    }

}
