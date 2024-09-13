<!DOCTYPE html>
<html>
<head>
    <title>Incident Notification</title>
</head>
<body>
    <h1>New Incident Created</h1>
    <p>Hello {{ $user->name }},</p>
    <p>An incident with the title <b>"{{ $incident->title }}"</b> has been created.</p>
    <p>Incident ID: <b>{{ $incident->incident_number }}</b></p>
    <p>Please log in to view the details.</p>
</body>
</html>
