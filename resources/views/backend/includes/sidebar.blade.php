<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{asset("assets/images/logo-icon.png")}}" class="logo-icon" alt="logo icon">
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
                <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
                </div>
                <div class="menu-title">@lang('sidebar.dashboard')</div>
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
    </ul>
    <!--end navigation-->
</div>
