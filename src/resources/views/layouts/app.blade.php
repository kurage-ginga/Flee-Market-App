<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'フリマアプリ')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__logo">
                <a href="/">
                    <img src="{{ asset('storage/images/logo.svg') }}" alt="ロゴ">
                </a>
            </div>

            <div class="header__search">
                <form action="{{ route('items.search') }}" method="POST">
                    @csrf
                    <input type="text" name="keyword" class="keyword" placeholder="何をお探しですか？" value="{{ old('keyword', $searchKeyword ?? '') }}">
                    <button type="submit" class="submit-button">検索</button>
                </form>
            </div>

            <nav class="header__nav">
                <ul class="header__list">
                    @auth
                        <li class="header-nav__item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="header-nav__logout">ログアウト</button>
                            </form>
                        </li>
                    @else
                        <li class="header-nav__item">
                            <a class="header-nav__login" href="{{ route('login') }}">ログイン</a>
                        </li>
                    @endauth
                    <li class="header-nav__item">
                        <a class="header-nav__mypage" href="{{ route('auth.mypage') }}">マイページ</a>
                    </li>
                    <li class="header-nav__item">
                        <a class="header-nav__sell" href="{{ route('items.sell') }}">出品</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
