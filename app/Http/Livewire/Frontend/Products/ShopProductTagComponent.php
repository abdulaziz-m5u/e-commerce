<?php

namespace App\Http\Livewire\Frontend\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ShopProductTagComponent extends Component
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

        $products = Product::with('tags')->whereHas('tags', function ($query) {
            $query->where([
                'slug' => $this->slug,
            ]);
        })
            ->active()
            ->hasQuantity()
            ->orderBy($sortField, $sortType)
            ->paginate($this->paginationLimit);

        return view('livewire.frontend.products.shop-products-component', compact('products'));
    }
}
