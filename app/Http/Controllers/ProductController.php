<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $products = Cache::remember('products_listing', now()->addHour(), function () {
            return Product::with('category')->get();
        });

        return response()->json([
            'data' => $products,
            'message' => 'Product listing',
            'success' => true
        ]);
    }

    public function show(Request $request, $productId)
    {
        $product = Cache::remember("product_{$productId}", now()->addHour(), function () use($productId) {
            return Product::with('category')->find($productId);
        });

        return response()->json([
            'data' => $product,
            'message' => 'Product',
            'success' => true
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'description' => 'required|string',
            'product_category_id' => 'required|exists:product_categories,id',
        ], [
            'product_category_id.exists' => 'The selected product category is invalid.'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock_quantity = $request->stock_quantity;
        $product->description = $request->description;
        $product->product_category_id = $request->product_category_id;
        $product->save();

        return response()->json([
            'data' => $product,
            'message' => 'Product created successfully',
            'success' => true
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'description' => 'required|string',
            'product_category_id' => 'required|exists:product_categories,id',
        ], [
            'product_category_id.exists' => 'The selected product category is invalid.'
        ]);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock_quantity = $request->stock_quantity;
        $product->description = $request->description;
        $product->product_category_id = $request->product_category_id;
        $product->save();

        return response()->json([
            'data' => $product,
            'message' => 'Product updated successfully',
            'success' => true
        ]);
    }

    public function delete(Request $request, Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
            'success' => true
        ],200);
    }

}
