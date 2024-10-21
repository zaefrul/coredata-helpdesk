<!DOCTYPE html>
<html>
<head>
    <title>Incident Notification</title>
</head>
<body>
    <img src="{{ asset('images/3.png') }}" alt="Logo" width="auto" height="30">
    <h1>Incident Update</h1>
    <p>Hello {{ $user->name }},</p>
    <p>An incident with the title <b>{{ $incident->title }}</b> has been updated.</p>
    <p>Incident ID: <a href="{{route('incidents.show', $incident->id)}}">{{ $incident->incident_number }}</a></p>
    <p>Please log in to view the details.</p>
</body>
</html>
