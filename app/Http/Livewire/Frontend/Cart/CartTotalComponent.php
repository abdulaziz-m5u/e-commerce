<?php

namespace App\Http\Livewire\Frontend\Cart;

use App\Models\Coupon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CartTotalComponent extends Component
{
    use LivewireAlert;

    public $cartSubTotal;
    public $cartTotal;

    protected $listeners = [
        'update_cart' => 'mount'
    ];

    public function mount()
    {
        $this->cartSubTotal = getNumbersOfCart()->get('subtotal');
        $this->cartTotal = getNumbersOfCart()->get('total');
    }

    public function render()
    {
        return view('livewire.frontend.cart.cart-total-component');
    }
}
