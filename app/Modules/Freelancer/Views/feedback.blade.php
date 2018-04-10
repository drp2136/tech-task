<html>
<head>
    <title> FeedBack </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
<div>
    @include('Freelancer::header')

    <h3 class="card-title m-b-0">Your Feedback</h3>

    <div class="col-md-12">
        <div class="card">
            <div class="content table-responsive table-full-width">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Rating</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($feedback as $notiK=>$feeds)
                        <tr>
                            {{--<tr style="@if($notifi->notf_status=='U')background-color: antiquewhite; @endif">--}}
                            <td>{{$notiK+1}}</td>
                            <td>{{$feeds->title}}</td>
                            <td>{{$feeds->desc}}</td>
                            <td>{{$feeds->rating}}</td>
                            <td>{{date('d-M, Y h:i:s', $feeds->created_at)}}</td>
                        </tr>
                    @endforeach
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


<script src="/assets/js/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.deleteNotf', function () {
            let notify = $(this);
            let notf_id = $(this).attr('data-notf_id');
            $.ajax({
                url: '/employer/employer-ajaxHandler',
                type: 'POST',
                dataType: 'json',
                data: {
                    method: 'deleteNotfication',
                    notf_id: notf_id
                }
            }).success(function (resp) {
                alert(resp.message);
                $(notify).parent().parent().remove();

            });
        });
    });
</script>

</body>
</html>
