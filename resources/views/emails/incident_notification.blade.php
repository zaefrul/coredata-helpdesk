<!DOCTYPE html>
<html>
<head>
    <title>Incident Notification</title>
</head>
<body>
    <img src="{{ asset('images/3.png') }}" alt="Logo" width="auto" height="50">
    <h1>New Incident Created</h1>
    <p>Hello {{ $user->name }},</p>
    <p>An incident with the title <b>{{ $incident->title }}</b> has been created.</p>
    <p>We will keep you updated on the progress of this incident.</p>
    <p>Incident ID: <a href="{{route('incidents.show', $incident->id)}}">{{ $incident->incident_number }}</a></b></p>
    <p>Please log in to view the details.</p>
</body>
</html>
