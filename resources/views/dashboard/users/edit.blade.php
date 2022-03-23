@extends('layouts.dashboard.app')


@section('content')

    <div>
        <h1>Edit User</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.users.index') }}">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
        </ol>
    </nav>

    <div class="tile mb-4">
        <form action="{{ route('dashboard.users.update',$user->id) }}" method="POST">

            @csrf
            @method('PUT')
    
            @include('dashboard.partials._errors')

            <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
            </div>

            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
            </div>

            <div class="form-group">
                <label for="">Roles</label>
                <select name="role_id" class="form-control">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->hasRole($role->name) ? 'selected' : '' }} >{{$role->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</button>
            </div>

            
        </form>    
    </div>



@endsection