@extends("layouts.dashboard.app")

@section("content")

    <div>
        <h1>Categories</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Categories</li>
            {{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
        </ol>
    </nav>

    <div class="tile mb-4">

        <div class="row">
            <div class="col-12">

                <form action="">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="search" class="form-control" placeholder="Search" name="search">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>

                            @if(auth()->user()->hasPermission('create_categories'))
                                    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> Add</a>
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
                @if($categories->count() > 0)
                    <table class="table table-hover">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Movies Count</th>
                            <th>Action</th>
                        </thead>
                        <tbody>




                        @foreach($categories as $index=>$category)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>

{{-- {{ $count[$i][0]->count }}--}}
                                            {{ $category->movies_count }}

                                        </td>

                                        <td >

                                            @if(auth()->user()->hasPermission('update_categories'))
                                                    <a href="{{ route('dashboard.categories.edit',$category->id) }}" class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>
                                                @else
                                                    <button type="submit" class="btn btn-info" disabled><i class="fa fa-edit"></i> Edit</button>
                                            @endif

                                            @if(auth()->user()->hasPermission('delete_categories'))
                                                    <form  action="{{ route('dashboard.categories.destroy',$category->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                                    </form>
                                                @else
                                                    <button type="submit" class="btn btn-danger" disabled><i class="fa fa-trash"></i> Delete</button>
                                            @endif

                                        </td>

                                    </tr>
                                @endforeach
                        </tbody>
                    </table>

                    {{ $categories->links() }}

                @else
                    <h2>Sorry No Records</h2>
                @endif
            </div>
        </div>
    </div>

@endsection
