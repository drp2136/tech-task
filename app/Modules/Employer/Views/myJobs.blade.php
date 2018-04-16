<html>
<head>
    <title>My Jobs </title>
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
        <div id="project-list" class="card JobSearchCard-list">
            @foreach($jobs as $job)
                <div class="JobSearchCard-item ">
                    <div class="JobSearchCard-item-inner" data-project-card="true">
                        <div class="JobSearchCard-primary">
                            <div class="JobSearchCard-primary-heading">{{$job->job_heading}}
                                <span class="JobSearchCard-primary-heading-Days">&nbsp;&nbsp;&nbsp;Posted On : {{date('d-m, Y', $job->created_at)}}</span>
                            </div>

                            <p class="JobSearchCard-primary-description">{{$job->job_desc}}</p>

                            <div class="JobSearchCard-primary-hidden">
                                <div class="JobSearchCard-primary-price">₹{{$job->amnt_offer}}</div>
                            </div>

                            <div class="JobSearchCard-primary-hidden">
                                <a class="bidDetails" data-job_id="{{$job->job_id}}"
                                   href="/employer/check-bids/{{$job->job_id}}">BID Details</a>
                                &nbsp;&nbsp;&nbsp;
                                @if($job->status=='C')
                                    <a class="giveFeedback" href="/employer/post-feedback/{{$job->job_id}}">Give a
                                        FeedBack</a>
                                @else
                                    {{--<a href="javascript:;" class="checkTask">Check All Tasks</a>--}}
                                    <a href="/employer/check-tasks/{{$job->job_id}}" class="checkTask">Check All Tasks</a>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>

    </div>
</div>

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
