<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>フリマアプリ</title>
</head>
<body>
    <div class="header">
        <div class="header__inner">
            <h1 class=header__logo>coachtech</h1>
            <nav class="header__nav">
                <ul class="header__list">
                    <form action="/products/search" method="POST">
                        @csrf
                        <input type="text" name="keyword" class="keyword" placeholder="何をお探しですか？">
                        <button type="submit" class="submit-button">検索</button>
                    </form>
                    @auth
                    <li class="header-nav__item">
                        <form action="/logout" method="post">
                            @csrf
                            <a class="header-nav__logout" type="submit" href="{{route ('login')}}">ログアウト</a>
                        </form>
                    </li>
                    @else
                        <form action="/login" method="post">
                            <a class="header-nav__login" type="submit" href="{{route ('login')}}">ログイン</a>
                        </form>
                    @endauth
                    <li class="header-nav__item">
                        <a class="header-nav__mypage" href="{{route ('auth.mypage')}}">マイページ</a>
                    </li>
                    <li class="header-nav__item">
                        <a href="{{ route('items.sell') }}" class="header-nav__sell">出品</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <main>
        @yield('content')
    </main>
</body>
</html>