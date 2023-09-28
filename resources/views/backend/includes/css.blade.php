    <!-- loader-->
    <link href="{{asset('assets')}}/css/pace.min.css" rel="stylesheet" />
    <script src="{{asset('assets')}}/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="{{asset('assets')}}/css/bootstrap.min.css" rel="stylesheet">
    @if(app()->getLocale() == 'ar')
        <link href="{{asset('assets')}}/css/app_ar.css" rel="stylesheet">
    @else
        <link href="{{asset('assets')}}/css/app.css" rel="stylesheet">
    @endif
    <link href="{{asset('assets')}}/css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{asset('assets')}}/css/dark-theme.css" />
    <link rel="stylesheet" href="{{asset('assets')}}/css/semi-dark.css" />
    <link rel="stylesheet" href="{{asset('assets')}}/css/header-colors.css" />
