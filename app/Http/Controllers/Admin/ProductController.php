<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->when(
            request()->q,
            function ($products) {
                $products = $products->where('title', 'like', '%' . request()->q . '%');
            }
        )->paginate(10);

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::latest()->get();

        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'title' => 'required|unique:products',
            'category_id' => 'required',
            'content' => 'required',
            'weight' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'stock' => 'required'
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        // save to database
        $product = Product::create([
            'image' => $image->hashName(),
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'content' => $request->content,
            'unit' => $request->unit,
            'weight' => $request->weight,
            'price' => $request->price,
            'discount' => $request->discount,
            'keywords' => $request->keywords,
            'description' => $request->description,
            'stock' => $request->stock
        ]);

        if ($product) {
            // redirect dengan pesan sukses
            return redirect()->route('admin.product.index')->with(['success' => 'Data Berhasil Disimpan !']);
        } else {
            // redirect dengan pesan error
            return redirect()->route('admin.product.index')->with(['error' => 'Data Gagal Disimpan !']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::latest()->get();

        return view('admin.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'title' => 'required|unique:products,title,' . $product->id,
            'category_id' => 'required',
            'content' => 'required',
            'weight' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'stock' => 'required',
        ]);

        // cek jika image kosong
        if ($request->file('image') == '') {
            // update tanpa image
            $product = Product::findOrFail($product->id);
            $product->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-'),
                'category_id' => $request->category_id,
                'content' => $request->content,
                'unit' => $request->unit,
                'weight' => $request->weight,
                'price' => $request->price,
                'discount' => $request->discount,
                'keywords' => $request->keywords,
                'description' => $request->description,
                'stock' => $request->stock
            ]);
        } else {
            // hapus image lama
            Storage::disk('local')->delete('public/products/' . $product->image);

            // upload image baru
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            // update dengan image
            $product = Product::findOrFail($product->id);
            $product->update([
                'image' => $image->hashName(),
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-'),
                'category_id' => $request->category_id,
                'content' => $request->content,
                'unit' => $request->unit,
                'weight' => $request->weight,
                'price' => $request->price,
                'discount' => $request->discount,
                'keywords' => $request->keywords,
                'description' => $request->description,
                'stock' => $request->stock
            ]);
        }
        if ($product) {
            // redirect dengan pesan sukses
            return redirect()->route('admin.product.index')->with(['success' => 'Data Berhasil Diupdate !']);
        } else {
            return redirect()->route('admin.product.index')->with(['error' => 'Data Gagal Diupdate !']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $image = Storage::disk('local')->delete('public/products/' . $product->image);
        $product->delete();

        if ($product) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
