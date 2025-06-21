@extends('layouts.app')

@section('content')
<div class="item-list__tabs">
    <ul class="item-list__tabs-menu">
        <li class="item-list__tab {{ request('tab') !== 'mylist' ? 'is-active' : '' }}">
            <a href="{{ route('items.index', ['tab' => 'all']) }}">おすすめ</a>
        </li>
        <li class="item-list__tab {{ request('tab') === 'mylist' ? 'is-active' : '' }}">
            <a href="{{ route('items.index', ['tab' => 'mylist']) }}">マイリスト</a>
        </li>
    </ul>
</div>

<div class="item-list__grid">
    @foreach ($items as $item)
        <div class="item-card">
            <a href="{{ route('items.item', ['id' => $item->id]) }}">
                <div class="item-card__image">
                    @if ($item->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $item->images->first()->image_path) }}" alt="商品画像">
                    @endif
                    @if ($item->status === 1)
                        <div class="item-card__label item-card__label--sold">SOLD</div>
                    @endif
                </div>
                <div class="item-card__name">
                    {{ $item->name }}
                </div>
            </a>
        </div>
    @endforeach
</div>
@endsection