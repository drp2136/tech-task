<html>
<head>
    <title>Add a Job </title>
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

@include('Employer::header')

<div>

    <div class="white-box">
        <form class="form-horizontal form-material" id="signupform" method="post">
            {{csrf_field()}}
            <h3 class="card-title m-b-0">Add a Job</h3>
            <div class="form-group ">
                <div class="col-xs-12">
                    <input class="form-control" type="text" id="job_heading" name="job_heading" required=""
                           placeholder="Enter Job Heading" value="{{old('job_heading')}}">
                    <span class="fn_error error-block">{{$errors->first('job_heading')}}</span>
                </div>
            </div>
            <div class="form-group ">
                <div class="col-xs-12">
                    <textarea class="form-control" id="job_desc" name="job_desc" placeholder="Enter job Description"
                              required="" style="height:300px;"></textarea>
                    <span class="email_error error-block">{{$errors->first('job_desc')}}</span>
                </div>
            </div>
            <div class="form-group ">
                <div class="col-xs-12">
                    <input class="form-control" type="text" id="amnt_offer" name="amnt_offer" required=""
                           placeholder="Your offer amount" value="{{old('amnt_offer')}}">
                    <span class="ps_error error-block">{{$errors->first('amnt_offer')}}</span>
                </div>
            </div>

            <div class="form-group text-center m-t-20">
                <div class="col-xs-12">
                    <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light registerForm"
                            type="submit">ADD YOUR JOB
                    </button>
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

