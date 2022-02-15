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
                {{ __('Categories') }}
            </h6>
            <div class="ml-auto">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm shadow-sm">{{ __('create new')}} <i class="fa fa-plus"> </i></a>
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
                    <th>Product count</th>
                    <th>Parent</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($category->cover)
                                <img src="{{ Storage::url('images/categories/' . $category->cover) }}"
                                     width="60" height="60" alt="{{ $category->name }}">
                            @else
                                <img src="{{ asset('img/no-img.png') }}" width="60" height="60" alt="{{ $category->name }}">
                            @endif
                        </td>
                        <td>
                            {{ $category->name }}
                        </td>
                        <td>{{ $category->products_count }}</td>
                        <td>{{ $category->category->name ?? '' }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-info">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <form onclick="return alert('are you sure ? ')" class="d-inline" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
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
                        <td class="text-center" colspan="6">No categories found.</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="float-right">
                                {!! $categories->appends(request()->all())->links() !!}
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