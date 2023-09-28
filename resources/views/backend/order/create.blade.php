@extends('backend.layouts.app')
@section('css')
    /*<!--notification js -->*/
    <link href="{{asset('assets/plugins/notifications/css/lobibox.min.css')}}" rel="stylesheet" />
@endsection
@section('page-title', trans('Add Brand'))
@section('breadcrumb-title', trans('Brands'))
@section('breadcrumb-sub-titles')
    <li class="breadcrumb-item"><a href="{{route('brand.index')}}"><i class="bx
                bx-home-alt"></i></a></li>
    <li class="breadcrumb-item active" aria-current="page">@lang('Add Brand')</li>
@endsection
    @section('content')
        <div class="card">
            <div class="card-body">
                <div class="border p-4 rounded">
                    <div class="card-title d-flex align-items-center">
                        <h5 class="mb-0 text-info">@lang('Add Brand')</h5>
                    </div>
                    <hr>
                    <form id="data-form" action="{{route('brand.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="brand_name" class="col-sm-3 col-form-label">
                                @lang('Enter Brand Name')<span class="required-star">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input name="brand_name" type="text" class="form-control" id="brand_name"
                                       placeholder="{{trans('Enter Brand Name')}}" required>
                                <small style="color: #e20000" class="error" id="brand_name-error"></small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="mytextarea" class="col-sm-3 col-form-label">
                                @lang('Brand Description')
                            </label>
                            <div class="col-sm-9">
                                <textarea id="mytextarea" name="brand_description"></textarea>
                            </div>
                            <small style="color: #e20000" class="error" id="brand_description-error"></small>
                        </div>
                        <div class="row mb-3">
                            <label for="upload_image" class="col-sm-3 col-form-label">
                                @lang('general.upload_logo')<span class="required-star">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input name="brand_logo" id="upload_image" class="form-control" type="file" required>
                                <small style="color: #e20000" class="error" id="brand_logo-error"></small>
                                <img id="image_preview" src="" alt="Preview Image"
                                     style="width: 200px; height:170px;display: none; margin-top: 10px">
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

    <script src="{{asset('assets')}}/js/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea'
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#upload_image').change(function (e) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image_preview').attr('src', e.target.result);
                    $('#image_preview').show(); // Show the image
                }
                reader.readAsDataURL(e.target.files[0]);
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
                    url: "{{ route('brand.store') }}",
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
