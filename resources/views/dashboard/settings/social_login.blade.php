@extends('layouts.dashboard.app')


@section('content')

    <div>
        <h1>Social links</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Social links</li>
        </ol>
    </nav>

    @php
        $social_sites = ['facebook', 'google'];
    @endphp
    <div class="tile mb-4">

        <form action="{{ route('dashboard.settings.store') }}" method="POST">

            @csrf
            @method('POST')

            @include('dashboard.partials._errors')

            @foreach ($social_sites as $social_site)

                    <div class="form-group">
                        <label for="">{{ $social_site }} client id</label>
                        <input type="text" name="{{ $social_site }}_client_id" class="form-control" value="{{ setting($social_site.'_client_id') }}">
                    </div>

                    <div class="form-group">
                        <label for="">{{ $social_site }} client secret</label>
                        <input type="password" name="{{ $social_site }}_client_secret" class="form-control" value="{{ setting($social_site.'_client_secret') }}">
                    </div>

                    <div class="form-group">
                        <label for="">{{ $social_site }} redirect url</label>
                        <input type="text" name="{{ $social_site }}_redirect_url" class="form-control" value="{{ setting($social_site.'_redirect_url') }}">
                    </div>

            @endforeach

            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>
            </div>

            </div>



        </form>
    </div>



@endsection
