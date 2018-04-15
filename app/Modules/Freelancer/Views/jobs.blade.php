<html>
<head>
    <title>Jobs </title>
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
<div>
    @include('Freelancer::header')

    <div class="ProjectSearch-content">
        <div id="project-list" class="JobSearchCard-list">
            @foreach($jobs as $job)
                <div class="JobSearchCard-item ">
                    <div class="JobSearchCard-item-inner" data-project-card="true">
                        <div class="JobSearchCard-primary">
                            <div class="JobSearchCard-primary-heading">{{$job->job_heading}}
                                <span class="JobSearchCard-primary-heading-Days">{{date('m, Y', $job->created_at)}}</span>
                            </div>

                            <p class="JobSearchCard-primary-description">
                                {{$job->job_desc}}
                            </p>

                            <div class="JobSearchCard-primary-hidden">
                                <div class="JobSearchCard-primary-price">₹{{$job->amnt_offer}}</div>
                            </div>

                            <div class="JobSearchCard-primary-hidden">
                                <div class="JobSearchCard-primary-price">
                                    @if(Session::has('freelancer') && !in_array($job->job_id, $bids))
                                        <button class="bidJob" data-job_id="{{$job->job_id}}"
                                                data-amnt_offer="{{$job->amnt_offer}}">BID for this Job
                                        </button>
                                    @else You already BID for this Job.
                                    @endif

                                </div>
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
        $(document).on('click', '.bidJob', function () {
            let job_id = $(this).attr('data-job_id');
            $('.bidAmount').hide().siblings('.bidJob').show();
            $(this).after('<span class="bidAmount"> BId Amount: <input type="text" class="myBidAmount"><button data-job_id="' + job_id + '" class="bidThisJob">BID</button><button class="cancelBid">Cancel</button></span>').hide();

        });

        $(document).on('click', '.bidThisJob', function () {
            if (confirm('Are you sure to Bid for this Job?')) {
                var bidJobs = $(this);
                var jobId = $(this).attr('data-job_id');
                var bid_amount = $('.myBidAmount').val();
                $.ajax({
                    url: '/freelancer-ajaxHandler',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        method: 'bidJob',
                        jobId: jobId,
                        bid_amount: bid_amount
                    }
                }).success(function (resp) {
                    alert(resp.message);
                    $(bidJobs).parent().text('Already BID');
                });
            } else {
                $('.bidJob').show();
                $('.bidAmount').remove();
                count--;
            }
        });

        $(document).on('click', '.cancelBid', function () {
            $(this).parent('.bidAmount').hide().siblings('.bidJob').show();

        });
    });
</script>
</body>
</html>
