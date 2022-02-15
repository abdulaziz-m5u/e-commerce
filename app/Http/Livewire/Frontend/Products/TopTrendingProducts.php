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

    public function addToCart($productId)
    {
        $product = Product::whereId($productId)->active()->hasQuantity()->firstOrFail();
        try {
            (new CartService())->addToList('default', $product);
            $this->emit('update_cart');
            $this->alert('success', 'added to Cart.');
        } catch(\Exception $exception) {
            $this->alert('warning', $exception->getMessage());
        }
    }
}
