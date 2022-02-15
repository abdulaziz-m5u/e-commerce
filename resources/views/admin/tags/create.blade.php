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
                    {{ __('Create tag') }}
                </h6>
                <div class="ml-auto">
                    <a href="{{ route('admin.tags.index') }}" class="btn btn-primary">
                        <span class="text">{{ __('Go Back') }}</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.tags.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name" class="text-small text-uppercase">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control form-control-lg" name="name"
                                    value="{{ old('name') }}">
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
