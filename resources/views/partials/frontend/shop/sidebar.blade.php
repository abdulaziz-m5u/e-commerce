<div class="shop-sidebar mr-50">
    <div class="sidebar-widget mb-40">
        <h3 class="sidebar-title">CATEGORIES</h3>
        @forelse($categories_menu as $category)
            <div class="py-2 px-4 bg-dark text-white mb-3">
                <strong class="small text-uppercase font-weight-bold">
                    <a class="text-decoration-none text-white" href="{{ route('shop.index', $category->slug) }}">
                        {{ $category->name }}
                    </a>
                </strong>
            </div>
            <ul class="list-unstyled small text-muted pl-lg-4 font-weight-normal">
                @forelse($category->childrens as $sub_category)
                    <li class="mb-2">
                        <a class="reset-anchor" href="{{ route('shop.index', $sub_category->slug) }}">
                            {{ $sub_category->name }}
                        </a>
                    </li>
                @empty
                @endforelse
            </ul>
        @empty
        @endforelse
    </div>
    <div class="sidebar-widget mb-40">
        <h3 class="sidebar-title">TAGS</h3>
        <hr style="margin-top: 0; margin-bottom: 10px; border: solid 1px;">
        <div class="price_filter">
{{--            <div id="slider-range"></div>--}}
            <div class="price_slider_amount">
                <div class="sidebar-categories">
                    <ul>
                        @foreach($tags_menu as $tag)
                            <span style="background: #ebebeb none repeat scroll 0 0; color: #333;
                            display: inline-block; font-size: 12px; line-height: 20px; margin:
                            5px 5px 0 0; padding: 5px 15px; text-transform: capitalize;">
                                <a href="{{ route('shop.tag', $tag->slug) }}">
                                    {{ $tag->name }}
                                    ({{ $tag->products_count }})
                                </a>
                            </span>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>