@extends('layouts.app')

@section('content')
<script src="https://js.stripe.com/v3/"></script>

<div class="purchase">
    <div class="purchase__header">
        <img src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像" class="purchase__image">
        <div class="purchase__info">
            <h2 class="purchase__name">{{ $item->name }}</h2>
            <p class="purchase__price">¥{{ number_format($item->price) }}</p>
        </div>
    </div>

    <form id="payment-form">
        @csrf

        <div class="purchase__section">
            <label for="payment_method">支払い方法</label>
            <select name="payment_method" id="payment_method" required>
                <option value="">選択してください</option>
                <option value="convenience_store">コンビニ支払い</option>
                <option value="credit">カード支払い</option>
            </select>
        </div>

        <div class="purchase__section">
            <label>配送先住所</label>
            <p>〒{{ $user->profile->zipcode }}</p>
            <p>{{ $user->profile->address }} {{ $user->profile->building }}</p>
            <a href="{{ route('address.edit', ['item_id' => $item->id]) }}" class="btn btn-secondary">変更する</a>
        </div>

        <div class="purchase__summary">
            <p>商品代金：<strong>¥{{ number_format($item->price) }}</strong></p>
            <p>支払い方法：<span id="selected-method">選択してください</span></p>
        </div>

        <button type="submit" id="checkout-button" class="btn btn-primary">購入する</button>
        <div class="item-detail__section">
            <a href="{{ route('items.index') }}" class="btn btn-secondary">← 一覧に戻る</a>
        </div>
    </form>

    <script>
        const stripe = Stripe("{{ config('services.stripe.public') }}");

        document.getElementById('payment-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const paymentMethod = document.getElementById('payment_method').value;

            fetch("{{ route('purchase.confirm', ['item_id' => $item->id]) }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },

                body: JSON.stringify({
                    payment_method: paymentMethod
                })
            })
            .then(response => response.json())
            .then(session => {
                return stripe.redirectToCheckout({ sessionId: session.id });
            })
            .then(result => {
                if (result.error) {
                    alert(result.error.message);
                }
            });
        });

        document.getElementById('payment_method').addEventListener('change', function () {
            const selected = this.options[this.selectedIndex].text;
            document.getElementById('selected-method').textContent = selected;
        });
    </script>
</div>
@endsection