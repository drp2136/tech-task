<html>
<head>
    <title>Profile </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
<div>
    @include('Freelancer::header')

    <div class="container row">
        <div class="col-md-8 col-lg-8 col-sm-12">

            <div class="white-box">
                <h3 class="card-title m-b-0">Account Overview</h3>
                <p class="text-muted m-b-30 font-13">Manage your account...</p>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td><i class="icon-user icons" data-icon="7"></i></td>
                            <td>User Name</td>
                            <td>{{Session::get('freelancer')['name']}}</td>
                        </tr>
                        <tr>
                            <td><span class="ti-email"></span></td>
                            <td>E-Mail</td>
                            <td>{{Session::get('freelancer')['email']}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>
