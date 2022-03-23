<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Netflixify</title>


    <!--font awesome-->
    <link rel="stylesheet" href="{{ asset('front/dist/css/font-awesome5.11.2.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/brands.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/solid.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/regular.min.css" rel="stylesheet">

    <!--bootstrap-->
    <link rel="stylesheet" href="{{ asset('front/dist/css/bootstrap.min.css') }}">

    <!--vendor css-->
    <link rel="stylesheet" href="{{ asset('front/dist/css/vendor.min.css') }}">

    <!--google font-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,500,700&display=swap" rel="stylesheet">

    <!--main styles -->
    <link rel="stylesheet" href="{{ asset('front/dist/css/main.min.css') }}">

    <!-- autocomplete -->
    <link rel="stylesheet" href="{{ asset('front/dist/plugins/easy-autocomplete.min.css') }}">

    {{-- noty--}}
    <link rel="stylesheet" href="{{ asset('dashboard_files/plugins/noty/noty.css') }}">
    <script src="{{ asset('dashboard_files/plugins/noty/noty.min.js') }}"></script>


    <style>
        .fw-900{
            font-weight: 900;
        }
        .easy-autocomplete input{
            color:white !important;
        }
        .eac-icon-left .eac-item img{
            max-height: 80px;
        }
        .easy-autocomplete-container ul li.selected{
            color: black !important;
        }
        .easy-autocomplete-container ul{
            background: black;
        }
        .easy-autocomplete-container ul li, .easy-autocomplete-container ul .eac-category{
            color: white !important;
        }
    </style>

</head>
<body>

    @yield('content')

    <!--jquery-->
    <script src="{{ asset('front/dist/js/jquery-3.4.0.min.js') }}"></script>

    <!--bootstrap-->
    <script src="{{ asset('front/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/dist/js/popper.min.js') }}"></script>

    <!--vendor js-->
    <script src="{{ asset('front/dist/js/vendor.min.js') }}"></script>

    <!--main scripts-->
    <script src="{{ asset('front/dist/js/main.min.js') }}"></script>
    <script src="{{ asset('front/dist/js/playerjs.js') }}"></script>
    <script src="{{ asset('dashboard_files/js/custom/movie.js') }}"></script>

    <script src="{{ asset('front/dist/js/custom/movie.js') }}"></script>

    <!-- autocomplete -->
    <script src="{{ asset('front/dist/plugins/jquery.easy-autocomplete.min.js') }}"></script>

<script>
    $(document).ready(function () {

        $("#banner .movies").owlCarousel({
            loop: true,
            nav: false,
            items: 1,
            dots: false,
        });

        $(".listing .movies").owlCarousel({
            loop: true,
            nav: false,
            stagePadding: 50,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                900: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            },
            dots: false,
            margin: 15,
            loop: true,
        });

    });


    $.ajaxSetup({
        headers: {
            'x-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
    });



    var options = {
        url: function(search) {

            var url = window.location.origin + "/movie/indexBy/movie?search=" + search;

            return url;
        },

        getValue: 'name',

        template: {
            type: "iconLeft",

            fields: {
                iconSrc: "poster_path",
            }
        },

        list: {

            onClickEvent: function() {
                var movie_search_result = $(".search_movies").getSelectedItemData();
                var new_url = window.location.origin + '/movie/' + movie_search_result.id;
                window.location.replace(new_url);
            }
        }


    };


    $('.search_movies').easyAutocomplete(options);


</script>

    @stack('scripts')

</body>
</html>
