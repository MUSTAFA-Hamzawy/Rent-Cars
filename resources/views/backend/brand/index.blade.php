@php use App\MyHelpers;use RealRashid\SweetAlert\Facades\Alert; @endphp
@extends('backend.layouts.app')
@section('page-title', 'Brands')
@section('breadcrumb-title', 'Brands')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div class="ms-auto" style="margin-bottom: 20px">
                    <a href="{{route('brand.create')}}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                        <i class="bx bxs-plus-square"></i>Add New Brand</a></div>

                <table id="data_table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Brand Logo</th>
                        <th>Brand Name</th>
                        <th>Brand Slug</th>
                        <th>Created Date</th>
                        <th>Actions</th>
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
                                    <a type="button" class="ms-3" data-bs-toggle="modal"
                                       data-bs-target="#exampleVerticallycenteredModal"><i class="bx bxs-trash"></i></a>
                                    <!-- Confirmation modal  -->
                                    <div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1"
                                         style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Are you sure ?</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <form id="remove-form" method="post" action="{{route('brand.destroy', $item->id)}}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">Sure</button>
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
{{--@section('ajax')--}}
{{--    <script type="text/javascript">--}}
{{--        $(document).ready(function () {--}}
{{--            $('#remove-form').on('submit', function (event) {--}}
{{--                event.preventDefault();--}}
{{--                var formData = new FormData(this);--}}
{{--                $.ajax({--}}
{{--                    url: "{{ route('brand.destroy', $item->id)}}",--}}
{{--                    method: 'POST',--}}
{{--                    data: formData,--}}
{{--                    headers: {--}}
{{--                        "X-CSRF-TOKEN": "{{ csrf_token() }}" // Set the CSRF token in the headers--}}
{{--                    },--}}
{{--                    dataType: 'json',--}}
{{--                    contentType: false, // Important: set to false when sending FormData--}}
{{--                    processData: false, // Important: set to false when sending FormData--}}
{{--                    success: function (response) {--}}
{{--                        console.log(response.message);--}}
{{--                        success_noti(response.message);--}}
{{--                        window.location.reload();--}}
{{--                    },--}}
{{--                    error: function (response) {--}}
{{--                        var jsonResponse = $.parseJSON(response.responseText);--}}
{{--                        if (response.status === 404) {--}}
{{--                            if (jsonResponse && jsonResponse.message) {--}}
{{--                                Swal.fire({--}}
{{--                                    icon: 'error',--}}
{{--                                    title: 'Errorrrer',--}}
{{--                                    text: jsonResponse.message,--}}
{{--                                    showCancelButton: false,--}}
{{--                                    confirmButtonText: 'OK',--}}
{{--                                }).then((result) => {--}}
{{--                                    if (result.isConfirmed) {--}}
{{--                                        window.location.reload();--}}
{{--                                    }--}}
{{--                                });--}}
{{--                            }--}}
{{--                        }--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
