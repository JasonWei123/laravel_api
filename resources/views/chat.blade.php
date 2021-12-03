<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>chart</title>
    <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="content">
    chat
</div>
<textarea name="message" id="message" cols="30" rows="10">

    </textarea>
<button id="sub" onclick="push()">提交</button>

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
    Echo.private(`chat.1`)
        .listen('Chat', (e) => {
            console.log(e);
        });
    function push() {
        // $.post("api/user/message", {
        //     message: $('#message').val()
        // }, function (result) {
        // })
        var token = localStorage.getItem("api_token");
        var message = $('#message').val()
        $.ajax(
            {
                url:'api/user/message',
                type:'post',
                dateType:'json',
                headers:{'Authorization':'Bearer '+token},
                data:{message:message},
                success:function(data)
                {
                    console.log("sucess");
                    },
                error:function(data){
                    console.log("error");
                }
            }
        );

    }

</script>
</body>
</html>
