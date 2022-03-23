<?php

namespace App\Http\Controllers\dashboard;

use App\Movie;
use App\category;
use App\Jobs\StreamMovie;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct(){

        $this->middleware('permission:create_movies')->only(['create', 'store']);
        $this->middleware('permission:read_movies')->only(['index']);
        $this->middleware('permission:update_movies')->only(['edit', 'update']);
        $this->middleware('permission:delete_movies')->only(['destroy']);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){



        $movies = Movie::searchMovie(request()->search)->searchCategory(request()->category)->paginate(5);

        $categories = category::all();

        return view("dashboard.movies.index", compact('movies','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $categories = category::all();

        return view('dashboard.movies.create', compact('categories'));
    }

    public function makeRecorde(){
        $movie = Movie::create([]);
        return $movie;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $movie = Movie::FindOrFail($request->movie_id);

        $movie->update([
            'name' => $request->movie_name,
            'path' => $request->file('movie_file')->store('movies'),
        ]);

        $this->dispatch(new StreamMovie($movie));

        return $movie;
    }

    public function show(Movie $movie){

        return $movie;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie){

//        $categories = DB::table('category_movie')->select('category_id')->where('movie_id', '=', $movie->id)->get();

        $categories = category::all();

        return view('dashboard.movies.edit', compact('movie','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie){

        if($request->type == 'publish'){

            $request->validate([
                'movie_name'        => 'required|unique:movies,name,' . $movie->id,
                'movie_description' => 'required',
                'movie_poster'      => 'required|nullable|image',
                'movie_image'       => 'required|nullable|image',
                'categories'        => 'required',
                'movie_year'        => 'required',
                'movie_rating'      => 'required',
            ]);

            $array = $request->categories;
            $categories = explode(',', $array[0]);
            $categories = array_map("intval", $categories);

        }else{

            $request->validate([
                'movie_name'        => 'required|unique:movies,name,' . $movie->id,
                'movie_description' => 'required',
                'movie_poster'      => 'sometimes|image|nullable',
                'movie_image'       => 'sometimes|image|nullable',
                'categories'        => 'array|required',
                'movie_year'        => 'required',
                'movie_rating'      => 'required',
            ]);

            $categories = $request->categories;
        }



        $movie_poster = $movie->poster;
        $movie_image = $movie->image;

        if($request->movie_poster){

            $this->removePreviousImages('poster', $movie);
            $movie_poster_image = Image::make($request->movie_poster)->resize(255, 378)->encode('jpg');
            $movie_poster = $request->movie_poster->hashName();
            Storage::disk('local')->put('public/images/' . $movie_poster, (string)$movie_poster_image, 'public' );

        }

        if($request->movie_image){

            $this->removePreviousImages('image', $movie);
            $movie_image_image = Image::make($request->movie_image)->encode('jpg', 50);
            $movie_image = $request->movie_image->hashName();
            Storage::disk('local')->put('public/images/' . $movie_image, (string)$movie_image_image, 'public' );

        }

        $movie->update([
                'name'             => $request->movie_name,
                'description'      => $request->movie_description,
                'year'             => $request->movie_year,
                'rating'           => $request->movie_rating,
                'poster'           => $movie_poster,
                'image'            => $movie_image,
            ]);


        $movie->categories()->sync($categories);

        session()->flash('success','Data updated successfully');

        return redirect()->route('dashboard.movies.index');
    }

    private function removePreviousImages($type_image, $movie){

        if($type_image == "poster"){
            Storage::disk('local')->delete('public/images/' . $movie->poster);
        }else{
            Storage::disk('local')->delete('public/images/' . $movie->image);
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie){

        $movie->delete();
        $movie->categories()->detach($movie->categories->pluck('id')->toArray());

        Storage::disk('local')->delete('public/images/' . $movie->poster);
        Storage::disk('local')->delete('public/images/' . $movie->image);
        Storage::disk('local')->delete($movie->path);
        Storage::disk('local')->deleteDirectory("public/movies/" . $movie->id);

        session()->flash('success','Data deleted successfully');

        return redirect()->route('dashboard.movies.index');
    }
}
