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

    public function mypage(Request $request)
    {
        $user = Auth::user()->load('profile');

        $tab = $request->query('page', 'buy');

        $purchasedItems = $user->purchasedItems()->get();
        $sellingItems = $user->sellingItems()->get();

        return view('auth.mypage', [
            'user' => $user,
            'purchasedItems' => $purchasedItems,
            'sellingItems' => $sellingItems,
            'tab' => $tab,
        ]);
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
            $profileData['profile_image'] = $path;
        }

        //user_idの紐付け、プロフィールデータの保存
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
            'zipcode' => $validated['zipcode'],
            'address' => $validated['address'],
            'building' => $validated['building'],
            'profile_image' => $path ?? $user->profile->profile_image ?? null,
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
            $profileData['profile_image'] = $path;
        }

        //user_idの紐付け、プロフィールデータの保存
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'zipcode' => $validated['zipcode'],
                'address' => $validated['address'],
                'building' => $validated['building'],
                'profile_image' => $path ?? $user->profile->profile_image ?? null,
            ]
        );

        return redirect()->route('mypage.profile');
    }
}