<!DOCTYPE html>
<html lang="en-US">
<head>
@include('includes.head')
@yield('custom-assets')
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        @include('includes.header')
        @include('includes.main-sidebar')
        <div class="content-wrapper">
            @yield('content')
        </div>
        @include('includes.footer')
    </div>
    @include('includes.scripts')
    @yield('custom-scripts')
    @yield('custom-grid')
</body>
</html>
