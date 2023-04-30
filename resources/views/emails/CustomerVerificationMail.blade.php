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
    <h1> Customer email Verification</h1>
    <p>Hi {{ $customer->name }}</p>
    <p>please click the button to verify </p>
    <a href="{{ URL::temporarySignedRoute('verification.verify',now()->addMinutes(30),['id'=>$customer->id]) }}" class="btn btn-primary">Verify Account</a>
    {{--    <a href="{{ route('verify', $user->verification_token) }}" class="btn btn-primary">Verify Account</a>--}}
</div>
</body>
</html>
