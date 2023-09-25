@extends('backend.layouts.app')
@section('page-title', $item->model_name)
@section('breadcrumb-title', trans('Models'))
@section('breadcrumb-sub-titles')
    <li class="breadcrumb-item"><a href="{{route('model.index')}}"><i class="bx bx-home-alt"></i></a></li>
    <li class="breadcrumb-item active" aria-current="page">@lang('Model')</li>
    <li class="breadcrumb-item active" aria-current="page">{{$item->model_name}}</li>
@endsection
@section('content')
    <div>
        <h3>@lang('Model info')</h3>
        <div class="col">
            <div class="card">
                <div class="row g-0">
                    <div class="col-md-8">
                        <div class="card-body">
                            <h4 class="card-title">{{$item->model_name}}</h4>
                            <dl class="row">
                                <dt class="col-sm-3">@lang('Created')</dt>
                                <dd class="col-sm-9">{{$item->created_at->diffForHumans()}}</dd>

                                <dt class="col-sm-3">@lang('Last Updated')</dt>
                                <dd class="col-sm-9">{{$item->updated_at->diffForHumans()}}</dd>
                            </dl>

                            <div class="d-flex gap-3 mt-3">
                                <a href="{{route('model.edit', $item->id)}}" class="btn btn-warning">
                                    <span class="text">@lang('Edit')</span> <i class='bx bxs-edit'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(count($item->cars) > 0)
        <hr>
        <div >
            <h3>@lang('Model Cars')</h3>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 product-grid">
                @foreach($item->cars as $car)
                    <div class="col">
                        <div class="card" style="padding: 15px">
                            <a href="{{route('car.show', $car->id)}}">
                                <img style="width: 100%" src="{{$car->getRandomImageSrc()}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h6 class="card-title cursor-pointer">{{$car->car_title}}</h6>
                                    <div class="clearfix">
                                        <p class="mb-0 float-start"> <strong>@lang('Price Per Day')</strong></p>
                                        <p class="mb-0 float-end fw-bold"><span>${{$car->price_per_day}}</span></p>
                                    </div>
                                    <div class="clearfix">
                                        <p class="mb-0 float-start"> <strong>@lang('Distance Limit')</strong></p>
                                        <p class="mb-0 float-end fw-bold"><span>{{$car->distance_limit}} KM</span></p>
                                    </div>
                                    <div class="clearfix">
                                        <p class="mb-0 float-start"> <strong>@lang('Model')</strong></p>
                                        <p class="mb-0 float-end fw-bold"><span>{{$car->model->brand_name}} KM</span></p>
                                    </div>
                                    <div class="clearfix">
                                        <p class="mb-0 float-start"> <strong>@lang('Model')</strong></p>
                                        <p class="mb-0 float-end fw-bold"><span>{{$car->model->model_name}} KM</span></p>
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
