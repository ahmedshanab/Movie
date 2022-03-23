@extends('layouts.dashboard.app')

@push('style')
    <style>

        .upload-movie{
            justify-content:center;
            align-items:center;
            flex-direction:column;
            height:30vh;
            border: 1px solid black;
            background-color:gainsboro;
            cursor:pointer;
        }

    </style>
@endpush

@section('content')

    <div>
        <h1>Add Movie</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.movies.index') }}">Movies</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Movie</li>
        </ol>
    </nav>

    <div class="tile mb-4">

        <div class="upload-movie" style="display: {{ $errors->any() ? 'none' : 'flex;' }}">
            <i class="fa fa-video-camera fa-2x"></i>
            <p>Click to upload</p>
        </div>

        <input class="movie_file" data-action="{{ route('dashboard.movies.index') }}" data-store-route="{{route('dashboard.movies.store')}}"  data-recorde-route="{{route('dashboard.make_recorde')}}" name="movie_file" type="file" style="display:none">
        <input type="hidden" class="id_movie" name="movie_id" value="">

        <form id="form_properties" enctype="multipart/form-data" action="" method="POST" style="display:{{ $errors->any() ? 'block' : 'none' }}">

            @csrf
            @method('PUT')
            @include('dashboard.partials._errors')

            <div class="form-group" style="display: {{ $errors->any() ? 'none' : 'block' }}">
                <label id="progress_label">Uploading...</label>
                <div class="progress">
                    <div class="progress-bar" id="progress_upload_movie" role="progressbar"></div>
                  </div>
            </div>

            <div>
                <label for="movie_name">Name</label>
                <input type="text" id="movie_name" name="movie_name" value="{{ old('movie_name') }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="movie_description">Description</label>
                <textarea name="movie_description" id="movie_description" value="{{ old('movie_description') }}" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="movie_poster">Poster</label>
                <input type="file" name="movie_poster" id="movie_poster" value="{{ old('movie_poster') }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="movie_image">Image</label>
                <input type="file" name="movie_image" id="movie_image" value="{{ old('movie_image') }}" class="form-control" required>
            </div>

            <div class="form-group">

                <label for="">Categories</label>

                <select id="categories_select" name="categories[]" class="select2 form-control" multiple required>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>

            </div>

            <div class="form-group">
                <label for="movie_year">Year</label>
                <input type="text" name="movie_year" id="movie_year" value="{{ old('movie_year') }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="movie_rating">Rating</label>
                <input type="text" name="movie_rating" id="movie_rating" value="{{ old('movie_rating') }}" class="form-control">
            </div>

            <div class="form-group" >
                <button type="submit" id="submit_form" style="display:{{ $errors->any() ? 'block' : 'none'}}" class="btn btn-primary"><i class="fa fa-plus"></i> Publish</button>
            </div>

        </form>

    </div>

    <script>



    </script>
@endsection
