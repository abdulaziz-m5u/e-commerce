<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with('category', 'tags')
            ->active()
            ->whereSlug($slug)
            ->hasQuantity()
            ->firstOrFail();

        $relatedProducts = Product::whereHas('category', function ($query) use ($product) {
            $query->whereId($product->category_id);
        })
            ->where('id', '<>', $product->id)
            ->inRandomOrder()
            ->active()
            ->hasQuantity()
            ->take(4)
            ->get(['id', 'slug', 'name', 'price']);

        return view('frontend.product.show', compact('product', 'relatedProducts'));
    }
}
