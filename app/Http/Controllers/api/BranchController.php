<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BranchResource;
use App\Http\Resources\CarResource;
use App\Models\Branch;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(): Response
    {
        $selectedColumns = ['id', 'branch_name', 'branch_address', 'available_times'];
        $data = Branch::orderBy('created_at')
            ->simplePaginate(self::PAGINATION_COUNT,$selectedColumns);
        foreach ($data as $branch) $branch->available_times = $this->decodeAvailableTimes($branch->available_times);
        return response(BranchResource::collection($data));
    }

    /**
     * Display the specified resource.
     * @param Branch $branch
     * @return Response
     */
    public function show(Branch $branch): Response
    {
        $branch->available_times = $this->decodeAvailableTimes($branch->available_times);
        return response($branch);
    }

    /**
     * @param array $workDaysAsNumbers
     * @return array
     */
    private function mapWorkDays(array $workDaysAsNumbers): array{
        $daysOfWeek = [
            "1" => "saturday",
            "2" => "sunday",
            "3" => "monday",
            "4" => "tuesday",
            "5" => "wendesay",
            "6" => "thursday",
            "7" => "friday"
        ];
        $result = [];
        foreach ($workDaysAsNumbers as $item) $result[] =$daysOfWeek[$item];
        return $result;
    }


    /**
     * @param string $available_times
     * @return object
     */
    private function decodeAvailableTimes(string $available_times): object{
        $available_times = json_decode($available_times);
        $available_times->work_days = $this->mapWorkDays($available_times->work_days);
        return $available_times;
    }
}
