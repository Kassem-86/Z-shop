<!DOCTYPE html>
<html>
<head>
    <title>Welcome to {{ config('app.name') }}</title>
</head>
<body>
    <h1>Hello, {{ $user->name }}!</h1>
    <p>Welcome to {{ config('app.name') }}. We are glad to have you on board.</p>
</body>
</html>
