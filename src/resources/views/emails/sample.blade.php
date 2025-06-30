@component('mail::message')
# メール送信テスト

これは MailHog で確認するためのテストメールです。

@component('mail::button', ['url' => 'http://localhost:8000'])
アプリを開く
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent