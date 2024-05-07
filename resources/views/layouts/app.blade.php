<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        {{ $scripts }}

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        {{ $styles }}
    </head>
    <body class="sidebar-mini layout-fixed layout-navbar-fixed" style="height: auto;">
        <div class="wrapper">

            <x-navbar />
            
            <x-sidebar />

            <div class="content-wrapper" style="min-height: 478px;">

                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">{{ $contentHeader }}</h1>
                            </div>
                            <div class="col-sm-6">
                                {{ $breadcrumbs }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content">
                    {{ $slot }}
                </div>

            </div>

            <x-footer />
        </div>

    </body>
</html>
