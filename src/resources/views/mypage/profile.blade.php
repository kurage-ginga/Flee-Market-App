@extends('layouts.app')

@section('content')
<div class="register__content">
    <div class="register-form__heading">
        <h1 class="register-form__heading-title">プロフィール設定</h1>
    </div>
    <form class="register-form" action="{{ route('mypage.profile') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form__group">
            <div class="form__group-content">
                <div class="form__input--text">
                    @if (!empty($user->profile->image_path))
                        <img src="{{ asset('storage/' . $user->profile->image_path) }}" alt="プロフィール画像">
                    @else
                        <img src="{{ asset('images/default-profile.png') }}" alt="デフォルト画像">
                    @endif
                    <input type="file" name="profile_image" accept="image/*" />
                </div>
                <div class="form__error">
                    @error('image')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">ユーザー名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="username" value="{{ old('username') ?? $user->name ?? '' }}" />
                </div>
                <div class="form__error">
                    @error('username')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">郵便番号</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="zipcode" value="{{ old('zipcode') ?? $user->profile->zipcode ?? '' }}" />
                </div>
                <div class="form__error">
                    @error('zipcode')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">住所</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="address" value="{{ old('address') ?? $user->profile->address ?? '' }}" />
                </div>
                <div class="form__error">
                    @error('address')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">建物名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="building" value="{{ old('building') ?? $user->profile->building ?? '' }}" />
                </div>
                <div class="form__error">
                    @error('building')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__button">
            <button class="form__button-submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection