@extends('backend.layouts.app')
@section('css')
    /*<!--notification js -->*/
    <link href="{{asset('assets/plugins/notifications/css/lobibox.min.css')}}" rel="stylesheet" />
@endsection
@section('page-title', trans('Edit Order'))
@section('breadcrumb-title', trans('Orders'))
@section('breadcrumb-sub-titles')
    <li class="breadcrumb-item"><a href="{{route('order.index')}}"><i class="bx bx-home-alt"></i></a></li>
    <li class="breadcrumb-item active" aria-current="page">@lang('Edit Order')</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="border p-4 rounded">
                <div class="card-title d-flex align-items-center">
                    <h5 class="mb-0 text-info">@lang('Edit Order')</h5>
                </div>
                <hr>
                <form id="data-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="order_status" class="col-sm-3 col-form-label">
                            @lang('Status')<span class="required-star">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-select mb-3" aria-label="Default select example" name="order_status">

                                <option value="0" @if($item->order_status == 0) selected @endif>Pending</option>
                                <option value="-1" @if($item->order_status == -1) selected @endif>Cancelled</option>
                                <option value="1" @if($item->order_status == 1) selected @endif>Confirmed</option>
                            </select>
                            <small style="color: #e20000" class="error" id="order_status-error"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="total_cost" class="col-sm-3 col-form-label">
                            @lang('Total Cost')<span class="required-star">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input name="total_cost" type="text" class="form-control" id="total_cost" value="{{$item->total_cost}}" required>
                            <small style="color: #e20000" class="error" id="total_cost-error"></small>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <input type="submit" class="btn btn-info px-5" value="{{trans('general.save')}}"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!--notification js -->
    <script src="{{asset('assets')}}/plugins/notifications/js/lobibox.min.js"></script>
    <script src="{{asset('assets')}}/plugins/notifications/js/notifications.min.js"></script>
    <script src="{{asset('assets')}}/plugins/notifications/js/notification-custom-script.js"></script>
@endsection

@section('ajax')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#data-form').on('submit', function (event) {
                event.preventDefault();
                // remove errors labels
                $('#data-form *').filter(':input.is-invalid').each(function(){
                    this.classList.remove('is-invalid');
                });
                $('#data-form *').filter('.error').each(function(){
                    this.innerHTML = '';
                });

                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('order.update', $item->id)}}",
                    method: 'POST',
                    data: formData,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}" // Set the CSRF token in the headers
                    },
                    dataType: 'json',
                    contentType: false, // Important: set to false when sending FormData
                    processData: false, // Important: set to false when sending FormData
                    success: function (response) {
                        // Reset the form
                        $('#upload_image').val('');
                        $('#image_preview').attr('src', null);
                        $('#image_preview').hide();

                        // remove errors if the conditions are true
                        $('#data-form *').filter(':input.is-invalid').each(function(){
                            this.classList.remove('is-invalid');
                        });
                        $('#data-form *').filter('.error').each(function(){
                            this.innerHTML = '';
                        });
                        success_noti(response.message, {{app()->getLocale() == 'ar'}});
                    },
                    error: function (response) {
                        var jsonResponse = $.parseJSON(response.responseText);
                        $.each(jsonResponse.errors, function (key, err){
                            $('#' + key + '-error').text(err[0]);
                            $('#' + key ).addClass('is-invalid');
                        });
                        if (response.status === 404) {
                            if (jsonResponse && jsonResponse.message) {
                                Swal.fire({
                                    icon: 'error',
                                    title: "{{trans('general.fail')}}",
                                    text: jsonResponse.message,
                                    showCancelButton: false,
                                    confirmButtonText: 'OK',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
