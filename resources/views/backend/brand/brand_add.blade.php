@extends('backend.layouts.app')
@section('PageTitle', 'Add new brand')
@section('content')

    <!--breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Brand</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add new brand</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb -->

    <div class="card">
        <div class="card-body">
            <h4 class="d-flex align-items-center mb-3">Add brand</h4>
            <br>
            <form id="brand_form" action="brand_create" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Brand Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input name="brand_name" type="text" class="form-control"
                               required autofocus/>
                        <small style="color: #e20000" class="error" id="brand_name-error"></small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Brand Image</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input name="brand_image" id="brand_image" class="form-control" type="file" >
                        <small style="color: #e20000" class="error" id="brand_image-error"></small>

                        <div>
                            <img class="card-img-top"
                                 style="max-width: 250px; margin-top: 20px" id="show_image">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="submit" class="btn btn-primary px-4" value="Save Changes"
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('tags-input-script')
<script src="{{asset('assets')}}/plugins/input-tags/js/tagsinput.js"></script>
@endsection
