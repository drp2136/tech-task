<html>
<head>
    <title>Check Task </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
<div>
    @if(Session::has('success') || Session::has('error'))
        <div class="alert alert-block @if($message = Session::get('success'))alert-success @elseif($message = Session::get('error'))alert-danger @endif">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @include('Employer::header')

    <div class="ProjectSearch-content">

        <div class="card tasks">
            <div class="content table-responsive table-full-width">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Assigned By</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody class="taskbody">
                    @foreach($takenJobs as $keyJ => $job)
                        <tr>
                            <td>{{$keyJ+1}}</td>
                            <td>{{$job->task_name}}</td>
                            <td>{{$job->task_desc}}</td>
                            <td>
                                @if($job->task_category=='B') Bug
                                @elseif($job->task_category=='M') Modification
                                @elseif($job->task_category=='T') Task
                                @endif
                            </td>
                            <td>
                                @if($job->task_assign_by=='E') Employer
                                @elseif($job->task_assign_by=='F') Freelancer
                                @endif
                            </td>
                            <td data-task_id="{{$job->task_id}}">
                                <select name="taskStatus" id="taskStatus">
                                    <option value="A" @if($job->task_status == 'A')selected @endif> Assigned</option>
                                    <option value="C" @if($job->task_status == 'C')selected @endif> Completed</option>
                                    <option value="P" @if($job->task_status == 'P')selected @endif> Progress</option>
                                    <option value="R" @if($job->task_status == 'R')selected @endif> Reassigned</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</div>

<script src="/assets/js/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.close', function () {
            $('.alert.alert-block').hide();
        });


        $(document).on('change', '#taskStatus', function () {
            let taskDiv = $(this);
            let task_id = $(this).parent('td').attr('data-task_id');
            let task_status = $(this).val();
            console.log(task_status, task_id);
            $.ajax({
                url: '/employer/employer-ajaxHandler',
                type: 'POST',
                dataType: 'json',
                data: {
                    method: 'changeTaskStatus',
                    task_status: task_status,
                    task_id: task_id
                }
            }).success(function (resp) {
                if (resp) $(taskDiv).val(task_status);
            });
        });


    });
</script>

</body>
</html>
