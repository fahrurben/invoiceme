<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Invoice Me</title>

    <!-- Fonts -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Roboto">

    <!-- Styles -->
    <style>

    </style>

    <link href="{{ asset('css/app.css')}}" rel="stylesheet">

    <script src="{{ asset('js/app.js')}}"></script>
</head>
<body>
<div>
    @yield('content')
</div>
</body>
</html>
