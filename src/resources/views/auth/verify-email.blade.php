@extends('layouts.app')

@section('content')
<h2>メール認証が必要です</h2>
<p>登録していただいたメールアドレスに確認メールを送付しました。</p>
<p>メール認証を完了してください。</p>
<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit">確認メールを再送信</button>
</form>
@endsection