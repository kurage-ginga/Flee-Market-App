@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="heading">
            <div class="heading__group">
                <img src="{{ asset('storage/' . $user->profile->profile_image) }}" alt="プロフィール画像">
                <div class="heading__title">{{ $user->profile->username ?? $user->name }}</div>
                <a class="mypage__profile" href="{{route ('mypage.profile')}}">プロフィールを編集</a>
            </div>
        </div>
    </div>

    <div class="tabs">
        <a href="?page=buy" class="{{ $tab === 'buy' ? 'active' : '' }}">購入した商品</a>
        <a href="?page=sell" class="{{ $tab === 'sell' ? 'active' : '' }}">出品した商品</a>
    </div>

    <div class="item-detail__section">
        <a href="{{ route('items.index') }}" class="btn btn-secondary">← 一覧に戻る</a>
    </div>

    @if ($tab === 'buy' || $tab === null)
        <h3>購入商品</h3>
        @foreach ($purchasedItems as $item)
            <div>
                <a href="{{ route('items.item', ['id' => $item->id]) }}">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像" style="width: 150px;">
                    <div>{{ $item->name }}</div>
                </a>
            </div>
        @endforeach
    @else
        <h3>出品商品</h3>
        @foreach ($sellingItems as $item)
            <div>
                <a href="{{ route('items.item', ['id' => $item->id]) }}">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像" style="width: 150px;">
                    <div>{{ $item->name }}</div>
                </a>
            </div>
        @endforeach
    @endif
@endsection