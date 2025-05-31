<!DOCTYPE html>
<html>
<head>
    <title>Flee Market</title>
    <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">ログアウト</button>
</form>
</head>
<body>
    @yield('content')
</body>
</html>