<!DOCTYPE html>
<html>
    <head>
        <title>{{$active['page']['title'] or ''}}</title>
        <meta name="description" content="{{$active['page']['description'] or ''}}">
        <meta http-equiv="content-language" content="de">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1,maximum-scale=1">
        <link rel="shortcut icon" href="{{ asset('/media/favicon.png', Request::secure()) }}">
        <link rel="icon" href="{{ asset('/media/favicon.png', Request::secure()) }}" type="image/x-icon">
        <meta name="theme-color" content="rgb(255,210,0)">
        <link href="{{ asset(env('PATH_PREFIX').elixir('css/app.css'), Request::secure()) }}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400,600" rel="stylesheet" type="text/css">
        @if (env('APP_ENV') !== 'local')
            <script>
              (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
              (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
              m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
              })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
              ga('create', 'UA-1850438-1', 'auto');
              ga('send', 'pageview');
              ga('set', 'anonymizeIp', true);

            </script>
        @endif
    </head>
    <body>
        @include('layout.header')
        <main class="o-content o-grid">
            @yield('content')
        </main>
        @include('layout.footer')
        <script src='{{ asset(env('PATH_PREFIX').elixir("js/app.js"), Request::secure()) }}'></script>
    </body>
</html>
