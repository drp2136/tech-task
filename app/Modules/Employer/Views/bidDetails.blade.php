<html>
<head>
    <title>Bid Details</title>
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

        table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        table td, table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>

<body>
<div>
    @include('Employer::header')

    <div class="table-responsive m-t-40">
        <table id="myTable" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Bid Amount</th>
                <th>Status</th>
                <th>Applyed On</th>
                <th>Take Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach($bids as $bidK=>$bid)
                <tr>
                    <td>{{$bidK+1}}</td>
                    <td>{{$bid->name}}</td>
                    <td>{{$bid->email}}</td>
                    <td>$ {{$bid->bid_amount}}</td>
                    <td>
                        <div class="status bidStatus{{$bid->bid_id}}">@if($bid->bid_status=='A')Accepted
                            @elseif($bid->bid_status=='C')Cancelled
                            @else Pending
                            @endif
                        </div>
                    </td>
                    <td>{{date('d-m Y', $bid->created_at)}}</td>
                    <td>@if($bid->status=='A' && $bid->bid_status!='C')
                            <button class="takeAction" data-bid_id="{{$bid->bid_id}}"
                                    data-bid_amount="{{$bid->bid_amount}}" data-job_id="{{$bid->bid_for_job}}">
                                Accept
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>

</div>

<script src="/assets/js/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.takeAction', function () {
            var bid_id = $(this).attr('data-bid_id');
            var job_id = $(this).attr('data-job_id');
            var bid_amount = $(this).attr('data-bid_amount');
            $.ajax({
                url: '/employer/employer-ajaxHandler',
                type: 'POST',
                dataType: 'json',
                data: {
                    method: 'jobBidAction',
                    job_id: job_id,
                    bid_id: bid_id,
                    bid_amount: bid_amount
                }
            }).success(function (resp) {
                alert(resp.message);
                $('.takeAction').remove();
                $('.status').text('');
                $('.bidStatus' + bid_id).text('Accepted');

            });
        });
    });
</script>


</body>
</html>
