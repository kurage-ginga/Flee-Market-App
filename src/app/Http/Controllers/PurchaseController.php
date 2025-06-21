<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemImage;

class PurchaseController extends Controller
{

    public function show($item_id)
    {
        $item = Item::with('images')->findOrFail($item_id);
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

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $item = Item::findOrFail($item_id);

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
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
}
