<!DOCTYPE html>
<html>
    <head>
        <title>{{$active['page']['title'] or ''}}</title>
        <meta name="description" content="{{$active['page']['description'] or ''}}">
        <meta http-equiv="content-language" content="de">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1,maximum-scale=1">
        <meta name="theme-color" content="rgb(255,210,0)">
        <link href="{{ asset(env('PATH_PREFIX').elixir('css/app.css')) }}" rel="stylesheet" type="text/css">
    </head>
    <body>
        @include('layout.header')
        <main class="o-content o-grid">
            @yield('content')
        </main>
        <script src='{{ asset(env('PATH_PREFIX').elixir("js/app.js")) }}'></script>
    </body>
</html>
