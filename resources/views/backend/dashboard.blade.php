@extends('backend.layouts.app')
@section('page-title', 'Dashboard')
@section('content')
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-10 bg-gradient-deepblue">
                <div class="card-body">
                    <div class="d-flex align-items-center" dir="ltr">
                        <h5 class="mb-0 text-white">{{$stats['orders_count']}}</h5>
                        <div class="ms-auto">
                            <i class='bx bx-cart fs-3 text-white'></i>
                        </div>
                    </div>
                    <div class="progress my-3 bg-light-transparent" style="height:3px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: {{$stats['orders_count']}}%" aria-valuenow="25"
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex align-items-center text-white">
                        <p class="mb-0">@lang('Orders')</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 bg-gradient-orange">
                <div class="card-body">
                    <div class="d-flex align-items-center" dir="ltr">
                        <h5 class="mb-0 text-white">{{$stats['brands_count']}}</h5>
                        <div class="ms-auto">
                            <i class='lni lni-apple fs-3 text-white'></i>
                        </div>
                    </div>
                    <div class="progress my-3 bg-light-transparent" style="height:3px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width:{{$stats['brands_count']}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex align-items-center text-white">
                        <p class="mb-0">@lang('Brands')</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 bg-gradient-ohhappiness">
                <div class="card-body">
                    <div class="d-flex align-items-center" dir="ltr">
                        <h5 class="mb-0 text-white">{{$stats['users_count']}}</h5>
                        <div class="ms-auto">
                            <i class='bx bx-group fs-3 text-white'></i>
                        </div>
                    </div>
                    <div class="progress my-3 bg-light-transparent" style="height:3px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: {{$stats['users_count']}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex align-items-center text-white">
                        <p class="mb-0">@lang('Users')</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 bg-gradient-ibiza">
                <div class="card-body">
                    <div class="d-flex align-items-center" dir="ltr">
                        <h5 class="mb-0 text-white">{{$stats['cars_count']}}</h5>
                        <div class="ms-auto">
                            <i class='lni lni-car-alt fs-3 text-white'></i>
                        </div>
                    </div>
                    <div class="progress my-3 bg-light-transparent" style="height:3px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: {{$stats['cars_count']}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex align-items-center text-white">
                        <p class="mb-0">@lang('Cars')</p>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->
    <div class="card radius-10">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h5 class="mb-0">@lang('Last Orders')</h5>
                </div>
                <div class="font-22 ms-auto"><i class="bx bx-dots-horizontal-rounded"></i>
                </div>
            </div>
            <hr>
                <div class="table-responsive">
                    <table id="data_table" class="table table-striped table-bordered" style="width:100%">
                        <thead class="table-light">
                        <tr>
                            <th>@lang('ID')</th>
                            <th>@lang('Customer')</th>
                            <th>@lang('Car')</th>
                            <th>@lang('Branch')</th>
                            <th>@lang('Payment Method')</th>
                            <th>@lang('Total Cost')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Start Date')</th>
                            <th>@lang('End Date')</th>
                            <th>@lang('Created')</th>
                            <th>@lang('Last Updated')</th>
                            <th>@lang('general.controls')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stats['last_orders'] as $item)
                            <tr>
                                <td style="max-width: 50px;">{{$item->id}} </td>
                                <td style="width: 100px;">{{$item->user->name}} </td>
                                <td style="width: 100px;"><a href="{{route('car.show',$item->car->id)}}" class="fw-bold">{{$item->car->car_title}}</a></td>
                                <td style="width: 100px;"><a href="{{route('branch.show',$item->car->branch->id)}}" class="fw-bold">{{$item->car->branch->branch_name}}</a> </td>
                                <td style="width: 100px;">{{$item->paymentMethod->method_name}} </td>
                                <td style="width: 100px;">${{$item->total_cost}} </td>
                                <td style="width: 100px;">
                                    @switch($item->order_status)
                                        @case(1)
                                            <div class="badge rounded-pill text-success bg-light-success px-3"><i class="bx bxs-circle align-middle me-1"></i>Confirmed</div>
                                            @break
                                        @case(-1)
                                            <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class="bx bxs-circle align-middle me-1"></i>Canceled</div>
                                            @break
                                        @default
                                            <div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class="bx bxs-circle align-middle me-1"></i>Pending</div>
                                            @break
                                    @endswitch
                                </td>
                                <td style="width: 100px;">{{$item->start_date}} </td>
                                <td style="width: 100px;">{{$item->end_date}} </td>
                                <td style="width: 50px;">{{$item->created_at->format('Y-m-d')}}</td>
                                <td style="width: 50px;">{{$item->updated_at?->format('Y-m-d')}}</td>
                                <td style="width: 50px;">
                                    <div class="d-flex order-actions">
                                        <a href="{{route('order.edit', $item->id)}}" class=""><i class="bx bxs-edit"></i></a>
                                        <a type="button" class="ms-3" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal-{{$item->id}}"><i class="bx bxs-trash"></i></a>
                                        <!-- Confirmation modal  -->
                                        <div class="modal fade" id="exampleVerticallycenteredModal-{{$item->id}}" tabindex="-1"
                                             style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">@lang('general.confirm_msg')</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="post" action="{{route('order.destroy', $item->id)}}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">@lang('general.cancel')</button>
                                                            <button type="submit" class="btn btn-primary">@lang('general.confirm')</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Confirmation modal  -->
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
        </div>
    </div>
@endsection
