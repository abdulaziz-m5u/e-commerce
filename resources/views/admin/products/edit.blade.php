@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ __('Edit product') }}
                </h6>
                <div class="ml-auto">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                        <span class="text">{{ __('Go Back') }}</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="name" class="text-small text-uppercase">{{ __('Product Name') }}</label>
                                <input id="name" type="text" class="form-control form-control-lg" name="name"
                                    value="{{ old('name', $product->name) }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="price" class="text-small text-uppercase">{{ __('Price') }}</label>
                                <input id="price" type="number" class="form-control form-control-lg" name="price"
                                    value="{{ old('price', $product->price) }}" >
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="quantity" class="text-small text-uppercase">{{ __('quantity') }}</label>
                                <input id="quantity" type="number" max="10000" class="form-control form-control-lg" name="quantity"
                                    value="{{ old('quantity', $product->quantity) }}" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">---</option>
                                    @forelse($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : null }}>
                                            {{ $category->name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="tags">Tag</label>
                                <select name="tags[]" id="tags" class="form-control" multiple>
                                    @forelse($tags as $tag)
                                        <option value="{{ $tag->id }}"
                                            {{ in_array($tag->id, $product->tags->pluck('id')->toArray()) ? 'selected' : null }}>
                                            {{ $tag->name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('tags')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="featured">Featured</label>
                                <select name="featured" id="featured" class="form-control">
                                    <option value="">---</option>
                                    <option value="1" {{ old('featured', $product->featured) == "Yes" ? 'selected' : null }}>Yes</option>
                                    <option value="0" {{ old('featured', $product->featured) == "No" ? 'selected' : null }}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">---</option>
                                    <option value="1" {{ old('status', $product->status) == "Active" ? 'selected' : null }}>Active</option>
                                    <option value="0" {{ old('status', $product->status) == "Inactive" ? 'selected' : null }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description" class="text-small text-uppercase">{{ __('Description') }}</label>
                                <textarea name="description" rows="3" class="form-control summernote">{!! old('description', $product->description) !!}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="details" class="text-small text-uppercase">{{ __('Details') }}</label>
                                <textarea name="details" rows="3" class="form-control summernote">{!! old('details', $product->details) !!}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group {{ $errors->has('gallery') ? 'has-error' : '' }}">
                                <label for="gallery">Gallery</label>
                                <div class="needsclick dropzone" id="gallery-dropzone">

                                </div>
                            </div>
                        </div>
                    </div>
                   

                    <div class="form-group pt-4">
                        <button class="btn btn-primary" type="submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-alt')
<script>
    var uploadedGalleryMap = {}
Dropzone.options.galleryDropzone = {
    url: '{{ route('admin.products.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="gallery[]" value="' + response.name + '">')
      uploadedGalleryMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedGalleryMap[file.name]
      }
      $('form').find('input[name="gallery[]"][value="' + name + '"]').remove()
    },
    init: function () {
        @if(isset($product) && $product->gallery)
            var files =
                {!! json_encode($product->gallery) !!}
                for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.original_url)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="gallery[]" value="' + file.file_name + '">')
                }
        @endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }
         return _results
     }
}
</script>
@endpush
