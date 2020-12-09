@extends('layouts.app')

@section('content')
    <script>
        window.arrItem = {!! json_encode($arrItem) !!};

    </script>
    <div id="mainWrapper">
        <invoice-create base-url="{{route('home')}}"
        >
        </invoice-create>
    </div>
@endsection