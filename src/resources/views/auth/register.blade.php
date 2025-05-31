@extends('layouts.app')

@section('content')
<h2>会員登録</h2>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <input type="text" name="name" placeholder="ユーザー名" required>
    <input type="email" name="email" placeholder="メールアドレス" required>
    <input type="password" name="password" placeholder="パスワード" required>
    <input type="password" name="password_confirmation" placeholder="確認用パスワード" required>
    <button type="submit">登録する</button>
</form>
@endsection