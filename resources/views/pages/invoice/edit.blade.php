@extends('layouts.app')

@section('content')
    <script>
        window.invoice = {!! json_encode($invoice) !!};
        window.arrItem = {!! json_encode($arrItem) !!};

    </script>
    <div id="mainWrapper">
        <invoice-edit base-url="{{route('home')}}"
        >
        </invoice-edit>
    </div>
@endsection