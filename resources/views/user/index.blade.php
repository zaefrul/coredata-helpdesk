@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">User Account List</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                                        <li class="breadcrumb-item"><a href="/project">Account Manager</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Account list</li>
                                    </ol>
                                </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="d-flex">
                                <li>
                                    <a href="/users/create" class="btn btn-md d-md-none btn-primary">
                                        <em class="icon ni ni-plus"></em>
                                        <span>Add</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/users/create" class="btn btn-primary d-none d-md-inline-flex">
                                        <em class="icon ni ni-plus"></em>
                                        <span>Add Account</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card">
                        <table class="datatable-init table" data-nk-container="table-responsive">
                            <thead class="table-light">
                                <tr>
                                    <th class="tb-col">
                                        <span class="overline-title">Detail</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Phone</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Email</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Role</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Created</span>
                                    </th>
                                    <th class="tb-col tb-col-end" data-sortable="false">
                                        <span class="overline-title">Action</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td class="tb-col">
                                            <div class="media-group">
                                                <div class="media media-md media-middle media-circle text-bg-info-soft">
                                                    @if($user->profile_photo_path)
                                                        <img src="{{asset($user->profile_photo_path)}}" alt="{{$user->name}}">
                                                    @else
                                                        <span class="smaller">{{$user->name[0]}}</span>
                                                    @endif
                                                </div>
                                                <div class="media-text">
                                                    <a href="/users/{{$user->id}}/show" class="title">{{$user->name}}</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="tb-col">{{$user->phone_number}}</td>
                                        <td class="tb-col">{{$user->email}}</td>
                                        <td class="tb-col">
                                            @if($user->role == 'admin')
                                                <span class="badge text-bg-primary">Admin</span>
                                            @elseif($user->role == 'agent')
                                                <span class="badge text-bg-info">Agent</span>
                                            @else
                                                <span class="badge text-bg-success">User</span>
                                            @endif
                                        </td>
                                        <td class="tb-col">{{$user->created_at->diffForHumans()}}</td>
                                        <td class="tb-col tb-col-end">
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                    <em class="icon ni ni-more-v"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                    <div class="dropdown-content py-1">
                                                        <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                            <li>
                                                                <a href="/users/{{$user->id}}/edit"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="#" onclick="deleteUsers({{$user->id}})"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="/users/{{$user->id}}/show"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- dropdown -->
                                        </td>
                                    </tr>
                                @endforeach
                                @if(count($users) == 0)
                                    <tr>
                                        <td colspan="7" class="text-center">No project found. Please add project in the create project form.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="/assets/js/data-tables/data-tables.js"></script>
<script>
    // function for a tag onclick event to delete customer
    function deleteUsers(id) {
        event.preventDefault();
        if(confirm('Are you sure you want to delete this user?')) {
            // create form and submit as destroy method
            let form = document.createElement('form');
            form.action = '/users/'+id;
            form.method = 'POST';
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endsection