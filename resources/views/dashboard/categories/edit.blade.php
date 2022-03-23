@extends('layouts.dashboard.app')


@section('content')

    <div>
        <h1>Edit Category</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.categories.index') }}">Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    <div class="tile mb-4">
        <form action="{{ route('dashboard.categories.update',$category->id) }}" method="POST">

            @csrf
            @method('PUT')
    
            @include('dashboard.partials._errors')
            
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name',$category->name) }}">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-info"><i class="fa fa-edit"></i> Edit</button>
            </div>
            
        </form>    
    </div>

@endsection