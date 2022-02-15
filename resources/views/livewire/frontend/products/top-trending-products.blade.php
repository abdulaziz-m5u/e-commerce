<div id="all-products" class="product-style-area pt-130 pb-30 wow fadeInUp">
    <div class="section-title-furits text-center mb-95">
        <img src="{{ asset('frontend/img/icon-img/49.png') }}" alt="">
        <h2>TOP TRENDING PRODUCTS</h2>
    </div>
    <div class="container">
        <div class="row">
            @forelse($products as $product)
                <div class="col-lg-4 col-xl-3 col-md-6">
                    <div class="product-fruit-wrapper mb-60">
                        <div class="product-fruit-img">
                            @if($product->gallery)
                                <img src="{{ $product->gallery[0]->url }}"
                                     alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('img/cartwhite.png' ) }}" alt="">
                            @endif
                            <div class="product-furit-action">
                                <a style="cursor: pointer;"
                                   class="furit-animate-left" title="Add To Cart">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <a 
                                   class="furit-animate-right" title="Wishlist">
                                    <i class="fas fa-heart"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-fruit-content text-center">
                            <h4>
                                <a href="">{{ $product->name }}</a>
                            </h4>
                            <span>${{ $product->price }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <p>No products found.</p>
            @endforelse
        </div>
    </div>
</div>
