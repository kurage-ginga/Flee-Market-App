<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->input('page', 'all');

        $searchKeyword = session('search_keyword');

        // 未ログイン + マイリスト指定された場合は何も出さない
        if ($tab === 'mylist') {
            if (!$user) {
                $items = collect(); // 空のコレクションを返す
            } else {
                $query = $user->favorites();

                if ($searchKeyword) {
                    $query->where(function($q) use ($searchKeyword) {
                        $q->where('name', 'like', "%{$searchKeyword}%")
                        ->orWhere('description', 'like', "%{$searchKeyword}%");
                    });
                }

                $items = $query->get();
            }
        } else {
            $query = Item::where('status', 0);

            // ログイン中なら自分の商品を除く
            if ($user) {
                $query->where('user_id', '!=', $user->id);
            }

            if ($searchKeyword) {
                $query->where(function($q) use ($searchKeyword) {
                    $q->where('name', 'like', "%{$searchKeyword}%")
                    ->orWhere('description', 'like', "%{$searchKeyword}%");
                });
            }

            $items = $query->get();
        }

        return view('items.index', [
            'items' => $items,
            'tab' => $tab,
            'searchKeyword' => $searchKeyword,
        ]);
    }

    public function show($id)
    {
        $item = Item::with(['comments', 'categories'])->findOrFail($id);
        return view('items.item', compact('item'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        session(['search_keyword' => $keyword]);

        $items = Item::where('name', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->where('status', 0)
            ->with('user', 'categories', 'condition')
            ->get();

        return view('items.index', [
            'items' => $items,
            'tab' => 'all',
            'searchKeyword' => $keyword
        ]);
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
    public function comment(CommentRequest $request, $id)
    {

        $item = Item::findOrFail($id);

        $item->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('item_images', 'public'); // storage/app/public/item_images に保存
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'condition_id' => 'required|exists:conditions,id',
            'images_path' => 'required|image|max:2048',
        ]);

        $path = $request->file('images_path')->store('item_images', 'public');

        Item::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'status' => 0, // 出品中
            'image_path' => $path, // アップロード済み画像
            'category_id' => $request->category_id,
            'condition_id' => $request->condition_id,
        ]);

        return redirect()->route('items.index')->with('success', '商品を出品しました');
    }

}
