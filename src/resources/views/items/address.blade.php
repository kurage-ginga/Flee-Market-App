@extends('layouts.app')

@section('content')
<div class="address-edit">
    <h2>住所の変更</h2>

    <form method="POST" action="{{ route('address.update', ['item_id' => $item_id]) }}">
        @csrf

        <div>
            <label for="zipcode">郵便番号</label>
            <input type="text" name="zipcode" value="{{ old('zipcode', $profile->zipcode) }}">
            @error('zipcode')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="address">住所</label>
            <input type="text" name="address" value="{{ old('address', $profile->address) }}">
            @error('address')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="building">建物名</label>
            <input type="text" name="building" value="{{ old('building', $profile->building) }}">
        </div>

        <button type="submit">更新する</button>
    </form>
</div>
@endsection