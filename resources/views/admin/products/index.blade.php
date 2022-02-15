@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    @if(session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ __('Products') }}
            </h6>
            <div class="ml-auto">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm shadow-sm">{{ __('create new')}} <i class="fa fa-plus"> </i></a>
            </div>
        </div>
        <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Feature</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Tags</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="d-flex" style="column-gap: .5rem;">
                            @if($product->gallery)
                                @foreach($product->gallery as $key => $media)
                                    <a style="text-decoration: none;" href="{{ $media->getUrl() }}" target="_blank">
                                        <img src="{{ $media->getUrl() }}" width="50px" height="50px">
                                    </a>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            {{ $product->name }}
                        </td>
                        <td>{{ $product->featured }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>Rp {{ $product->price }}</td>
                        <td>
                            @foreach($product->tags as $tag)
                                <span class="badge badge-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <span class="badge badge-warning">{{ $product->category ? $product->category->name : NULL }}</span>
                        </td>
                        <td>{{ $product->status }}</td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-info">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <form onclick="return alert('are you sure ? ')" class="d-inline" action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="12">No categories found.</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="12">
                            <div class="float-right">
                                {!! $products->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        </div>
    </div>
</div>
@endsection