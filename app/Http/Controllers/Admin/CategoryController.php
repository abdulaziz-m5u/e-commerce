<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Traits\ImageUploadTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\CategoryRequest;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');   
        $categories = Category::with('category')->withCount('products')->latest()->paginate(5); 

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mainCategories = Category::whereNull('category_id')->get(['id', 'name']);

        return view('admin.categories.create', compact('mainCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $image = NULL;
        if ($request->hasFile('cover')) {
            $image = $this->uploadImage($request->name, $request->cover, 'categories', 500);
        }

        Category::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'cover' => $image
        ]);

        return redirect()->route('admin.categories.index')->with('message','Successfully created !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $mainCategories = Category::whereNull('category_id')->get(['id', 'name']);

        return view('admin.categories.edit', compact('category','mainCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request,Category $category)
    {
        $image = $category->cover;
        if ($request->has('cover')) {
            if ($category->cover != null && File::exists('storage/images/categories/'. $category->cover)) {
                unlink('storage/images/categories/'. $category->cover);
            }
            $image = $this->uploadImage($request->name, $request->cover, 'categories', 500, NULL);
        }

        $category->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'cover' => $image
        ]);

        return redirect()->route('admin.categories.index')->with('message','Successfully updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->cover) {
            if (File::exists('storage/images/categories/'. $category->cover)) {
                unlink('storage/images/categories/'. $category->cover);
            }
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('message','Successfully deleted !');
    }
}
