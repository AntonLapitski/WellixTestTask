<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script
        src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>

<h1> User</h1>

<h2>Create record</h2>
<div id="createRecordBlock" style="width: 20%; margin-left: 5%;">
    <h2>Create a record</h2>
    <div class="form-group">
        <textarea id="messageArea">

        </textarea>
    </div>
    <button id="createRecord" class="btn btn-primary">Submit</button>
</div>

<h1>BLOG</h1>
<div style="" class="flex-center">
    <div class="content">
        @foreach($posts as $post)
            <h1>{{$post->created_at}}</h1>
            <textarea name="" id="" cols="30" rows="10">
                {{$post->message}}
            </textarea>
            <h3>{{$post->author}}</h3>
            <h5 hidden> {{$post->user_id}}</h5>
            <a href="{{ route('edit-record', ['postId' => $post->id]) }}" class="btn btn-default" id="{{$post->id}}">Edit</a>
            <button class="deleteMe btn" id="{{$post->id}}">Delete</button>
        @endforeach
    </div>
</div>

<script>
    $(document).on('click','#createRecord',function(e){
        e.preventDefault();
        const message= document.querySelector("#messageArea").value;

        var dataString = { message: message };
        $.ajax({
            type: 'POST',
            url: '/api/create-blog-record',
            data: dataString,
            success: function(response) {
                alert(response.message);
                location.reload();
            }
        });
    });
</script>

<script>
    $(document).on('click','.deleteMe',function(e){
        e.preventDefault();
        const deleteId = this.id;
        var dataString = { id: deleteId };
        $.ajax({
            type: 'POST',
            url: '/api/delete-blog-record',
            data: dataString,
            success: function(response) {
                alert(response.message);
                location.reload();
            }
        });
    });
</script>
</body>

</html>
