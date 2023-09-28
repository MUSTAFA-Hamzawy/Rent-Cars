@extends('backend.layouts.app')
@section('page-title', trans('Orders'))
@section('breadcrumb-title', trans('Orders'))
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                @if(count($data) > 0)
                    <div class="ms-auto" style="margin-bottom: 20px">
                        <a type="button" class="btn btn-danger radius-30 mt-2 mt-lg-0" data-bs-toggle="modal"
                           data-bs-target="#exampleVerticallycenteredModal2">
                            <i class="bx bxs-trash"></i>@lang('Remove All')</a>

                        <!-- Confirmation modal  -->
                        <div class="modal fade" id="exampleVerticallycenteredModal2" tabindex="-1"
                             style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">@lang('general.confirm_msg')</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <form method="post" action="{{route('order.truncate')}}">
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
                @endif

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
                    @foreach($data as $item)
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
                {{ $data->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection

@section('data-tables-script')
    <script src="{{asset('assets')}}/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('#data_table').DataTable({
                lengthChange: false, // Disable length change dropdown
                paging: false, // Disable pagination
                info: false, // Hide "Showing X to Y of Z entries
                buttons: ['excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#data_table_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection

@section('js')
    <!--notification js -->
    <script src="{{asset('assets')}}/plugins/notifications/js/lobibox.min.js"></script>
    <script src="{{asset('assets')}}/plugins/notifications/js/notifications.min.js"></script>
    <script src="{{asset('assets')}}/plugins/notifications/js/notification-custom-script.js"></script>
    <script src="{{asset('assets')}}/js/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea'
        });
    </script>
@endsection
