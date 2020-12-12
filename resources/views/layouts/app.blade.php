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
    <div id="root" class="uk-flex uk-flex-left">
        <div id="sidebar">
            <div class="sidebar-header">
                Invoice Me
            </div>
            <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
                <li class="<?php echo (url()->current() == route('home') ? "uk-active" : "")?>"><a href="{{ route('home') }}" >Invoice</a></li>
                <li class="<?php echo (url()->current() == route('item.index') ? "uk-active" : "")?>"><a href="{{ route('item.index') }}">Item</a></li>
                <li class="<?php echo (url()->current() == route('category.index') ? "uk-active" : "")?>"><a href="{{ route('category.index') }}">Item Category</a></li>
                <!--
                <li class="uk-parent">
                    <a href="#">Parent</a>
                    <ul class="uk-nav-sub">
                        <li><a href="{{ route('home') }}">Invoice</a></li>
                        <li>
                            <a href="#">Sub item</a>
                            <ul>
                                <li><a href="#">Sub item</a></li>
                                <li><a href="#">Sub item</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="#">Item</a></li>
                -->
            </ul>
        </div>
        <div id="main" class="uk-flex-1">
            <nav class="uk-navbar-container" uk-navbar>
                <div class="uk-navbar-right">

                    <ul class="uk-navbar-nav">
                        <li><a href="{{ route('logout') }}">Logout</a></li>
                    </ul>

                </div>
            </nav>
            <div>
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
