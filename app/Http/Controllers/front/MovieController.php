<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function show(Movie $movie){

        if($movie->percent == 100){

            $related_movies = Movie::where("id", "!=", $movie->id)->relatedMovies($movie->categories->pluck("id")->toArray())->get();
            return view('front.movies.show', compact('movie', 'related_movies'));

        }

        return redirect(route('welcome'));

    }



    public function indexBy(){


            if(request()->ajax()){
                $movies = Movie::searchMovie(request()->search)->get();

                return $movies;
            }

            $movies = Movie::searchCategory(request()->category_name)->searchFavored(request()->favored)->paginate(20);

        return view('front.movies.indexBy', compact('movies'));
    }
    public function increaseViews(Movie $movie){

//        $movie->views = $movie->views+1;
//        $movie->save();

        $movie->increment("views");

    }

    public function addToFavorite(Movie $movie){

        // if else
        $movie->is_favored ? $movie->users()->detach(auth()->user()->id) : $movie->users()->attach(auth()->user()->id);

    }
}
