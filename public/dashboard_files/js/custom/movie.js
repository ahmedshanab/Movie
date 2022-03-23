$(document).ready(function(){

    // to open Browse on click
    $('.upload-movie').click(function(){
        $('.movie_file').click();
    });



    $('#form_properties').submit(function(event){

            event.preventDefault();

            var url = $('#form_properties').attr('action');
            var movie_name = $('#movie_name').val();
            var movie_year = $('#movie_year').val();
            var movie_rating = $('#movie_rating').val();
            var movie_description = $('#movie_description').val();
            var categories = $("#categories_select :selected").map(function(i, el) {
                return $(el).val();
            }).get();

            var movie_poster = document.getElementById('movie_poster').files[0];
            var movie_image = document.getElementById('movie_image').files[0];


        var form_data = new FormData();
                form_data.append('_method', 'put');
                form_data.append('movie_name', movie_name);
                form_data.append('movie_year', movie_year);
                form_data.append('movie_rating', movie_rating);
                form_data.append('movie_description', movie_description);
                form_data.append('categories[]', categories);
                form_data.append('movie_poster', movie_poster);
                form_data.append('movie_image', movie_image);

        $.ajax({
                    url: url,
                    method: 'POST',
                    data: form_data,
                    cache       : false,
                    contentType : false,
                    processData : false,
                    success: function(){

                        $('.errors_ul').html('');
                        $('.errors_div').css('display', 'none');

                        location.reload();
                    },
                    error: function(xhr, status, error){

                        $('.errors_ul').html('');
                        $('.errors_div').css('display', 'block');
                        var errors = Object.values(xhr.responseJSON.errors);

                        errors.forEach(function(item){
                            item.forEach(function(i){
                                $('.errors_div').css('display', 'block');
                                $('.errors_ul').append('<li class="mb-0">'+ i +'</li>');
                            });
                        });

                    },

                });
    });



    // to open properites form on upload movie
    $('.movie_file').on('change',function(){

        $('#form_properties').show();

        // to hide Upload Icon Bar
        $('.upload-movie').hide();

        var url_make_recorde = $(this).data('recorde-route');
        var url_store = $(this).data('store-route');
        var movie_file = this.files[0];
        var name = movie_file['name'];
        var movie_name = name.split('.').slice(0,-1).join('.');
        $('#movie_name').val(movie_name);

                $.ajax({

                    url: url_make_recorde,
                    method: 'GET',
                    processData: false,
                    contentType: false,
                    cache:false,
                    success: function(data){

                        var dataForm = new FormData();
                            dataForm.append('movie_name',movie_name);
                            dataForm.append('movie_file',movie_file);
                            dataForm.append('movie_id',data.id);

                            var update_url = $('.movie_file').data('action') + '/' + data.id + '?type=publish';
                            $('#form_properties').attr('action', update_url);
                            $('.id_movie').val(data.id);

                        $.ajax({
                            url: url_store,
                            data: dataForm,
                            method: 'POST',
                            processData: false,
                            contentType: false,
                            cache:false,
                            success: function(){

                                    $('#submit_form').show();

                                var interval = setInterval(function(){

                                    $.ajax({
                                        url: `/dashboard/movies/${data.id}`,
                                        method: 'GET',
                                        success: function(data){

                                            // var percent = data.percent + '%';
                                            // $('#progress_upload_movie').css('width', percent).html(percent);
                                            // $('#progress_label').html('Processing...');

                                            // if(data.percent == 100){
                                            //     clearInterval(interval);
                                            //     $('#progress_upload_movie').parent().hide();
                                            //     $('#progress_label').css('font-weight','bold').html('Done Processing');
                                            //     $('#submit_form').show();
                                            // }

                                        },
                                    });

                                },3000);

                            },
                            xhr: function () {
                                var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function (evt) {
                                    if (evt.lengthComputable) {
                                        var percentComplete = Math.round(evt.loaded / evt.total * 100) + "%";
                                        $('#progress_upload_movie').css('width', percentComplete).html(percentComplete)
                                    }
                                }, false);
                             return xhr;
                            },

                        });



                    },
                    error: function(){
                        console.log('errorrrrrrrrrr');
                    },

                });

                // $.ajax({
                //     url: url,
                //     data: dataForm,
                //     method: 'POST',
                //     processData: false,
                //     contentType: false,
                //     cache:false,
                //     success: function(dataFromStorFunction){

                //         var interval = setInterval(function(){

                //             $.ajax({
                //                 url: `/dashboard/movies/${dataFromStorFunction.id}`,
                //                 method: 'GET',
                //                 success: function(dataFromShowFunction){

                //                     var percent = dataFromShowFunction.percent + '%';
                //                     $('#progress_upload_movie').css('width', percent).html(percent);
                //                     $('#progress_label').html('Processing...');

                //                     if(dataFromShowFunction.percent == 100){
                //                         clearInterval(interval);
                //                         $('#progress_upload_movie').parent().hide();
                //                         $('#progress_label').css('font-weight','bold').html('Done Processing');
                //                         $('#submit_form').show();
                //                     }
                //                 },
                //             });

                //         },30000);
                //     },
                //     error: function(){
                //         alert('Error');
                //     },
                //     xhr: function () {
                //         var xhr = new window.XMLHttpRequest();
                //         xhr.upload.addEventListener("progress", function (evt) {
                //             if (evt.lengthComputable) {
                //                 var percentComplete = Math.round(evt.loaded / evt.total * 100) + "%";
                //                 $('#progress_upload_movie').css('width', percentComplete).html(percentComplete)
                //             }
                //         }, false);
                //         return xhr;
                //     },

                // });



    });

});
