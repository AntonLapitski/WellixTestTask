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
        <div style="display: flex;">
        <!--<form style="width: 20%; margin-left: 5%;">-->
        <div id="registrationBlock" style="width: 20%; margin-left: 5%;">
            <h2>Register</h2>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="exampleInputName1">Username</label>
                <input type="text" name="username" class="form-control" id="exampleInputName1" placeholder="Password">
            </div>
            <button id="register" class="btn btn-primary">Submit</button>
            <div class="responseHandler">

            </div>
            </div>
        <!--</form>-->

        <form style="width: 20%; margin-left: 20%;">
            <h2 id="loginheading">Login</h2>
            <div class="form-group">
                <label for="exampleInputEmail2">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail2" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword2">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
            </div>
            <button id="login" type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>

        <h1>BLOG</h1>
        <div style="" class="flex-center">
            <div class="content">
                @foreach($posts as $post)
                   <div style="width: 400px;height: 400px; border: 2px solid black; margin-bottom: 20px;">
                    <h1>{{$post->created_at}}</h1>
                    <textarea name="" id="" cols="30" rows="10">
                        {{$post->message}}
                    </textarea>
                    <h3>{{$post->author}}</h3>
                    <h5 hidden> {{$post->user_id}}</h5>
                   </div>
                @endforeach
            </div>
        </div>
        <script>

            function changeHeadingColor(response)
            {
                document.querySelector("#loginheading").style.color = 'green';
                alert(response.message);
            }

            $(document).on('click','#register',function(e){
                e.preventDefault();
                const useremail = document.querySelector("#exampleInputEmail1").value;
                const userpassword = document.querySelector("#exampleInputPassword1").value;
                const username = document.querySelector("#exampleInputName1").value;
                const resHandler = document.querySelector(".responseHandler");
                console.log(resHandler);
                console.log(111);
                console.log(username);
                console.log(useremail);
                console.log(userpassword);

                var dataString = { name: username, email: useremail, password: userpassword };
                $.ajax({
                    type: 'POST',
                    url: '/api/auth/registration',
                    data: dataString,
                    success: function(response) {
                        setInterval(changeHeadingColor(response), 3000);
                        document.querySelector("#registrationBlock").style.visibility='hidden'
                    }
                });
            });
        </script>

        <script>
            $(document).on('click','#login',function(e){
                e.preventDefault();
                const useremail = document.querySelector("#exampleInputEmail2").value;
                const userpassword = document.querySelector("#exampleInputPassword2").value;
                console.log(useremail);
                console.log(userpassword);

                var dataString = { email: useremail, password: userpassword };
                $.ajax({
                    type: 'POST',
                    url: '/api/auth/login',
                    data: dataString,
                    success: function(response) {
                        console.log(response.access_token);
                        var test = response.access_token;
                        window.location.href = 'http://127.0.0.1:8000/view/test?bearer=' + test;
                    }
                });
            });
        </script>
    </body>

</html>
