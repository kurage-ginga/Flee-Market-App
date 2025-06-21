@extends('layouts.app')

@section('content')
<div class="sell-container">
    <h2>商品の出品</h2>

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label>商品画像</label>
            <input type="file" name="images[]" multiple accept="image/*">
        </div>

        <div>
            <label>カテゴリー</label>
            <div class="category-list">
                @foreach ($categories as $category)
                    <label>
                        <input type="radio" name="category_id" value="{{ $category->id }}">
                        <span>{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div>
            <label>商品の状態</label>
            <select name="condition_id" required>
                <option value="" disabled selected>選択してください</option>
                @foreach ($conditions as $condition)
                    <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>商品名</label>
            <input type="text" name="name" required>
        </div>

        <div>
            <label>ブランド名</label>
            <input type="text" name="brand_name">
        </div>

        <div>
            <label>商品の説明</label>
            <textarea name="description" rows="4" required></textarea>
        </div>

        <div>
            <label>販売価格</label>
            <input type="number" name="price" required>
        </div>

        <div>
            <button type="submit">出品する</button>
        </div>
    </form>
</div>
@endsection