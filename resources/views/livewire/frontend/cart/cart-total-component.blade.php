<div class="col-md-5 ml-auto">
    <div class="cart-page-total pt-0">
        @if($cartTotal != 0)
        <h2>Cart totals</h2>
        <ul>
            <li>Subtotal<span>${{ $cartSubTotal }}</span></li>
            <li>Total<span>${{ $cartTotal }}</span></li>
        </ul>
        @endif
    </div>
</div>