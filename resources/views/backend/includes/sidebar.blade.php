<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{asset('logo.png')}}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">{{env('APP_NAME')}}</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li class="menu-label">@lang('sidebar.user')</li>
        <li>
            <a href="{{route('dashboard')}}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">@lang('sidebar.dashboard')</div>
            </a>
        </li>
        <li>
            <a href="{{route('profile.show')}}">
                <div class="parent-icon"><i class='bx bx-user'></i>
                </div>
                <div class="menu-title">@lang('sidebar.profile')</div>
            </a>
        </li>
        <li class="menu-label">@lang('sidebar.control_panel')</li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
                </div>
                <div class="menu-title">@lang('sidebar.brands')</div>
            </a>
            <ul>
                <li> <a href="{{route('brand.create')}}"><i class="bx bx-right-arrow-alt"></i>@lang('sidebar.add_brand')
                    </a>
                </li>
                <li> <a href="{{route('brand.index')}}"><i class="bx bx-right-arrow-alt"></i>@lang('sidebar.brand_list')
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
                </div>
                <div class="menu-title">@lang('sidebar.categories')</div>
            </a>
            <ul>
                <li> <a href="{{route('category.create')}}"><i class="bx bx-right-arrow-alt"></i>@lang('sidebar.add_category')
                    </a>
                </li>
                <li> <a href="{{route('category.index')}}"><i class="bx bx-right-arrow-alt"></i>@lang('sidebar.category_list')
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
                </div>
                <div class="menu-title">@lang('sidebar.models')</div>
            </a>
            <ul>
                <li> <a href="{{route('model.create')}}"><i class="bx bx-right-arrow-alt"></i>@lang('sidebar.add_model')
                    </a>
                </li>
                <li> <a href="{{route('model.index')}}"><i class="bx bx-right-arrow-alt"></i>@lang('sidebar.model_list')
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
                </div>
                <div class="menu-title">@lang('sidebar.payment_methods')</div>
            </a>
            <ul>
                <li> <a href="{{route('payment_method.create')}}"><i class="bx bx-right-arrow-alt"></i>@lang('sidebar.add_payment_method')
                    </a>
                </li>
                <li> <a href="{{route('payment_method.index')}}"><i class="bx bx-right-arrow-alt"></i>@lang('sidebar.payment_method_list')
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
                </div>
                <div class="menu-title">@lang('sidebar.branch')</div>
            </a>
            <ul>
                <li> <a href="{{route('branch.create')}}"><i class="bx bx-right-arrow-alt"></i>@lang('Add Branch')
                    </a>
                </li>
                <li> <a href="{{route('branch.index')}}"><i class="bx bx-right-arrow-alt"></i>@lang('Branch List')
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
                </div>
                <div class="menu-title">@lang('Cars')</div>
            </a>
            <ul>
                <li> <a href="{{route('car.create')}}"><i class="bx bx-right-arrow-alt"></i>@lang('Add Car')
                    </a>
                </li>
                <li> <a href="{{route('car.index')}}"><i class="bx bx-right-arrow-alt"></i>@lang('Car List')
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <!--end navigation-->
</div>
