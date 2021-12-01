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
    chat
</div>
<script src="{{ mix('js/app.js') }}"></script>
<script>
    console.log('chat')
    //pusher
    Echo.join(`chat.1`)
        .here((users) => {
            //
            console.log('here')
            console.log(users)

        })
        .joining((user) => {
            console.log('joining' + user.name);
        })
        .leaving((user) => {
            console.log('leaving' + user.name);
        });


</script>
</body>
</html>
