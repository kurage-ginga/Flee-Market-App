@extends('layouts.app')

@section('title', '商品詳細')

@section('content')
<div class="item-detail">
    <div class="item-detail__wrapper">
        <!-- 左側：商品画像 -->
        <div class="item-detail__image">
            @if ($item->image_path)
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像">
            @endif
        </div>

        <!-- 右側：商品情報 -->
        <div class="item-detail__info">
            <h1 class="item-detail__title">{{ $item->name }}</h1>
            <p class="item-detail__brand">{{ $item->brand ?? 'ブランド不明' }}</p>
            <p class="item-detail__price">￥{{ number_format($item->price) }} <span class="tax">(税込)</span></p>

            <div class="item-detail__actions">
                @auth
                    @if (auth()->user()->favorites->contains($item->id))
                        <!-- いいね済み -->
                        <form method="POST" action="{{ route('items.unfavorite', $item->id) }}">
                            @csrf
                            <button class="favorite">☆{{ $item->favoritedBy->count() }}</button>
                        </form>
                    @else
                        <!-- 未いいね -->
                        <form method="POST" action="{{ route('items.favorite', $item->id) }}">
                            @csrf
                            <button>☆{{ $item->favoritedBy->count() }}</button>
                        </form>
                    @endif
                    <button class="comment-btn">💬{{ $item->comments->count() }}</button>
                @else
                    <button disabled>☆{{ $item->favoritedBy->count() }}</button>
                    <button class="comment-btn" disabled>💬{{ $item->comments->count() }}</button>
                @endauth
            </div>

            <a href="{{ route('purchase.show', ['item_id' => $item->id]) }}" class="purchase-btn">購入手続きへ</a>

            <div class="item-detail__section">
                <h3>商品説明</h3>
                <p>{{ $item->description }}</p>
                <ul>
                    <li>カラー：{{ $item->color ?? '未指定' }}</li>
                    <li>状態：{{ $item->condition->name ?? '不明' }}</li>
                </ul>
            </div>

            <div class="item-detail__section">
                <h3>商品の情報</h3>
                <p>カテゴリー：
                    @foreach($item->categories as $category)
                        <span class="tag">{{ $category->name }}</span>
                    @endforeach
                </p>
                <p>商品の状態：{{ $item->condition->name ?? '不明' }}</p>
            </div>

            <div class="item-detail__section">
                <h3>コメント ( {{ $item->comments->count() }} )</h3>
                @foreach ($item->comments as $comment)
                    <div class="comment">
                        <strong>{{ $comment->user->name }}</strong>
                        <p>{{ $comment->content }}</p>
                    </div>
                @endforeach
            </div>

            <div class="item-detail__section">
                <h3>商品へのコメント</h3>
                    <form method="post" action="{{ route('items.comment', ['id' => $item->id]) }}">
                    @csrf
                        <textarea name="content" rows="3">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        @auth
                            <button type="submit" class="comment-submit-btn">コメントを送信する</button>
                        @else
                            <button type="submit" class="comment-submit-btn" disabled>コメントを送信する</button>
                        @endauth
                    </form>
                <div class="item-detail__section">
                    <a href="{{ route('items.index') }}" class="btn btn-secondary">← 一覧に戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection