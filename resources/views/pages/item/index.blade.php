@extends('layouts.app')

@section('content')
    <script>
        window.arrData = {!! json_encode($arrItem) !!};
        window.arrCategory = {!! json_encode($arrCategory) !!};
        window.arrType = {!! json_encode(\App\Constant::ITEM_TYPES) !!};
        window.arrFilter = {!! json_encode([
            'name' => app('request')->input('name'),
            'category' => empty(app('request')->input('category')) ? '' : app('request')->input('category'),
            'type' => empty(app('request')->input('type')) ? '' : app('request')->input('type'),
            'status' => empty(app('request')->input('isActive')) ? '' : app('request')->input('isActive'),
            ]) !!}
    </script>
    <div id="mainWrapper">
        <item-index
                initial-page="{{$page}}"
                initial-total-page="{{$totalPage}}"
                page-url="{{route('item.index')}}"
                base-url="{{route('home')}}"
        >
        </item-index>
    </div>
@endsection