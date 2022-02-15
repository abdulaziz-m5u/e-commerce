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
                {{ __('Tags') }}
            </h6>
            <div class="ml-auto">
            <a href="{{ route('admin.tags.create') }}" class="btn btn-primary btn-sm shadow-sm">{{ __('create new')}} <i class="fa fa-plus"> </i></a>
            </div>
        </div>
        <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>{{ __('No') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Product count') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($tags as $tag)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{ $tag->name }}
                        </td>
                        <td>
                            {{ $tag->products_count }}
                        </td>
                        <td>
                            <a href="{{ route('admin.tags.edit', $tag->id) }}" class="btn btn-info">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <form onclick="return alert('are you sure ? ')" class="d-inline" action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST">
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
                        <td colspan="6">
                            <div class="float-right">
                                {!! $tags->appends(request()->all())->links() !!}
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