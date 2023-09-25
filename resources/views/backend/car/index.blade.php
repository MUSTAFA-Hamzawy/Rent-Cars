@extends('backend.layouts.app')
@section('style')
    .color-circle: {
    display: block;margin: auto; width: 10px;height: 10px;
    border-radius:
    50%;
    }

@endsection
@section('page-title', __('Cars'))
@section('breadcrumb-title', __('Cars'))
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div class="ms-auto" style="margin-bottom: 20px">
                    <a href="{{route('car.create')}}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                        <i class="bx bxs-plus-square"></i>@lang('Add Car')</a>
                </div>
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
                                    <form method="post" action="{{route('car.truncate')}}">
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
                    <thead>
                    <tr>
                        <th>@lang('Car Title')</th>
                        <th>@lang('Car Year')</th>
                        <th>@lang('Price Per Day')</th>
                        <th>@lang('Car Color')</th>
                        <th>@lang('Distance Limit')</th>
                        <th>@lang('Branch')</th>
                        <th>@lang('Brand')</th>
                        <th>@lang('Model')</th>
                        <th>@lang('Available')</th>
                        <th>@lang('general.created_by')</th>
                        <th>@lang('general.controls')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td style="max-width: 150px;">{{$item->car_title}}</td>
                            <td style="width: 150px;">{{$item->year}}</td>
                            <td style="width: 150px;">{{$item->price_per_day}}</td>
                            <td style="width: 150px;">
                                <span class="color-circle" style="
                                display: block;margin: auto; width: 20px;height: 20px;border-radius: 50%;background-color: {{$item->car_color}}"></span>
                            </td>
                            <td style="width: 150px;">{{$item->distance_limit}} KM</td>
                            <td style="width: 150px;"><a href="{{route('branch.show', $item->branch->id)}}" >{{$item->branch->branch_name}}</a></td>
                            <td style="width: 150px;"><a href="{{route('brand.show', $item->brand->id)}}">{{$item->brand->brand_name}}</a></td>
                            <td style="width: 150px;"><a href="{{route('model.show', $item->model->id)}}">{{$item->model->model_name}}</a></td>
                            <td style="width: 150px;">@if($item->is_available) @lang('Yes') @else @lang('No')@endif</td>
                            <td style="width: 150px;">{{$item->user->name}}</td>
                            <td style="width: 150px;">
                                <div class="d-flex order-actions">
                                    <a href="{{route('car.edit', $item->id)}}" class=""><i
                                            class="bx bxs-edit"></i></a>
                                    <a type="button" class="ms-3" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal-{{$item->id}}"><i class="bx bxs-trash"></i></a>
                                    <!-- Confirmation modal  -->
                                    <div class="modal fade" id="exampleVerticallycenteredModal-{{$item->id}}" tabindex="-1"
                                         style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">@lang('general.confirm_msg')</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <form method="post" action="{{route('car.destroy', $item->id)}}">
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
                                    <a href="{{route('car.show', $item->id)}}" class="ms-3"><i class="lni lni-eye"></i></a>
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
