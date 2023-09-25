@extends('backend.layouts.app')
@section('page-title', $item->car_title)
@section('breadcrumb-title', trans('Cars'))
@section('breadcrumb-sub-titles')
    <li class="breadcrumb-item"><a href="{{route('car.index')}}"><i class="bx bx-home-alt"></i></a></li>
    <li class="breadcrumb-item active" aria-current="page">@lang('Car')</li>
    <li class="breadcrumb-item active" aria-current="page">{{$item->car_title}}</li>
@endsection
@section('content')
    <div class="card" style="padding: 20px">
        <div class="row g-0">
            <div class="col-md-4 border-end">
                <img src="{{$item->getRandomImageSrc()}}" class="img-fluid" alt="...">
                <div class="row mb-3 row-cols-auto g-2 justify-content-center mt-3">
                @foreach($item->getCarImagesSrc() as $image)
                    <div class="col"><img src="{{$image}}" width="70" class="border rounded cursor-pointer" alt="Image"></div>
                @endforeach
                </div>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h4 class="card-title">{{$item->car_title}}</h4>
                    <dl class="row">
                        <dt class="col-sm-3">@lang('Price Per Day')</dt>
                        <dd class="col-sm-9">${{$item->price_per_day}}</dd>

                        <dt class="col-sm-3">@lang('Model')</dt>
                        <dd class="col-sm-9">{{$item->model->model_name}}</dd>

                        <dt class="col-sm-3">@lang('Car Color')</dt>
                        <dd class="col-sm-9"><div class="color-indigator-item" style="background-color:{{$item->car_color}}"></div></dd>

                        <dt class="col-sm-3">@lang('Created')</dt>
                        <dd class="col-sm-9">{{$item->created_at->diffForHumans()}}</dd>

                        <dt class="col-sm-3">@lang('Last Updated')</dt>
                        <dd class="col-sm-9">{{$item->updated_at->diffForHumans()}}</dd>
                    </dl>
                    <div class="d-flex gap-3 mt-3">
                        <a href="{{route('car.edit', $item->id)}}" class="btn btn-warning">
                            <span class="text">@lang('Edit')</span> <i class='bx bxs-edit'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
