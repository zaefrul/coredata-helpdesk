{{-- blade component to show status and define badge color --}}
@props(['status'])

@php
    $badgeColor = 'success';
    // if status is active, set badge color to success
    if ($status !== 'active') {
        $badgeColor = 'danger';
    }
@endphp

<span class="badge text-bg-{{ $badgeColor }}-soft">{{ ucfirst($status) }}</span>
{{-- end of blade component --}}