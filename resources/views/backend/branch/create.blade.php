@php
enum DaysOfWeek : int{
  case saturday = 1;
  case sunday   = 2;
  case monday   = 3;
  case tuesday  = 4;
  case wendesay = 5;
  case thursday = 6;
  case friday   = 7;
}

@endphp
@extends('backend.layouts.app')
@section('css')
    /*<!--notification js -->*/
    <link href="{{asset('assets/plugins/notifications/css/lobibox.min.css')}}" rel="stylesheet" />
@endsection
@section('page-title', __('Add Branch'))
@section('breadcrumb-title', __('Branches'))
@section('breadcrumb-sub-titles')
    <li class="breadcrumb-item"><a href="{{route('branch.index')}}"><i class="bx bx-home-alt"></i></a></li>
    <li class="breadcrumb-item active" aria-current="page">@lang('Add Branch')</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="border p-4 rounded">
                <div class="card-title d-flex align-items-center">
                    <h5 class="mb-0 text-info">@lang('Add Branch')</h5>
                </div>
                <hr>
                <form id="data-form" action="{{route('branch.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="branch_name" class="col-sm-3 col-form-label">
                            @lang('Branch Name')<span class="required-star">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input name="branch_name" type="text" class="form-control" id="branch_name" placeholder="{{__('Enter Branch Name')}}" required>
                            <small style="color: #e20000" class="error" id="branch_name-error"></small>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">@lang('Payment Methods')</label>
                        <div class="col-sm-9">
                            @foreach($paymentMethods as $method)
                                <div class="form-check form-switch">
                                    <input name="payment_methods[]" class="form-check-input" type="checkbox" value="{{$method->id}}">
                                    <label class="form-check-label">{{ucfirst($method->method_name)}}</label>
                                </div>
                            @endforeach
                            <small style="color: #e20000" class="error" id="payment_methods-error"></small>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">@lang('Work Days')<span class="required-star">*</span></label>
                        <div class="col-sm-9">
                            @foreach(DaysOfWeek::cases() as $day)
                                <div class="form-check form-switch">
                                    <input name="work_days[]" class="form-check-input" type="checkbox" value="{{$day->value}}">
                                    <label class="form-check-label">{{ucfirst($day->name)}}</label>
                                </div>
                            @endforeach
                            <small style="color: #e20000" class="error" id="work_days-error"></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">@lang('Starting Work Hour')<span class="required-star">*</span></label>
                        <div class="col-sm-9">
                            <input name="work_hours_start" type="time" class="form-control" required>
                            <small style="color: #e20000" class="error" id="work_hours_start-error"></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">@lang('Closing Work Hour')<span class="required-star">*</span></label>
                        <div class="col-sm-9">
                            <input name="work_hours_end" type="time" class="form-control" required>
                            <small style="color: #e20000" class="error" id="work_hours_end-error"></small>
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
                    url: "{{ route('branch.store') }}",
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false, // Important: set to false when sending FormData
                    processData: false, // Important: set to false when sending FormData
                    success: function (response) {
                        // Reset the form
                        $('#data-form')[0].reset();
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
                                    title: "{{trans('general.failed')}}",
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
