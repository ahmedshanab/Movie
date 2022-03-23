@extends('layouts.dashboard.app')


@section('content')

    <div>
        <h1>Add User</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.users.index') }}">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add User</li>
        </ol>
    </nav>

    <div class="tile mb-4">
        <form action="{{ route('dashboard.users.store') }}" method="POST">

            @csrf
            @method('POST')
    
            @include('dashboard.partials._errors')

            <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control" value="{{ old('password') }}">
            </div>

            <div class="form-group">
                <label for="">Password Confirmation</label>
                <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
            </div>

            <div class="form-group">
                <label for="">Roles</label>
                <select name="role_id" class="form-control">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                @if(auth()->user()->hasPermission('create_roles'))
                        <a href="{{ route('dashboard.roles.create') }}">Create new role</a>
                    @else
                        <a href="#" class="btn disabled">Create new role</a>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>
            </div>

            
        </form>    
    </div>



@endsection