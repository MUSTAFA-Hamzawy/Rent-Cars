@extends('backend.layouts.app')
@section('css')
    /*<!--notification js -->*/
    <link href="{{asset('assets/plugins/notifications/css/lobibox.min.css')}}" rel="stylesheet" />
@endsection
@section('page-title', __('Add Car'))
@section('breadcrumb-title', __('Cars'))
@section('breadcrumb-sub-titles')
    <li class="breadcrumb-item"><a href="{{route('car.index')}}"><i class="bx bx-home-alt"></i></a></li>
    <li class="breadcrumb-item active" aria-current="page">@lang('Add Car')</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="border p-4 rounded">
                <div class="card-title d-flex align-items-center">
                    <h5 class="mb-0 text-info">@lang('Add Car')</h5>
                </div>
                <hr>
                <form id="data-form" action="{{route('car.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="car_year" class="col-sm-3 col-form-label">
                            @lang('Year')<span class="required-star">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input name="car_year" type="number" class="form-control" id="car_year" placeholder="{{__('Enter Car Year')}}" required>
                            <small style="color: #e20000" class="error" id="car_year-error"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="car_color" class="col-sm-3 col-form-label">
                            @lang('Car Color')<span class="required-star">*</span>
                        </label>
                        <div class="col-sm-1">
                            <input name="car_color" type="color" class="form-control" id="car_color" required>
                            <small style="color: #e20000" class="error" id="car_color-error"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="car_rent_price" class="col-sm-3 col-form-label">
                            @lang('Car Price (per day)')<span class="required-star">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input step="0.1" min="1" max="32767" name="car_rent_price" type="number" class="form-control" id="car_rent_price" required>
                            <small style="color: #e20000" class="error" id="car_rent_price-error"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="car_available" class="col-sm-3 col-form-label">
                            @lang('Availability')
                        </label>
                        <div class="col-sm-9">
                            <div class="form-check form-switch">
                                <input name="car_available" class="form-check-input" type="checkbox" checked>
                                <label class="form-check-label">@lang('Available')</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="car_branch" class="col-sm-3 col-form-label">
                            @lang('Branch')<span class="required-star">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-select mb-3" aria-label="Default select example" name="car_branch">
                                <option selected="">- - - - - - Choose Branch - - - - -</option>
                                @foreach($branches as $item)
                                    <option value="{{$item->id}}">{{$item->branch_name}}</option>
                                @endforeach
                            </select>
                            <small style="color: #e20000" class="error" id="car_branch-error"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="car_brand" class="col-sm-3 col-form-label">
                            @lang('Car Brand')<span class="required-star">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-select mb-3" aria-label="Default select example" name="car_brand">
                                <option selected="">- - - - - - Choose Brand - - - - -</option>
                                @foreach($brands as $item)
                                    <option value="{{$item->id}}">{{$item->brand_name}}</option>
                                @endforeach
                            </select>
                            <small style="color: #e20000" class="error" id="car_brand-error"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="car_category" class="col-sm-3 col-form-label">
                            @lang('Category')<span class="required-star">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-select mb-3" aria-label="Default select example" name="car_category">
                                <option selected="">- - - - - - Choose Category - - - - -</option>
                                @foreach($categories as $item)
                                    <option value="{{$item->id}}">{{$item->category_name}}</option>
                                @endforeach
                            </select>
                            <small style="color: #e20000" class="error" id="car_category-error"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="car_model" class="col-sm-3 col-form-label">
                            @lang('Car Model')<span class="required-star">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-select mb-3" aria-label="Default select example" name="car_model">
                                <option selected="">- - - - - - Choose Model - - - - -</option>
                                @foreach($models as $item)
                                    <option value="{{$item->id}}">{{$item->model_name}}</option>
                                @endforeach
                            </select>
                            <small style="color: #e20000" class="error" id="car_model-error"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="car_distance_limit" class="col-sm-3 col-form-label">
                            @lang('Car Distance Limit (in KM)')
                        </label>
                        <div class="col-sm-9">
                            <input value="0" step="0.1" min="0" max="2147483647" name="car_distance_limit" type="number"  class="form-control" id="car_distance_limit">
                            <small style="color: #e20000" class="error" id="car_distance_limit-error"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="over_distance_fees" class="col-sm-3 col-form-label">
                            @lang('Over Distance Fees (per KM )')
                        </label>
                        <div class="col-sm-9">
                            <input step="0.1" value="0" min="0" max="32767" name="over_distance_fees" type="number" class="form-control" id="over_distance_fees" >
                            <small style="color: #e20000" class="error" id="over_distance_fees-error"></small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="multi_image" class="col-sm-3 col-form-label">
                            @lang('Car Images')<span class="required-star">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input name="car_images[]" class="form-control" type="file" id="multi_image" multiple="" required>
                            <div class="row" id="preview_img" style="padding: 20px"></div>
                            <small style="color: #e20000" class="error" id="car_images-error"></small>
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

    <script>

        $(document).ready(function(){
            $('#multi_image').on('change', function(){ //on file input change
                if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
                {
                    var data = $(this)[0].files; //this file data

                    $.each(data, function(index, file){ //loop though each file
                        if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                            var fRead = new FileReader(); //new filereader
                            fRead.onload = (function(file){ //trigger function on successful read
                                return function(e) {
                                    var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(130)
                                        .height(120); //create image element
                                    $('#preview_img').append(img); //append image to output element
                                    $('#preview_img').show();
                                };
                            })(file);
                            fRead.readAsDataURL(file); //URL representing the file's data.
                        }
                    });

                }else{
                    alert("Your browser doesn't support File API!"); //if File API is absent
                }
            });
        });

    </script>

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
                    url: "{{ route('car.store') }}",
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false, // Important: set to false when sending FormData
                    processData: false, // Important: set to false when sending FormData
                    success: function (response) {
                        // Reset the form
                        $('#data-form')[0].reset();
                        $('#preview_img').attr('src', null);
                        $('#preview_img').hide();

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
