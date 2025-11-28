<!DOCTYPE html>
<html>
<head>
    <title>Welcome to {{ config('app.name') }}!</title>
</head>

<body>
<h2>Welcome to {{ config('app.name') }} {{$user['name']}}!</h2>
<p>Your sing-in email/username is {{$user['email']}}</p>
<hr>
<p>Use this link to sign-in <a href="{{ config('app.url') }}/login">{{ config('app.url') }}/login</a></p>

</body>

</html>