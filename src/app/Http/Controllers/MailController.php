<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\SampleTestMail;

class MailController extends Controller
{
    public function sendTestMail()
    {
        Mail::to('test@example.com')->send(new SampleTestMail());
        return 'メール送信完了';
    }
}