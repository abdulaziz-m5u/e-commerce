@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ __('Edit category') }}
                </h6>
                <div class="ml-auto">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
                        <span class="text">{{ __('Go Back') }}</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" id="name" type="text" name="name" value="{{ old('name', $category->name) }}">
                                @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="category_id">Parent Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">---</option>
                                    @forelse($mainCategories as $mainCategory)
                                        @if($category->name != $mainCategory->name)
                                        <option value="{{ $mainCategory->id }}"  {{ old('parent_id', $category->category_id) == $mainCategory->id ? 'selected' : null }}>
                                            {{ $mainCategory->name }}
                                        </option>
                                        @endif
                                    @empty
                                        <option value="" disabled>No categories found</option>
                                    @endforelse
                                </select>
                                @error('category_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row pt-4">
                        <div class="col-12">
                            <label for="cover">Cover image</label>
                            @if($category->cover)
                                <img
                                    class="mb-2"
                                    src="{{ Storage::url('images/categories/' . $category->cover) }}"
                                    alt="{{ $category->name }}" width="100" height="100">
                            @else
                                <img
                                    class="mb-2"
                                    src="{{ asset('img/no-img.png') }}" alt="{{ $category->name }}" width="60" height="60">
                            @endif
                            <br>
                            <input type="file" name="cover">
                            <span class="form-text text-muted">Image width should be 500px x 500px</span>
                            @error('cover')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group pt-4">
                        <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection