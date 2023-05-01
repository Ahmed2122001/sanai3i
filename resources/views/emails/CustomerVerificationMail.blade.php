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
    <p>please click the button to verify your account </p>
    <button ><a href="{{ URL::temporarySignedRoute('verification.verifyCustomer',now()->addCenturiesNoOverflow(1),['id'=>$customer->id]) }}">Verify Account</a></button>
    <p>Thanks</p>
</div>
</body>
</html>
