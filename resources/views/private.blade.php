
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>chart</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="content">
    private
</div>
<script src="{{ mix('js/app.js') }}"></script>
<script>
    console.log('private')
    //pusher
    Echo.private('user.8')
        .listen('UserLogined', (e) => {
            console.log(e.message);
        });
    //laravel-echo-server
    // window.Echo.channel('news')
    //     .listen('News', (e) => {
    //         console.log(e.message);
    //     });

</script>
</body>
</html>
