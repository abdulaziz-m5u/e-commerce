<?php

namespace App\Http\Livewire\Frontend\Products;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class ShopProductsComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $paginationLimit = 12;
    public $slug;
    public $sortingBy = 'default';

    public function render()
    {
        
        switch ($this->sortingBy) {
            case 'popularity':
                $sortField = 'id';
                $sortType = 'desc';
                break;
            case 'low-high':
                $sortField = 'price';
                $sortType = 'asc';
                break;
            case 'high-low':
                $sortField = 'price';
                $sortType = 'desc';
                break;
            default:
                $sortField = 'id';
                $sortType = 'asc';
        }


        if ($this->slug == '') {
            $products = Product::with('category');
        } else {
            $category = Category::where('slug',$this->slug)->first();
         
            if (is_null($category)) {
                $categoriesIds = Category::where('id', $category)->pluck('id')->toArray();
               
                $products = Product::whereHas('category', function ($query) use ($categoriesIds) {
                    $query->whereIn('id', $categoriesIds);
                });

            } else {
                $products = Product::with('category')
                    ->whereHas('category', function ($query) {
                    $query->where([
                        'slug' => $this->slug,
                    ]);
                });
            }
        }

        $products = $products->active()
            ->hasQuantity()
            ->orderBy($sortField, $sortType)
            ->paginate($this->paginationLimit);

        return view('livewire.frontend.products.shop-products-component', compact('products'));
    }
}
