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
        $social_sites = ['Facebook', 'Google', 'Youtube'];
    @endphp
    <div class="tile mb-4">

        <form action="{{ route('dashboard.settings.store') }}" method="POST">

            @csrf
            @method('POST')
    
            @include('dashboard.partials._errors')

            @foreach ($social_sites as $social_site)

                    <div class="form-group">
                        <label for="">{{ $social_site }} link</label>
                        <input type="text" name="{{ $social_site }}_link" class="form-control" value="{{ setting($social_site.'_link') }}">
                    </div>

            @endforeach

            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>
            </div>

            </div>


            
        </form>    
    </div>



@endsection