@php
    if ($orderStatus == 'Pending') $status = 'Submitted';
    else $status = $orderStatus;
@endphp
@component('mail::message')
    # Your Order has been {{ $status }}

    Order ID: {{ $order->id }}
    User: {{ $order->user->name }}
    Car: {{ $order->car->car_title }}
    Payment Method: {{ $order->paymentMethod->method_name }}
    Start Date: {{ $order->start_date }}
    End Date: {{ $order->end_date }}
    Total Cost: ${{ number_format($order->total_cost, 2) }}
    Order Status: {{ $orderStatus }}

    Thanks,
    {{ config('app.name') }}
@endcomponent
