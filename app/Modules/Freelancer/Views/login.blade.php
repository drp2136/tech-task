<html>
<head>
    <title>Login </title>
    <link href="css/app.css" rel="stylesheet">

    <style>
        body {
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        .error-block {
            color: #ff111b;
        }
    </style>
</head>

<body>

<div>
    <form class="form-horizontal form-material" id="loginform" method="post">
        {{csrf_field()}}
        <h3 class="card-title m-b-20">Sign In</h3>
        <div class="form-group ">
            <div class="col-xs-12">
                <input class="form-control emailId" type="email" id="email" name="email" required="" placeholder="Email or Username"
                       value="{{old('email')}}">
                <span class="error error-block">{{$errors->first('email')}}</span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control" name="password" id="password" type="password" required="" placeholder="Password">
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light submitBtn">Log In</button>
            </div>
        </div>

        <div class="form-group m-b-0">
            <div class="col-sm-12 text-center">
                <p>Don't have an account? <a href="/register" class="text-default m-l-5"><b>Sign Up</b></a></p>
            </div>
        </div>
    </form>

</div>

</body>
</html>

