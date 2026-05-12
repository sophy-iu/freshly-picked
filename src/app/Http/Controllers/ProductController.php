<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('seasons')->paginate(6);

        return view('index', compact('products'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $sort = $request->input('sort');

        $query = Product::with('seasons');

        // 商品名検索
        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        // 並び替え
        if ($sort === 'high') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'low') {
            $query->orderBy('price', 'asc');
        }

        $products = $query->paginate(6);

        return view('search', compact('products', 'keyword', 'sort'));
    }

    public function show($productId)
    {
        $product = Product::with('seasons')->findOrFail($productId);
        $seasons = Season::all();

        return view('detail', compact('product', 'seasons'));
    }

    public function create()
    {
        $seasons = Season::all();

        return view('register', compact('seasons'));
    }

    public function store(ProductRequest $request)
    {
        // 画像保存
        $imagePath = $request->file('image')->store('images/products', 'public');

        // 商品保存
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => 'storage/' . $imagePath,
            'description' => $request->description,
        ]);

        // 季節保存（中間テーブル）
        $product->seasons()->attach($request->seasons);

        // 商品一覧へ戻る
        return redirect('/products');
    }

    public function update(ProductRequest $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/products', 'public');
            $data['image'] = 'storage/' . $imagePath;
        }

        $product->update($data);

        $product->seasons()->sync($request->seasons);

        return redirect('/products' . $product->id);
    }

    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);

        $product->delete();

        return redirect('/products');
    }
}
