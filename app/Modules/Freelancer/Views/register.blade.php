<html>
<head>
    <title>Register </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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


@if(Session::has('success') || Session::has('error'))
    <div class="alert alert-block @if($message = Session::get('success'))alert-success @elseif($message = Session::get('error'))alert-danger @endif">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

<div>
    <div class="white-box">
        <form class="form-horizontal form-material" id="signupform" method="post">
            {{csrf_field()}}
            <h3 class="card-title m-b-0">Sign Up</h3>
            <p class="text-muted f-14"><strong>Enter your personal details below:</strong></p>
            <div class="form-group ">
                <div class="col-xs-12">
                    <input class="form-control" type="text" id="firstName" name="first_name" required=""
                           placeholder="Your Name"
                           value="{{old('first_name')}}">
                    <span class="fn_error error-block">{{$errors->first('first_name')}}</span>
                </div>
            </div>
            <div class="form-group ">
                <div class="col-xs-12">
                    <input class="form-control" type="text" id="email" name="email" required="" placeholder="Email"
                           value="{{old('email')}}">
                    <span class="email_error error-block">{{$errors->first('email')}}</span>
                </div>
            </div>
            <div class="form-group ">
                <div class="col-xs-12">
                    <input class="form-control" type="password" id="password" name="password" required=""
                           placeholder="Password">
                    <span class="ps_error error-block">{{$errors->first('password')}}</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <input class="form-control" type="password" id="cpassword" name="password_confirmation" required=""
                           placeholder="Confirm Password">
                    <span class="cps_error error-block">{{$errors->first('password_confirmation')}}</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <select class="form-control" id="role" name="role" required="">
                        <option value="">Select your Role</option>
                        <option value="F">Freelancer</option>
                        <option value="E">Employer</option>
                    </select>
                    <span class="cps_error error-block">{{$errors->first('role')}}</span>
                </div>
            </div>
            <div class="form-group text-center m-t-20">
                <div class="col-xs-12">
                    <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light registerForm"
                            type="submit">Sign Up
                    </button>
                </div>
            </div>
            <div class="form-group m-b-0">
                <div class="col-sm-12 text-center">
                    <p>Already have an account? <a href="/login" class="text-default m-l-5"><b>Sign In</b></a></p>
                </div>
            </div>
        </form>
    </div>

</div>


<!-- jQuery -->
<script src="/assets/js/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $(document).on('click', '.close', function () {
            $('.alert.alert-block').hide();
        });
    });
</script>

</body>
</html>

