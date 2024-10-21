@extends('layouts.main')

@php
    $admin = Auth::user()->role == 'admin' ? true : false;
@endphp
                        

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">User Details</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    @if($admin)
                                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User Management</a></li>
                                    @endif
                                    <li class="breadcrumb-item active" aria-current="page">{{$user->designation ? $user->designation . ' - ' : ''}}{{ $user->name }}</li>
                                </ol>
                            </nav>
                        </div>
                        @if($admin)
                        <div class="nk-block-head-content">
                            <ul class="d-flex g-3">
                                <li style="margin-right: 1rem">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-md btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="Edit user.">
                                        <em class="icon ni ni-edit"></em>
                                    </a>
                                </li>
                                <li style="margin-right: 1rem">
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-md btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="Delete.">
                                            <em class="icon ni ni-trash"></em>
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <a href="javascript:history.back()" class="btn btn-md btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="Back.">
                                        <em class="icon ni ni-arrow-left"></em>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        @endif
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->

                <div class="nk-block">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-4">
                            <div class="card card-bordered">
                                <div class="card-body">
                                    <div class="user-card user-card-s2">
                                        <div class="d-flex flex-column flex-md-row align-items-md-center">
                                            <div class="media media-huge media-circle">
                                                @php
                                                    $path = 'images/avatar/3.png';
                                                    if($user->profile_photo_path){
                                                        $path = '/'.$user->profile_photo_path;
                                                    }
                                                    else if($user->role != 'user'){
                                                        $path = '/images/avatar/agent.png';
                                                    }
                                                    else {
                                                        $path = '/images/avatar/3.png';
                                                    }

                                                @endphp
                                                <img src="{{ $path }}" alt="">
                                            </div>
                                            <div class="mt-3 mt-md-0 ms-md-3">
                                                <h3 class="title mb-1">{{$user->name}}</h3>
                                                <span class="small">
                                                    @if($user->role == 'admin')
                                                        <span class="badge text-bg-primary">Admin</span>
                                                    @elseif($user->role == 'agent')
                                                        <span class="badge text-bg-info">Agent</span>
                                                    @else
                                                        <span class="badge text-bg-success">User</span>
                                                    @endif
                                                </span>
                                                <div class="d-flex align-items-center mt-1"><em class="icon ni ni-mail" style="margin-right: 0.5rem"></em><span class="small">{{$user->email}}</span></div>
                                                <div class="d-flex align-items-center"><em class="icon ni ni-mobile" style="margin-right: 0.5rem"></em><span class="small">{{$user->phone_number}}</span></div>
                                                @if($user->designation)
                                                <div class="d-flex align-items-center"><em class="icon ni ni-network" style="margin-right: 0.5rem"></em><span class="small">{{$user->designation}}</span></div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tooltips = document.querySelectorAll('[data-toggle="tooltip"]');
        tooltips.forEach(function(tooltip) {
            tooltip.addEventListener("mouseover", function() {
                tooltip.setAttribute("title", tooltip.getAttribute("data-original-title"));
            });
            tooltip.addEventListener("mouseout", function() {
                tooltip.removeAttribute("title");
            });
        });
    });
</script>
@endsection
