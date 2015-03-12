<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Framgia English Learning System')</title>
    <link rel="shortcut icon" href="{{ url_ex('favicon.ico') }}">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    @include('layout_admins.metadata')
    @include('layout_admins.styles')
    @yield('styles')
    @include('layout_admins.scripts')
    @yield('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="skin-blue">
<section class="content">
            @yield('content')
        </section>
</body>
</html>
