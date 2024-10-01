<!DOCTYPE html>
<html>
    <head>
        <title>Preventive Maintenance Notification</title>
    </head>
    <body>
        <img src="{{ asset('images/3.png') }}" alt="Logo" width="auto" height="30">
        <h1>Preventive Maintenance Notification</h1>
        <p>Hello {{ $user->designation ? $user->designation . ' ' : '' }}{{ $user->name }},</p>
        <p>A preventive maintenance with the title <b>{{ $incident->title }}</b> will start on <b>{{ $incident->start_date }}</b>.</p>
        <p>Preventive Maintenance ID: <a href="{{route('incidents.show', $incident->incident_number)}}">{{ $incident->incident_number }}</a></p>
        <p>Please log in to view the details.</p>
    </body>
</html>