<!doctype html>
@php $dir = "ltr"; if(app()->getLocale() == 'ar') $dir = "rtl";   @endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{$dir}}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('backend.includes.favicon')
    @include('backend.includes.plugins')
    @yield('plugins')
    @include('backend.includes.css')
    @yield('css')
    <style>
        @yield('style')
        table th, td {
            text-align: center;
            vertical-align: middle;
        }
        table td {
            white-space: nowrap; /* Prevent text from wrapping */
            overflow: hidden; /* Hide overflowing content */
            text-overflow: ellipsis; /* Show an ellipsis (...) for overflowing content */
        }
        .required-star {
            color: red !important; /* Set the color to red */
            margin-left: 5px; /* Add some spacing between the label and asterisk */
        }
        .data-table-img{
            width: 45px;
            height: 45px;
            border-radius: 50%;
        }
        table thead {
            background-color: #0d6efd;
            color: white;
        }
    </style>
    <title>@yield('page-title')</title>

</head>

<body>
<!--wrapper-->
<div class="wrapper">
    <!--sidebar wrapper -->
    @include('backend.includes.sidebar')
    <!--end sidebar wrapper -->

    <!--start header -->
    @include('backend.includes.header')
    <!--end header -->

    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb -->
            @include('backend.includes.breadcrumb')
            <!--end breadcrumb -->
            @yield('content')
        </div>
    </div>
    <!--end page wrapper -->

    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->

    @include('backend.includes.footer')
</div>
<!--end wrapper-->

<!--start switcher-->
<div class="switcher-wrapper">
    <div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
    </div>
    <div class="switcher-body">
        <div class="d-flex align-items-center">
            <h5 class="mb-0 text-uppercase">Theme Customizer</h5>
            <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
        </div>
        <hr/>
        <h6 class="mb-0">Theme Styles</h6>
        <hr/>
        <div class="d-flex align-items-center justify-content-between">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode" checked>
                <label class="form-check-label" for="lightmode">Light</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
                <label class="form-check-label" for="darkmode">Dark</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark">
                <label class="form-check-label" for="semidark">Semi Dark</label>
            </div>
        </div>
        <hr/>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault">
            <label class="form-check-label" for="minimaltheme">Minimal Theme</label>
        </div>
        <hr/>
        <h6 class="mb-0">Header Colors</h6>
        <hr/>
        <div class="header-colors-indigators">
            <div class="row row-cols-auto g-3">
                <div class="col">
                    <div class="indigator headercolor1" id="headercolor1"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor2" id="headercolor2"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor3" id="headercolor3"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor4" id="headercolor4"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor5" id="headercolor5"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor6" id="headercolor6"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor7" id="headercolor7"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor8" id="headercolor8"></div>
                </div>
            </div>
        </div>

        <hr/>
        <h6 class="mb-0">Sidebar Backgrounds</h6>
        <hr/>
        <div class="header-colors-indigators">
            <div class="row row-cols-auto g-3">
                <div class="col">
                    <div class="indigator sidebarcolor1" id="sidebarcolor1"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor2" id="sidebarcolor2"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor3" id="sidebarcolor3"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor4" id="sidebarcolor4"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor5" id="sidebarcolor5"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor6" id="sidebarcolor6"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor7" id="sidebarcolor7"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor8" id="sidebarcolor8"></div>
                </div>
            </div>
        </div>

    </div>
</div>
<!--end switcher-->
<!-- Sweet alert script-->
<script src="{{asset('assets')}}/js/sweetalert2.js"></script>
@include('sweetalert::alert')
@include('backend.includes.js')
@yield('ajax')
@yield('js')

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher("{{env('PUSHER_APP_KEY', 'd62adadb2723d976eec5')}}", {
        cluster: '{{env('PUSHER_APP_CLUSTER', 'ap2')}}',
        encrypted: true,
    });

    var privateChannel = pusher.subscribe('admin-order-notification-channel');
    privateChannel.bind('order-created-event', function(data) {
        $.ajax({
            type: "POST",
            url: "{{route('get-user-notifications')}}",
            headers:{
                "X-CSRF-TOKEN":"{{csrf_token()}}"
            },
            success: function(data) {

                showAlertCount(data.unreadNotificationsCount);
                renderUserNotifications(data.notifications);
            },
            error: function(xhr, status, error) {
            }
        });
    });

    function showAlertCount(count){
        if (count > 0) {
            // Check the data count and show/hide the alert-count span
            const alertCountSpan = $(".alert-count");

            // Check if .alert-count exists and remove it
            if (alertCountSpan.length > 0) {
                alertCountSpan.remove();
            }
            // Create a new alert-count span
            const newAlertCountSpan = $("<span>").addClass("alert-count");
            newAlertCountSpan.text(count);
            newAlertCountSpan.show();
            $("#notification-count-parent").append(newAlertCountSpan);
        }
    }

    function renderUserNotifications(notifications){
        const notificationsContainer = $("#notifications-container");
        notificationsContainer.empty();

        // Loop through the notifications data and generate HTML for each notification
        notifications.forEach(function (notification) {
            const notificationElement = $("<p>").addClass("dropdown-item");
            const formattedCreatedAt = moment(notification.created_at).fromNow();
            const notificationContent = `
                <div class="d-flex align-items-center">
                    <div class="notify bg-light-primary text-primary"><i class="bx bx-group"></i></div>
                    <div class="flex-grow-1">
                        <h6 class="msg-name">${notification.data.title}<span class="msg-time float-end">${formattedCreatedAt}</span></h6>
                        <p class="msg-info">${notification.data.content}</p>
                    </div>
                </div>
            `;
            notificationElement.html(notificationContent);
            notificationsContainer.append(notificationElement);
        });
    }
</script>

<script>
    $(document).ready(function() {
        $("#read-all-notifications").click(function(event) {
            event.preventDefault();

            // Perform an AJAX GET request
            $.ajax({
                type: "GET",
                url: "{{route('read-all-notification')}}",
                success: function(data) {
                    let alertCount = document.querySelector('.alert-count');
                    alertCount.style.display = "none";
                },
                error: function(xhr, status, error) {
                }
            });
        });
    });
</script>
</body>

</html>
