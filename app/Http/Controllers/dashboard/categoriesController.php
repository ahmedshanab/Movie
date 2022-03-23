<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\category;
use Illuminate\Support\Facades\DB;

class categoriesController extends Controller
{


    public function __construct(){

        $this->middleware('permission:read_categories')->only(['index']);
        $this->middleware('permission:create_categories')->only(['create', 'store']);
        $this->middleware('permission:update_categories')->only(['edit', 'update']);
        $this->middleware('permission:delete_categories')->only(['destroy']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

//        $values = category::all();
//        $cat = $values->pluck('id')->toArray();
//        $count = [];
//        $i = 0;
//        foreach ( $cat as $c) {
//            $count[$i] = DB::table('category_movie')->select(DB::raw("count(*) as count"))->where('category_id','=',$c)->get();
//            $i++;
//        }

        $categories = category::search(request()->search)->withCount('movies')->paginate(5);

        return view("dashboard.categories.index", compact('categories', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $request->validate([
            'name' => 'required|unique:categories,name'
        ]);

        category::create($request->all());

        session()->flash('success','Data added successfully');

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category){

        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category $category){

        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id
        ]);

        $category->update($request->all());

        session()->flash('success','Data updated successfully');

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category){

        $category->delete();

        session()->flash('success','Data deleted successfully');

        return redirect()->route('dashboard.categories.index');
    }
}
