@extends('layouts.app')

@section('content')
    <script>
        window.arrData = {!! json_encode($arrInvoice) !!};
        window.arrFilter = {!! json_encode([
            'customerName' => app('request')->input('customerName'),
            'issueFrom' => app('request')->input('issueFrom'),
            'issueTo' => app('request')->input('issueTo'),
            'dueFrom' => app('request')->input('dueFrom'),
            'dueTo' => app('request')->input('dueTo'),
            ]) !!}
    </script>
    <div id="mainWrapper">
        <invoice-index
                initial-page="{{$page}}"
                initial-total-page="{{$totalPage}}"
                page-url="{{route('home')}}"
                base-url="{{route('home')}}"
        >
        </invoice-index>
    </div>
@endsection