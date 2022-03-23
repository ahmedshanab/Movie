@extends('layouts.dashboard.app')


@section('content')

    <div>
        <h1>Edit Movie</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.movies.index') }}">Movies</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Movie</li>
        </ol>
    </nav>

    <div class="tile mb-4">

        <form action="{{ route('dashboard.movies.update',['type' => 'update', 'movie' => $movie->id])  }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')
            @include('dashboard.partials._errors')

            <div>
                <label for="movie_name">Name</label>
                <input type="text" id="movie_name" name="movie_name" value="{{ $movie->name }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="movie_description">Description</label>
                <textarea name="movie_description" id="movie_description" class="form-control">{{ $movie->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="movie_poster">Poster</label>
                <input type="file" name="movie_poster" id="movie_poster" class="form-control">
                <img src="{{ $movie->poster_path }}" style="height: 378px; width: 255px; margin-top: 10px;">
            </div>

            <div class="form-group">
                <label for="movie_image">Image</label>
                <input type="file" name="movie_image" id="movie_image" class="form-control">
                <img src="{{ $movie->image_path }}" style="margin-top: 10px;">
            </div>

            <div class="form-group">

                <label for="">Categories</label>

                <select id="categories_select" name="categories[]" class="select2 form-control" multiple required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ in_array($category->id, $movie->categories->pluck('id')->toArray()) ? 'selected':''  }} >{{$category->name}}</option>
                    @endforeach
                </select>

            </div>

            <div class="form-group">
                <label for="movie_year">Year</label>
                <input type="text" name="movie_year" id="movie_year" value="{{ $movie->year }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="movie_rating">Rating</label>
                <input type="text" name="movie_rating" id="movie_rating" value="{{ $movie->rating }}" class="form-control">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</button>
            </div>
        </form>

    </div>



@endsection
