<html>
<head>
    <title>Login </title>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400' rel='stylesheet' type='text/css'>


    <style>
        .error-block {
            color: #ff111b;
        }

    </style>

    <style>
        h1, input::-webkit-input-placeholder, button {
            font-family: 'roboto', sans-serif;
            transition: all 0.3s ease-in-out;
        }

        h1 {
            height: 100px;
            width: 100%;
            font-size: 18px;
            background: #18aa8d;
            color: white;
            line-height: 150%;
            border-radius: 3px 3px 0 0;
            box-shadow: 0 2px 5px 1px rgba(0, 0, 0, 0.2);
        }

        form {
            box-sizing: border-box;
            width: 260px;
            margin: 100px auto 0;
            box-shadow: 2px 2px 5px 1px rgba(0, 0, 0, 0.2);
            padding-bottom: 40px;
            border-radius: 3px;
        }

        form h1 {
            box-sizing: border-box;
            padding: 20px;
        }

        select, input {
            margin: 40px 25px;
            width: 200px;
            display: block;
            border: none;
            padding: 10px 0;
            border-bottom: solid 1px #1abc9c;
            transition: all 0.3s cubic-bezier(0.64, 0.09, 0.08, 1);
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 96%, #1abc9c 4%);
            background-position: -200px 0;
            background-size: 200px 100%;
            background-repeat: no-repeat;
            color: #0e6252;
        }

        input:focus, input:valid {
            box-shadow: none;
            outline: none;
            background-position: 0 0;
        }

        input:focus::-webkit-input-placeholder, input:valid::-webkit-input-placeholder {
            color: #1abc9c;
            font-size: 11px;
            -webkit-transform: translateY(-20px);
            transform: translateY(-20px);
            visibility: visible !important;
        }

        button {
            border: none;
            background: #1abc9c;
            cursor: pointer;
            border-radius: 3px;
            padding: 6px;
            width: 200px;
            color: white;
            margin-left: 25px;
            box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.2);
        }

        button:hover {
            -webkit-transform: translateY(-3px);
            transform: translateY(-3px);
            box-shadow: 0 6px 6px 0 rgba(0, 0, 0, 0.2);
        }

        .follow {
            width: 42px;
            height: 42px;
            border-radius: 50px;
            background: #03A9F4;
            display: inline-block;
            margin: 50px calc(50% - 21px);
            white-space: nowrap;
            padding: 13px;
            box-sizing: border-box;
            color: white;
            transition: all 0.2s ease;
            font-family: Roboto, sans-serif;
            text-decoration: none;
            box-shadow: 0 5px 6px 0 rgba(0, 0, 0, 0.2);
        }

        .follow i {
            margin-right: 20px;
            transition: margin-right 0.2s ease;
        }

        .follow:hover {
            width: 134px;
            -webkit-transform: translateX(-50px);
            transform: translateX(-50px);
        }

        .follow:hover i {
            margin-right: 10px;
        }
    </style>
</head>

<body>

{{--<div class="page">
    <div class="container">
        <div class="left">
            <div class="login">Login</div>
            <div class="eula">By logging in you agree to the ridiculously long terms that you didn't bother to read</div>
        </div>
        <div class="right">
            <svg viewBox="0 0 320 300">
                <defs>
                    <linearGradient
                            inkscape:collect="always"
                            id="linearGradient"
                            x1="13"
                            y1="193.49992"
                            x2="307"
                            y2="193.49992"
                            gradientUnits="userSpaceOnUse">
                        <stop
                                style="stop-color:#ff00ff;"
                                offset="0"
                                id="stop876"/>
                        <stop
                                style="stop-color:#ff0000;"
                                offset="1"
                                id="stop878"/>
                    </linearGradient>
                </defs>
                <path d="m 40,120.00016 239.99984,-3.2e-4 c 0,0 24.99263,0.79932 25.00016,35.00016 0.008,34.20084 -25.00016,35 -25.00016,35 h -239.99984 c 0,-0.0205 -25,4.01348 -25,38.5 0,34.48652 25,38.5 25,38.5 h 215 c 0,0 20,-0.99604 20,-25 0,-24.00396 -20,-25 -20,-25 h -190 c 0,0 -20,1.71033 -20,25 0,24.00396 20,25 20,25 h 168.57143"/>
            </svg>
            <div class="form">
                <label for="email">Email</label>
                <input type="email" id="email">
                <label for="password">Password</label>
                <input type="password" id="password">
                <input type="submit" id="submit" value="Submit">
            </div>
        </div>
    </div>
</div>--}}

<div class="container">

    <div class="row signinForm">
        <div class="col-sm-4" style="left: 350px;top: 75px;">
            <form class="form-horizontal form-material" action="/login" id="loginform" method="post">
                {{csrf_field()}}
                <h3 class="card-title m-b-20" style="padding: 0% 35%;color: darkseagreen;">Sign In</h3>
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

                <div class="form-group text-center m-b-0" style="margin-top: 5%;">
                    <div class="col-sm-12 text-center">
                        <p style="margin: auto;width: 70%;padding: 5%;">Don't have an account?
                            <a class="text-default m-l-5 goToRegister" style="padding: 25%;cursor: pointer;color: yellowgreen;"><b>Sign Up</b></a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row registerForm" style="display:none;">
        <div class="col-sm-4" style="left: 350px;top: 75px;">
            <form class="form-horizontal form-material" action="/register" id="signupform" method="post">
                {{csrf_field()}}
                <h3 class="card-title m-b-0" style="padding: 0% 35%;color: turquoise;">Sign Up</h3>
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
                <div class="form-group m-b-0" style="margin-top: 5%;">
                    <div class="col-sm-12 text-center">
                        <p style="margin: auto;width: 70%;padding: 5%;">Already have an account?
                            <a class="text-default m-l-5 goToSignin" style="padding: 25%;cursor: pointer;color: yellowgreen;"><b>Sign In</b></a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>


</div>


{{--<script>
    var current = null;
    document.querySelector('#email').addEventListener('focus', function(e) {
        if (current) current.pause();
        current = anime({
            targets: 'path',
            strokeDashoffset: {
                value: 0,
                duration: 700,
                easing: 'easeOutQuart'
            },
            strokeDasharray: {
                value: '240 1386',
                duration: 700,
                easing: 'easeOutQuart'
            }
        });
    });
    document.querySelector('#password').addEventListener('focus', function(e) {
        if (current) current.pause();
        current = anime({
            targets: 'path',
            strokeDashoffset: {
                value: -336,
                duration: 700,
                easing: 'easeOutQuart'
            },
            strokeDasharray: {
                value: '240 1386',
                duration: 700,
                easing: 'easeOutQuart'
            }
        });
    });
    document.querySelector('#submit').addEventListener('focus', function(e) {
        if (current) current.pause();
        current = anime({
            targets: 'path',
            strokeDashoffset: {
                value: -730,
                duration: 700,
                easing: 'easeOutQuart'
            },
            strokeDasharray: {
                value: '530 1386',
                duration: 700,
                easing: 'easeOutQuart'
            }
        });
    });
</script>--}}


<script src="/assets/js/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.goToRegister', function () {
            $('.registerForm').css('display', 'block');
            $('.signinForm').css('display', 'none');
        });

        $(document).on('click', '.goToSignin', function () {
//        $('.goToSignin').click(function () {
            $('.registerForm').css('display', 'none');
            $('.signinForm').css('display', 'block');
        });

    });
</script>

</body>
</html>

