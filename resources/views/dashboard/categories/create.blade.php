@extends('layouts.dashboard.app')


@section('content')

    <div>
        <h1>Add Category</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.categories.index') }}">Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Category</li>
        </ol>
    </nav>

    <div class="tile mb-4">
        <form action="{{ route('dashboard.categories.store') }}" method="POST">

            @csrf
            @method('POST')
    
            @include('dashboard.partials._errors')

            <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>
            </div>
        </form>    
    </div>

@endsection