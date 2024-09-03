@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Customers List</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                                        <li class="breadcrumb-item"><a href="/customers">Customer Manage</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Customers</li>
                                    </ol>
                                </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="d-flex">
                                <li>
                                    <a href="/customers/create" class="btn btn-md d-md-none btn-primary">
                                        <em class="icon ni ni-plus"></em>
                                        <span>Add</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/customers/create" class="btn btn-primary d-none d-md-inline-flex">
                                        <em class="icon ni ni-plus"></em>
                                        <span>Add Customer</span>
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
                                        <span class="overline-title">Company</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Phone</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">email</span>
                                    </th>
                                    <th class="tb-col tb-col-xl">
                                        <span class="overline-title">prefix</span>
                                    </th>
                                    <th class="tb-col tb-col-xxl">
                                        <span class="overline-title">Created</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Status</span>
                                    </th>
                                    <th class="tb-col tb-col-end" data-sortable="false">
                                        <span class="overline-title">Action</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <td class="tb-col">
                                            <div class="media-group">
                                                <div class="media media-md media-middle media-circle text-bg-info-soft">
                                                    <span class="smaller">{{$customer->prefix}}</span>
                                                </div>
                                                <div class="media-text">
                                                    <a href="{{route('customers.show', $customer->id)}}" class="title">{{$customer->company_name}}</a>
                                                    <span class="small text">{{$customer->contact_person}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="tb-col">{{$customer->phone_number}}</td>
                                        <td class="tb-col tb-col-xl">{{$customer->email}}</td>
                                        <td class="tb-col">
                                            <span class="badge text-bg-dark-soft">{{$customer->prefix}}</span></td>
                                        <td class="tb-col tb-col-xxl">{{$customer->created_at->diffForHumans()}}</td>
                                        <td class="tb-col">
                                            <x-badge-status :status="$customer->status"/>
                                        </td>
                                        <td class="tb-col tb-col-end">
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                    <em class="icon ni ni-more-v"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                    <div class="dropdown-content py-1">
                                                        <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                            <li>
                                                                <a href="/customers/{{$customer->id}}/edit"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="#" onclick="deleteCustomer({{$customer->id}})"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="{{route('customers.show', $customer->id)}}"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- dropdown -->
                                        </td>
                                    </tr>
                                @endforeach
                                @if(count($customers) == 0)
                                    <tr>
                                        <td colspan="7" class="text-center">No customer found. Please add customer in the create customer form.</td>
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
    function deleteCustomer(id) {
        event.preventDefault();
        if(confirm('Are you sure you want to delete this customer?')) {
            // create form and submit as destroy method
            let form = document.createElement('form');
            form.action = '/customers/'+id;
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