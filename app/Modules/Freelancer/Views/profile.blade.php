<html>
<head>
    <title>Profile </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
<div>
    @include('Freelancer::header')

    <div class="table-responsive" style="display: inline-block">
        <table class="table">
            <tbody>
            <tr>
                <td>User Name</td>
                <td>{{Session::get('freelancer')['name']}}</td>
            </tr>
            <tr>
                <td>E-Mail</td>
                <td>{{Session::get('freelancer')['email']}}</td>
            </tr>
            </tbody>
        </table>
    </div>


</div>
</body>
</html>
