@extends("layouts.dashboard.app")

@section("content")

    <div>
        <h1>Movies</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">movies</li>
        </ol>
    </nav>


    <div class="tile mb-4">

        <div class="row">
            <div class="col-12">

                <form action="">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="search" class="form-control" placeholder="Search By name, descroption, year, rating" name="search" value="{{ request()->search }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="category" class="form-control">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == request()->category ? 'selected':'' }}> {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>

                            @if(auth()->user()->hasPermission('create_movies'))
                                    <a href="{{ route('dashboard.movies.create') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> Add</a>
                                @else
                                    <button type="submit" class="btn btn-primary" disabled><i class="fa fa-plus"></i> Add</button>
                            @endif
                        </div>

                    </div><!-- end of row -->
                </form><!-- end of form -->

            </div>
        </div><!-- end of row -->

        <div class="row">
            <div class="col-md-12">

                @if($movies->count() > 0)
                    <table class="table table-hover">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Categories</th>
                            <th>Year</th>
                            <th>Rating</th>
                            <th>Views</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                                @foreach($movies as $index=>$movie)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $movie->name }}</td>
                                        <td>{{ str_limit($movie->description, 30) }}</td>
                                        <td>
                                            @foreach($movie->categories as $category)
                                                <h5 style="display:inline-block;"><span class="badge badge-primary"> {{ $category->name }} </span> </h5>
                                            @endforeach
                                        </td>
                                        <td>{{ $movie->year }}</td>
                                        <td>{{ $movie->rating }}</td>
                                        <td>{{ $movie->views }}</td>
                                        <td >

                                            @if(auth()->user()->hasPermission('update_movies'))
                                                    <a href="{{ route('dashboard.movies.edit',$movie->id) }}" class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>
                                                @else
                                                    <button type="submit" class="btn btn-info" disabled><i class="fa fa-edit"></i> Edit</button>
                                            @endif

                                            @if(auth()->user()->hasPermission('delete_movies'))
                                                    <form id="delete_form"  action="{{ route('dashboard.movies.destroy',$movie->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button id="delete_movie" type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                                    </form>
                                                @else
                                                    <button type="submit" class="btn btn-danger" disabled><i class="fa fa-trash"></i> Delete</button>
                                            @endif

                                        </td>


                                    </tr>
                                @endforeach
                        </tbody>
                    </table>

                    {{ $movies->links() }}

                @else
                    <h2>Sorry No Records</h2>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(document).ready(function(){


            $(document).on('click','#delete_movie',function (e) {

                e.preventDefault();

                var that = $(this);

                swal({
                        title: "Are you sure?",
                        text: "Your will not be able to recover this movie!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    }).then(function(value) {
                    if (value) {
                        that.closest('form').submit();
                        swal("Deleted!", "Your movie has been deleted.", value);
                    }
                });

            });

        });
    </script>
@endpush
