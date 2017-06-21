<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script type="text/javascript">
            window.Laravel = {
                echoHost: '{{ env('ECHO_HOST') }}',
                echoPort: '{{ env('ECHO_PORT') }}',
            }
        </script>

        <title>Waterfall</title>
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <div id="app">
            <router-view></router-view>
        </div>
        <script src="/js/app.js"></script>
    </body>
</html>
