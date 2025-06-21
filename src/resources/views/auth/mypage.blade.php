@extends('layouts.app')

@section('content')
<div class="content">
    <div class="heading">
        <div class="heading__group">
            <img src="{{ asset('storage/' . $user->profile->image_path) }}" alt="プロフィール画像">
            <div class="heading__title">{{ $user->profile->username ?? $user->name }}</div>
            <a class="mypage__profile" href="{{route ('mypage.profile')}}">プロフィールを編集</a>
        </div>
    </div>
</div>
@endsection