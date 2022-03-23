

$(document).ready(function(){

    var count = $('.favorites').data('value');

    $(document).on('click', '.movie__fav-button', function(){

        var movie_id = $(this).data('movie-id');
        var url = $(this).data('url');

        var hasClass = $('.movie-slider-btn-'+movie_id).hasClass('btn-danger');

        $('.movie-slider-btn-'+movie_id).toggleClass('btn-outline-light');
        $('.movie-slider-btn-'+movie_id).toggleClass('btn-danger');



        if(!hasClass){
            $('.movie-slider-'+movie_id).html('Remove from favorite');
        }else{
            $('.movie-slider-'+movie_id).html('Add to favorite');
        }

        addToFavorite(url, movie_id);

        var favored_class = $('.movie-'+movie_id).closest('.favored').length; // will return (1) ==> true
        if(favored_class){
            $('.movie-'+movie_id).closest('.movie').remove();
            var exist = $('.test').closest('.movie').length;

            if(!exist){
                $('.favored').html('<h5>No any movies yet!</h5>');
            }
        }

    });

    $(document).on('click', '.movie__fav-btn', function(e){
        e.preventDefault();

        var movie_id = $(this).data('movie-id');
        var url = $(this).data('movie-url');

        var hasClass = $('.movie-slider-btn-'+movie_id).hasClass('btn-danger');

        $('.movie-slider-btn-'+movie_id).toggleClass('btn-outline-light');
        $('.movie-slider-btn-'+movie_id).toggleClass('btn-danger');
        $('.movie-'+movie_id).toggleClass('fw-900');

        if(!hasClass){
            $('.movie-slider-'+movie_id).html('Remove from favorite');
            count++;
            if(count > 9 ){
                $('.favorites').html('9+');
            }else{
                $('.favorites').html(count);
            }
        }else{
            $('.movie-slider-'+movie_id).html('Add to favorite');
            count--;
            if(count > 9 ){
                $('.favorites').html('9+');
            }else{
                $('.favorites').html(count);
            }

        }

        $.ajax({
            url:url,
            method:'POST',
        });

    });


    function addToFavorite(url, movie_id){

            var bool = $('.movie-'+movie_id).hasClass('fw-900');
            $('.movie-'+movie_id).toggleClass('fw-900');

            if(bool){
                count--;
            }else{
                count++;
            }

            if(count > 9 ){
                $('.favorites').html('9+');
            }else{
                $('.favorites').html(count);
            }

            $.ajax({
                url:url,
                method:'POST',
            });
    }

});
