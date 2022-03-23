@extends('layouts.front.app')

@section('content')


    <section class="listing" style="height: 100vh; padding: 8% 0;">

        <div class="container text-white">

            <div class="row">

                <div class="col">

                    <h2 class="fw-300">{{ request()->category_name ? request()->category_name: 'Favorite'}} Movies</h2>

                </div><!-- end of col -->

            </div><!-- end of row -->



        @include('layouts.front._nav')

            <div class="row {{request()->favored}}">
           @if(count($movies) > 0)
            @foreach($movies as $movie)
                    <div class="movie test col-md-3  my-3 p-0">

                    <img src="{{$movie->poster_path}}" class="img-fluid" alt="">

                    <div class="movie__details text-white">

                        <div class="d-flex justify-content-between">
                            <p class="mb-0 movie__name">{{$movie->name}}</p>
                            <p class="mb-0 movie__year align-self-center">{{$movie->year}}</p>
                        </div>

                        <div class="d-flex movie__rating">
                            <div class="mr-2">
                                @for($i=0; $i<$movie->rating; $i++)
                                    <i class="fas fa-star text-primary mr-1"></i>
                                @endfor
                            </div>
                            <span>{{$movie->rating}}</span>
                        </div>

                        <div class="movie___views">
                            <p>Views: {{$movie->views}}</p>
                        </div>

                        <div class="d-flex movie__cta">
                            <a href="{{ route('movie.show', $movie->id) }}" class="btn btn-primary text-capitalize flex-fill mr-2"><i class="fas fa-play"></i> watch now</a>

                            @auth()
                                <i data-url="{{route('movie.favorite', $movie->id)}}" data-movie-id="{{$movie->id}}" class="far fa-heart fa-1x align-self-center movie__fav-button movie-{{$movie->id}} {{ $movie->is_favored ? 'fw-900' : '' }}"></i>
                            @else
                                <a href="{{route('login')}}" class="text-white align-self-center"><i class="far fa-heart fa-1x align-self-center movie__fav-button"></i></a>
                            @endauth
                        </div>

                    </div><!-- end of movie details -->

                </div><!-- end of col -->
             @endforeach
         @else
              <h5>No any movies yet!</h5>
        @endif
            </div>
        </div>


    </section>

@endsection
