@if(session('success'))

    <script>

        new Noty({
            type: 'alert',
            layout: 'topRight',
            text: "<p style='background:white;font-size:16px;'>{{ session('success') }}</p>",
            killer:true,
            timeout:3000
        }).show();

    </script>

@endif
