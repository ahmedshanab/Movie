

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">

        <div class="container">

            <a class="navbar-brand" href="{{route('welcome')}}">Netflix<span class="text-primary font-weight-bold">ify</span></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <form action="" class="col-12 col-md-6 p-0 mt-1">
                    <div class="input-group">
                        <input type="search" class="search_movies form-control bg-transparent border-0" placeholder="Search for your favorite movies" aria-label="Search for your favorite movies" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-white border-0" id="basic-addon2"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </form><!-- end of form -->

                <ul class="navbar-nav ml-auto">
                    @auth

                        <li class="nav-item mr-2" style="margin: 5px; padding-right: 30px;">
                            <a href="{{route('movie.indexBy', ['favored' => 'favored'])}}" class="nav-link text-white" style="position: relative;">
                                <i class="fa fa-heart"></i>
                                <span  class="bg-primary text-white d-flex justify-content-center align-items-center favorites"
                                      style="position: absolute; top: 0; right: -15px; width: 30px; height: 20px; border-radius: 50px; "
                                      id="nav__fav-count"
                                      data-value="{{auth()->user()->movies_count}}"
                                >
{{--                                   {{ auth()->user()->testCount()->pluck('movies_count')[0] }}--}}
                                    {{ auth()->user()->movies_count > 9 ? '9+' : auth()->user()->movies_count}}
                            </span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a   class="fw-500 nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;position:relative; padding-left:50px;">
                                {{ auth()->user()->name }}
                            </a>

                            <a href="{{route('profile.edit')}}">
                                <img src="{{auth()->user()->avatar_path}}" alt="" style="width:40px; height:40px; position:absolute; top:5px; right:140px; border-radius:50%">
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('super_admin') )
                                    <a class="dropdown-item" href="{{route('dashboard.index') }}"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
                                @endif
                                <a class="dropdown-item" href="{{route('profile.edit')}}"><i class="fa fa-user-alt"></i> Profile</a>

                                <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout_form').submit()" href="">
                                    <i class="fa fa-sign-out-alt"></i> Logout
                                    <form method="POST" action="{{route('logout')}}" id="logout_form">
                                        @csrf
                                    </form>
                                </a>

                            </div>
                        </li>

                        @else
                            <a href="{{route('login') }}" class="btn btn-primary mb-2 mb-md-0 mr-0 mr-md-2">Login</a>
                            <a href="{{route('register')}}" class="btn btn-outline-light">Register</a>
                    @endauth
                </ul>

            </div><!-- end of collapse -->

        </div><!-- end of container fluid-->

    </nav><!-- end of nav -->



