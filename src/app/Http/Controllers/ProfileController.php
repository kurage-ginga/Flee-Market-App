<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user()->load('profile');

        return view('mypage.profile', compact('user'));
    }

    public function mypage()
    {
        $user = Auth::user()->load('profile');

        return view('auth.mypage', compact('user'));
    }

    public function store(Request $request)
    {
        //バリデーション
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'zipcode' => 'required|string',
            'address' => 'required|string',
            'building' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        //users_tableからデータ取得、ユーザー名の更新
        $user = auth()->user();
        $user->name = $validated['username'];
        $user->save();

        // 画像アップロード処理
        $path = null;
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
        }

        //user_idの紐付け、プロフィールデータの保存
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
            'zipcode' => $validated['zipcode'],
            'address' => $validated['address'],
            'building' => $validated['building'],
            'image_path' => $path ?? $user->profile->image_path ?? null,
            ]
        );

        return redirect()->route('items.index');
    }

    public function update(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'zipcode' => 'required|string',
            'address' => 'required|string',
            'building' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        //users_tableからデータ取得、ユーザー名の更新
        $user = auth()->user();
        $user->name = $validated['username'];
        $user->save();

        // 画像アップロード処理
        $path = null;
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
        }

        //user_idの紐付け、プロフィールデータの保存
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'zipcode' => $validated['zipcode'],
                'address' => $validated['address'],
                'building' => $validated['building'],
                'image_path' => $path ?? $user->profile->image_path ?? null,
            ]
        );

        return redirect()->route('mypage.profile');
    }
}