<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Category;
use App\Models\Condition;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user_id) {
            // 特定ユーザーの商品一覧（プロフィール画面）
            $items = Item::where('user_id', $request->user_id)->get();
        } else {
            // 全商品（トップページ等）
            $items = Item::all();
        }

        return view('items.index', compact('items'));
    }

    public function show($id)
    {
        $item = Item::with(['comments', 'categories'])->findOrFail($id);
        return view('items.item', compact('item'));
    }

    // いいね押下でいいね登録
    public function favorite(Item $item)
    {
        $item->favoritedBy()->attach(auth()->id());
        return back();
    }

    // いいね再押下でいいね解除
    public function unfavorite(Item $item)
    {
        $item->favoritedBy()->detach(auth()->id());
        return back();
    }

    // コメント機能
    public function store(CommentRequest $request, $id)
    {

        $item = Item::findOrFail($id);

        $item->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('item_images', 'public'); // storage/app/public/item_images に保存

                ItemImage::create([
                    'item_id' => $item->id,
                    'image_path' => $path,
                ]);
            }
        }

        return back();
    }

    // 出品機能
    public function create()
    {
        return view('items.sell', [
            'categories' => Category::all(),
            'conditions' => Condition::all()
        ]);
    }

}
