@extends('layouts.front.app')


@section('content')

    @include('dashboard.partials._sessions')

    <section style="padding: 8%; color:white;" class="fw-500">

        <div class="tab-pane active show" id="show" role="tabpanel">

        @include('layouts.front._nav')




        <div class="card-body">
            <form class="form-horizontal form-material" action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('dashboard.partials._errors')

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <h2>{{ auth()->user()->name }}'s Profile</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group" >

                        <div class="col-md-12">
                            <img class="" src="{{ auth()->user()->avatar_path }}" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
                        </div>

                        <label class="col-md-12">Update Profile Image</label>
                            <div class="col-md-12">
                                <input type="file" name="avatar">
                            </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12">Full Name</label>
                    <div class="col-md-12">
                        <input type="text" value="{{ auth()->user()->name }}"  name="name" placeholder="John Doe" class="form-control form-control-line">
                    </div>
                </div>

                <div class="form-group">
                    <label for="example-email" class="col-md-12">Email</label>
                    <div class="col-md-12">
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control form-control-line" id="example-email">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12">Password</label>
                    <div class="col-md-12">
                        <input type="password" name="password" class="form-control form-control-line">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12">Confirm Password</label>
                    <div class="col-md-12">
                        <input type="password"  name="password_confirmation" class="form-control form-control-line">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12">Bio</label>
                    <div class="col-md-12">
                        <textarea name="bio" rows="5" class="form-control form-control-line">{{ auth()->user()->bio }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">
                        <button class="btn btn-success">Update Profile</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    </section>

    @include('layouts.front._footer')

@endsection
