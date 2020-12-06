@extends('layouts.app')

@section('content')
    <script>
        window.arrData = {!! json_encode($arrCategory) !!};
        window.arrFilter = {!! json_encode([
            'name' => app('request')->input('name'),
            'status' => empty(app('request')->input('isActive')) ? '' : app('request')->input('isActive'),
            ]) !!}
    </script>
    <div id="mainWrapper">
        <category-index
                initial-page="{{$page}}"
                initial-total-page="{{$totalPage}}"
                page-url="{{route('category.index')}}"
                base-url="{{route('home')}}"
        >
        </category-index>
    </div>
@endsection