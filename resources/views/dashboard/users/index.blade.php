@extends("layouts.dashboard.app")

@section("content")

    <div>
        <h1>Users</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Users</li>
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
                            <select name="role_id" class="form-control">
                                    <option value="">All Roles</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ $role->id == request()->role_id ? 'selected':'' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>

                            @if(auth()->user()->hasPermission('create_users'))
                                    <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> Add</a>
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
                @if($users->count() > 0)
                    <table class="table table-hover">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                                @foreach($users as $index=>$user)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>

                                        <!-- $user->roles->pluck('name')->toArray() [it's very important] -->
                                        <td >
                                            @foreach ($user->roles as $role)
                                                <h2 style="display:inline-block;"><span class="badge badge-primary">{{ $role->name }}</span></h2>
                                            @endforeach
                                        </td>

                                        <td >

                                            @if(auth()->user()->hasPermission('update_users'))
                                                    <a href="{{ route('dashboard.users.edit',$user->id) }}" class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>
                                                @else
                                                    <button type="submit" class="btn btn-info" disabled><i class="fa fa-edit"></i> Edit</button>
                                            @endif

                                            @if(auth()->user()->hasPermission('delete_users'))
                                                    <form  action="{{ route('dashboard.users.destroy',$user->id) }}" method="POST" style="display:inline-block;">

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

                    {{ $users->links() }}

                @else
                    <h2>Sorry No Records</h2>
                @endif
            </div>
        </div>
    </div>

@endsection
