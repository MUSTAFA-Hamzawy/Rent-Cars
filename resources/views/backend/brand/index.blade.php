@php use App\MyHelpers;use RealRashid\SweetAlert\Facades\Alert; @endphp
@extends('backend.layouts.app')
@section('page-title', trans('headers.brands'))
@section('breadcrumb-title', trans('headers.brands'))
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div class="ms-auto" style="margin-bottom: 20px">
                    <a href="{{route('brand.create')}}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                        <i class="bx bxs-plus-square"></i>@lang('brand.add')</a>
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
                                    <form method="post" action="{{route('brand.truncate')}}">
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
                        <th>@lang('brand.logo')</th>
                        <th>@lang('brand.name')</th>
                        <th>@lang('brand.slug')</th>
                        <th>@lang('general.created_at')</th>
                        <th>@lang('general.controls')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td style="width: 50px;">
                                <img src="{{MyHelpers::imgPath("brand/$item->brand_logo")}}" alt="Brand Logo"
                                     class="data-table-img">
                            </td>
                            <td style="max-width: 150px;">{{$item->brand_name}}</td>
                            <td style="max-width: 150px;">{{$item->brand_slug}}</td>
                            <td style="width: 50px;">{{$item->created_at->format('Y-m-d')}}</td>
                            <td style="width: 150px;">
                                <div class="d-flex order-actions">
                                    <a href="{{route('brand.edit', $item->id)}}" class=""><i
                                            class="bx bxs-edit"></i></a>
                                    <a type="button" class="ms-3" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal"><i class="bx bxs-trash"></i></a>
                                    <!-- Confirmation modal  -->
                                    <div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1"
                                         style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">@lang('general.confirm_msg')</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <form method="post" action="{{route('brand.destroy', $item->id)}}">
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
                                    <a href="{{route('brand.show', $item->id)}}" class="ms-3"><i
                                            class="lni lni-eye"></i></a>
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
