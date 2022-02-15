<?php

namespace App\Http\Livewire\Frontend\Products;

use App\Models\Product;
use App\Services\CartService;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TopTrendingProducts extends Component
{
    use LivewireAlert;
    
    public function render()
    {
        return view('livewire.frontend.products.top-trending-products', [
            'products' => Product::select('id', 'slug', 'name', 'price')
                ->take(8)
                ->get()
        ]);
    }

}
