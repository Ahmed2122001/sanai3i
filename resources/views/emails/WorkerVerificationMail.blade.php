<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>email Verification</title>
</head>
<body>
<div>
    <h1> Worker email Verification</h1>
    <p>Hi {{ $worker->name }}</p>
    <p>please click the button to verify the link will expire after 10 Minutes </p>
    <a href="{{ URL::temporarySignedRoute('verification.verifyًWorker',now()->addMinutes(10),['id'=>$worker->id]) }}" class="btn btn-primary">Verify Account</a>
</div>
</body>
</html>
