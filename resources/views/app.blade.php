<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gym Court Business</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div id="app"></div>
        
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>