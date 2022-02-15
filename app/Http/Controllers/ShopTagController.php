<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopTagController extends Controller
{
    public function index($slug)
    {
        return view('frontend.shop_tag.index', compact('slug'));
    }
}
