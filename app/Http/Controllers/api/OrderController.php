<?php

namespace App\Http\Controllers\api;

use App\Events\OrderCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Mail\OrderMail;
use App\Models\Car;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class OrderController extends Controller
{
    const DATE_FORMAT = 'Y-m-d';
    /**
     * Store a newly created resource in storage.
     * @param OrderRequest $request
     * @return JsonResponse
     */
    public function store(OrderRequest $request): JsonResponse
    {
        // validation
        if ($error = $this->validateInputs($request->all())) return response()->json(['error' => $error], 400);

        // calculate the total price
        $rentDuration = $this->getDateDiffInDays($request->input('start_date'), $request->input('end_date'));
        $totalCost = $this->calcOrderCost($request->input('car_id'), $rentDuration);

        // create the order
        $record = [
            'user_id' => Auth::id(),
            'car_id' => $request->input('car_id'),
            'payment_method_id' => $request->input('payment_method_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'total_cost' => $totalCost,
        ];

        $created = Order::create($record);
        $created->car->is_available = 0;
        $created->car->save();
        if (!is_null($created)){
            Mail::to($request->user())->send(new OrderMail($created));
            OrderCreatedEvent::dispatch();
            Notification::send(User::where('is_admin', '1')->get(),
                new NewOrderNotification('New Orders', 'You have received a new order', 'bx bx-cart-alt'));
            return $this->handleResponse(true, $created);
        }
        return $this->handleResponse(false, 'Failed, please try again');
    }

    /**
     * @param array $requestInputs
     * @return string|bool
     */
    private function validateInputs(array $requestInputs): string | bool{
        $error = false;
        $data = [
            'payment_method_id' => $requestInputs['payment_method_id'],
            'car_id' => $requestInputs['car_id']
        ];
        if (! $this->checkModelsExist($data)) $error = 'Invalid Data are sent.';
        if (!$this->validateDates($requestInputs['start_date'], $requestInputs['end_date'])) $error ='End date must be greater than start date';

        return $error;
    }

    /**
     * To make sure that the IDs sent by request is not false data
     * @param array $data
     * @return bool
     */
    private function checkModelsExist(array $data): bool{
        $method_id = $data['payment_method_id'];
        $car_id = $data['car_id'];
        return PaymentMethod::where('id', $method_id)->exists() &&
                Car::where('id', $car_id)->exists();
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @return int
     */
    private function getDateDiffInDays(string $startDate, string $endDate) : int{
        return Carbon::createFromFormat(self::DATE_FORMAT, $endDate)
                ->diffInDays(Carbon::createFromFormat(self::DATE_FORMAT,  $startDate));
    }

    /**
     * To ensure that the end date is gt start date
     * @param string $startDate
     * @param string $endDate
     * @return bool
     */
    private function validateDates(string $startDate, string $endDate): bool {
        return Carbon::createFromFormat(self::DATE_FORMAT, $endDate)
                ->gt(Carbon::createFromFormat(self::DATE_FORMAT, $startDate));
    }

    /**
     * @param int $carId
     * @param int $rentDuration
     * @return float
     */
    private function calcOrderCost(int $carId, int $rentDuration): float{
        return Car::find($carId)->price_per_day * $rentDuration;
    }

    /**
     * Display the specified resource.
     * @param Order $order
     * @return Response
     */
    public function show(Order $order): Response
    {
        if (! $this->checkUserAuthority($order->id, Auth::id())) return response(['error' => 'You are not allowed to show this order'], 400);
        return response(new OrderResource($order));
    }

    /**
     * To make sure that the user who need to show the order is the same person who owns this order
     * @param int $orderID
     * @param int $userId
     * @return bool
     */
    private function checkUserAuthority(int $orderID, int $userId): bool{
        return Order::where('id', $orderID)->value('user_id') == $userId;
    }

    /**
     * @param Order $order
     * @return Response
     */
    public function cancel(Order $order): Response{
        if (! $this->checkUserAuthority($order->id, Auth::id())) return response(['error' => 'You are not allowed to cancel this order'], 400);
        $order->order_status = '-1';
        $order->car->is_available = 1;
        $order->car->save();
        $order->save();
        Mail::to($order->user)->send(new OrderMail($order, -1));
        return response(['msg' => 'Cancelled']);
    }

    public function userOrders(): Response{
        $data = Order::where('user_id', Auth::id())->simplePaginate();
        return response(OrderResource::collection($data));
    }
}
