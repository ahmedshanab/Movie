<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta name="description" content="">

    <title>My-Netflix</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_files/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">

    {{-- jquery--}}
    <script src="{{ asset('dashboard_files/js/jquery-3.3.1.min.js') }}"></script>

    {{-- noty--}}
    <link rel="stylesheet" href="{{ asset('dashboard_files/plugins/noty/noty.css') }}">
    <script src="{{ asset('dashboard_files/plugins/noty/noty.min.js') }}"></script>

    {{--movie--}}
    <script src="{{ asset('dashboard_files/js/custom/movie.js') }}"></script>

    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    @stack('style')

    <style>
        label {
            font-weight: bold;
        }
    </style>

</head>
<body class="app sidebar-mini">

@include('layouts.dashboard._header')

@include('layouts.dashboard._aside')

<main class="app-content">

    @include('dashboard.partials._sessions')

    @yield('content')

</main>

<!-- Essential javascripts for application to work-->
<script src="{{ asset('dashboard_files/js/popper.min.js') }}"></script>
<script src="{{ asset('dashboard_files/js/bootstrap.min.js') }}"></script>

{{--select 2--}}
<script src="{{ asset('dashboard_files/js/plugins/select2.min.js') }}"></script>

<script src="{{ asset('dashboard_files/js/main.js') }}"></script>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function () {

        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            var that = $(this);
            var n = new Noty({
                text: "Confirm deleting record",
                killer: true,
                buttons: [
                    Noty.button('Yes', 'btn btn-success mr-2', function () {
                        that.closest('form').submit()
                    }),
                    Noty.button('No', 'btn btn-danger', function () {
                        n.close();
                    }),
                ]
            });
            n.show();
        });
    });//end of document ready

    //select2
    $('.select2').select2({
        'width': '100%'
    });

    $.ajaxSetup({
        headers: {
            'x-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>

@stack('scripts')
</body>
</html>
