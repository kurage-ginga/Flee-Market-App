<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\UserProfile;

class PurchaseController extends Controller
{

    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = auth()->user()->load('profile');

        return view('items.purchase', [
            'item' => $item,
            'user' => $user,
        ]);
    }

    public function confirm(Request $request, $item_id)
    {
        // JavaScript以外のリクエストは拒否
        if (!$request->expectsJson()) {
            abort(403, 'StripeセッションはJavaScriptからのみ呼び出せます');
        }

        $paymentMethod = $request->input('payment_method');

        if ($paymentMethod === 'credit') {
            $methodType = 'card';
        } elseif ($paymentMethod === 'convenience_store') {
            $methodType = 'konbini';
        } else {
            abort(422, '対応していない支払い方法です');
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $item = Item::findOrFail($item_id);

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => [$methodType],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.success', ['item_id' => $item->id]),
            'cancel_url' => route('purchase.cancel', ['item_id' => $item->id]),
        ]);

        return response()->json(['id' => $session->id]);
    }

    public function success($item_id)
    {
        $item = Item::findOrFail($item_id);

        if ($item->status !== 1) {
            $item->status = 1; // 1 = 購入済み
            $item->save();

            auth()->user()->purchasedItems()->attach($item->id); // Add to purchase history
        }

        return redirect()->route('auth.mypage')->with('message', '購入が完了しました！');
    }

    public function editAddress($item_id)
    {
        $user = auth()->user();
        $profile = $user->profile;

        return view('items.address', [
            'item_id' => $item_id,
            'profile' => $profile,
        ]);
    }

    public function updateAddress(Request $request, $item_id)
    {
        $request->validate([
            'zipcode' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ], [
            'zipcode.required' => '郵便番号を入力してください',
            'address.required' => '住所を入力してください',
        ]);

        $profile = auth()->user()->profile;
        $profile->update([
            'zipcode' => $request->zipcode,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('purchase.show', ['item_id' => $item_id])->with('message', '住所を更新しました');
    }
}
