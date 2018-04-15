<html>
<head>
    <title> Check Progress </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
<div>
    @include('Freelancer::header')

    <div class="col-md-12">
        <div class="card jobs">
            <div>
                @php(end($takenJobs))
                @foreach($takenJobs as $key=>$job)
                    <div class="JobSearchCard-item ">
                        <div class="JobSearchCard-item-inner" data-project-card="true">
                            <div class="JobSearchCard-primary">
                                <div class="JobSearchCard-primary-heading">{{$job->job_heading}}
                                    <span class="JobSearchCard-primary-heading-Days" style="margin-left: 150px;display: inline-block;">
                                        {{date('m, Y', $job->updated_at)}}
                                    </span>
                                </div>

                                <p class="JobSearchCard-primary-description">{{$job->job_desc}}</p>

                                <div class="JobSearchCard-primary-hidden">
                                    <div class="JobSearchCard-primary-price">₹{{$job->bid_amount}}</div>
                                </div>

                                <div class="JobSearchCard-primary-hidden">
                                    <div class="JobSearchCard-primary-price">
                                        @if($job->status=='T')
                                            <a class="checkTask" href="/check-tasks/{{$job->job_id}}">Check All Tasks</a>
                                        @else This Job is Completed.
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($key!=key($takenJobs))
                        <hr>
                    @endif
                @endforeach
            </div>

        </div>

        <div class="card tasks" style="display: none">
            <button class="returnToJobs">Go back.</button>
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

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>


</body>
</html>
