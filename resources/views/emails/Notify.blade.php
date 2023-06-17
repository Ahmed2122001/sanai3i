<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>email notification</title>
</head>
<body>
<div>
    <h1> Worker email notification</h1>
    <p>أهلا  {{ $mailBody->name }}</p>
    <p>{{ $mailBody->message }}</p>
</div>
</body>
</html>
