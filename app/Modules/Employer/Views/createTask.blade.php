<html>
<head>
    <title>Add a Task </title>
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
            {{--<h3 class="card-title m-b-0">Add a Task</h3>--}}
            <div class="form-group ">
                <div class="col-xs-12">
                    <input class="form-control" type="text" id="task_name" name="task_name" required=""
                           placeholder="Enter Task Name" value="{{old('task_name')}}">
                    <span class="fn_error error-block">{{$errors->first('task_name')}}</span>
                </div>
            </div>
            <div class="form-group ">
                <div class="col-xs-12">
                    <textarea class="form-control" id="task_desc" name="task_desc" placeholder="Enter Task Description"
                              required="" style="height:300px;"></textarea>
                    <span class="email_error error-block">{{$errors->first('task_desc')}}</span>
                </div>
            </div>
            <div class="form-group ">
                <div class="col-xs-12">
                    <select class="task_type" name="task_type">
                        <option value="">Select your Task Type..</option>
                        <option value="B"> Bug</option>
                        <option value="M"> Modification</option>
                        <option value="T"> Task</option>
                    </select>
                    <span class="ps_error error-block">{{$errors->first('task_type')}}</span>
                </div>
            </div>

            <div class="form-group text-center m-t-20">
                <div class="col-xs-12">
                    <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light registerForm"
                            type="submit">ADD YOUR TASK
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

