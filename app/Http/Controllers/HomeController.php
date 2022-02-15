<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::select('slug', 'cover', 'name')
        ->whereCategoryId(null)
        ->limit(4)
        ->get();
         
        return view('frontend.homepage', compact('categories'));
    }

    public function search(Request $request)
    {
        $data = Product::select('slug', 'name')
            ->where('name', 'LIKE', '%'.$request->productName. '%')
            ->active()
            ->hasQuantity()
            ->take(5)
            ->get();

        return response()->json($data);
    }
}
