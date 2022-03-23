@extends('layouts.front.app')

@section('content')

    <section id="show">

        @include('layouts.front._nav')

        <div class="movie">

            <div class="movie__bg" style="background: linear-gradient(rgba(0,0,0, 0.6), rgba(0,0,0, 0.6)), url({{$movie->image_path}}) center/cover no-repeat;"></div>

            <div class="container">

                <div class="row">

                    <div class="col-md-8">

                        <div id="player"></div>

                    </div><!-- end of col -->

                    <div class="col-md-4 text-white">
                        <h3 class="movie__name fw-300">{{$movie->name}}</h3>

                        <div class="d-flex movie__rating my-1">
                            <div class="d-flex mr-2">
                            @for($i=0; $i<$movie->rating; $i++)
                                    <span class="fas fa-star text-primary mr-2"></span>
                                @endfor
                            </div>
                            <span class="align-self-center">{{$movie->rating}}</span>
                        </div>


                        <p>Views: <span id="viewsCount">{{$movie->views}}</span></p>


                        <p class="movie__description my-3">
                            {{$movie->description}}
                        </p>

                        @auth()
                            @if($movie->is_favored)
                                <a href="#" data-movie-id="{{$movie->id}}"  data-movie-url="{{route('movie.favorite',$movie->id)}}"class="movie__fav-btn btn btn-danger text-capitalize movie-slider-btn-{{$movie->id}}"><span class="fas fa-heart" data-url="{{route('movie.show', $movie->id)}}"></span> <span class="movie-slider-{{$movie->id}}">Remove from favorite</span></a>
                            @else
                                <a href="#" data-movie-id="{{$movie->id}}" data-movie-url="{{route('movie.favorite',$movie->id)}}" class="movie__fav-btn btn btn-outline-light text-capitalize movie-slider-btn-{{$movie->id}}"><span class="fas fa-heart" data-url="{{route('movie.show', $movie->id)}}"></span>  <span class="movie-slider-{{$movie->id}}">Add to favorite</span></a>
                            @endif
                        @else
                            <a href="{{route('login')}}" class="btn btn-outline-light text-capitalize"><span class="fas fa-heart"></span> add to favorite</a>
                        @endauth
                    </div><!-- end of col -->

                </div><!-- end of row -->

            </div><!-- end of container -->

        </div><!-- end of movie -->


    </section><!-- end of banner section-->


    <section class="listing py-2">

        <div class="container">

            @if(count($related_movies) > 0)
                <div class="row my-4">
                    <div class="col-12 d-flex justify-content-between">
                        <h3 class="listing__title text-white fw-300">Related Movies</h3>
                    </div>
                </div><!-- end of row -->
            @endif
                <div class="movies owl-carousel owl-theme">

                    @foreach($related_movies as $related_movie)

                                <div class="movie p-0">
                                    <img src="{{$related_movie->poster_path}}" class="img-fluid" alt="">

                                    <div class="movie__details text-white">

                                        <div class="d-flex justify-content-between">
                                            <p class="mb-0 movie__name">{{$related_movie->name}}</p>
                                            <p class="mb-0 movie__year align-self-center">{{$related_movie->year}}</p>
                                        </div>

                                        <div class="d-flex movie__rating">
                                            <div class="mr-2">
                                                @for($i=0; $i<$related_movie->rating; $i++)
                                                    <i class="fas fa-star text-primary mr-1"></i>
                                                @endfor
                                            </div>
                                            <span>{{$related_movie->rating}}</span>
                                        </div>

                                        <div class="movie___views">
                                            <p>Views: {{$related_movie->views}}</p>
                                        </div>

                                        <div class="d-flex movie__cta">
                                            <a href="{{route('movie.show', $related_movie->id)}}" class="btn btn-primary text-capitalize flex-fill mr-2"><i class="fas fa-play"></i> watch now</a>
                                            @auth()
                                                <i data-url="{{route('movie.favorite', $related_movie->id)}}" data-movie-id="{{$related_movie->id}}" class="far fa-heart fa-1x align-self-center movie__fav-button movie-{{$related_movie->id}} {{ $related_movie->is_favored ? 'fw-900' : '' }}"></i>
                                            @else
                                                <a href="{{route('login')}}" class="text-white align-self-center"><i class="far fa-heart fa-1x align-self-center movie__fav-button"></i></a>
                                            @endauth
                                        </div>

                                    </div><!-- end of movie details -->
                                </div>

                    @endforeach

                </div>
        </div> <!-- end of container -->
    </section>

    @include('layouts.front._footer')

@endsection

    @push('scripts')

        <script>

            var file =
                "[Auto]{{ Storage::url('movies/' . $movie->id . '/' . $movie->id . '.m3u8') }}," +
                "[360]{{ Storage::url('movies/' . $movie->id . '/' . $movie->id . '_100.m3u8') }}," +
                "[480]{{ Storage::url('movies/' . $movie->id . '/' . $movie->id . '_250.m3u8') }}," +
                "[720]{{ Storage::url('movies/' . $movie->id . '/' . $movie->id . '_500.m3u8') }}";


            var player = new Playerjs({
                id: "player",
                file: file,
                poster: "{{ $movie->image_path }}",
                default_quality: "Auto",
            });


            var duration;
            var time;
            var isDone = false;

            function PlayerjsEvents(event,id,data){

                if(event=="duration"){
                    duration = data;
                }

                if(event=="time"){
                     time = data;
                }

                var percent = (time/duration) * 100;
                if(percent > 10 && !isDone){
                    increaseViews(percent);
                    isDone = true;
                }

            }// end event function

            // use this function to increase count of views in DB
            function increaseViews(data){

                $.ajax({
                    method:"POST",
                    url: "{{ route('movie.increaseViews', $movie->id) }}",
                    data:data,
                    success:function(){
                        // var count = parseInt($('#viewsCount').html());
                        // $('#viewsCount').html(count+1);
                       var count = document.getElementById("viewsCount");
                       var now = parseInt(count.innerHTML);
                       count.innerHTML = now+1;
                    }

                });

            }// end of increaseViews

        </script>

    @endpush


