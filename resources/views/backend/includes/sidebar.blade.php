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
        <li class="menu-label">User</li>
        <li>
            <a href="{{route('dashboard')}}">
                <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li class="menu-label">Control Panel</li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
                </div>
                <div class="menu-title">Brands</div>
            </a>
            <ul>
                <li> <a href="{{route('brand.create')}}"><i class="bx bx-right-arrow-alt"></i>Add Brand</a>
                </li>
                <li> <a href="{{route('brand.index')}}"><i class="bx bx-right-arrow-alt"></i>Brand List</a>
                </li>
            </ul>
        </li>
    </ul>
    <!--end navigation-->
</div>
