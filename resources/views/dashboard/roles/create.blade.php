@extends('layouts.dashboard.app')


@section('content')

    <div>
        <h1>Add Role</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.roles.index') }}">Roles</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Role</li>
        </ol>
    </nav>

    <div class="tile mb-4">
        <form action="{{ route('dashboard.roles.store') }}" method="POST">

            @csrf
            @method('POST')

            @include('dashboard.partials._errors')

            <div class="form-group">
                <label for="">Role Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>

            @php
                $models = config('laratrust_seeder.role_structure.super_admin');
                $permissions_maps = ['create', 'read', 'update', 'delete'];
                $increment = 1;
            @endphp
                <h2>Permissions</h2>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width:10%;">#</th>
                        <th style="width:15%;">Model</th>
                        <th>Permissions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($models as $index=>$model)
                        <tr>
                            <td>{{ $increment++ }}</td>
                            <td>{{ $index }}</td>
                            <td>
                                <select name="permissions[]" class="form-control select2" multiple>

                                    @if($index == 'settings')
                                        @php
                                            $permissions_maps = ['create', 'read'];
                                        @endphp
                                    @endif

                                        @foreach($permissions_maps as $permission)
                                            <option value="{{ $permission . '_' . $index }}">{{ $permission }}</option>
                                        @endforeach
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>
            </div>
        </form>
    </div>



@endsection
