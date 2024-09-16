@extends('layouts.main')

@section('content')
@php $isAdmin = Auth::user()->role == 'admin' @endphp
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
                            @if($isAdmin)
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
                            @endif
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card">
                        <table class="datatable-init table" data-nk-container="table-responsive">
                            <thead class="table-light">
                                <tr>
                                    <th class="tb-col">
                                        <span class="overline-title">Customer</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Prefix</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Contact</span>
                                    </th>
                                    <th class="tb-col tb-col-xl">
                                        <span class="overline-title">Phone</span>
                                    </th>
                                    @if($isAdmin)
                                    <th class="tb-col tb-col-end" data-sortable="false">
                                        <span class="overline-title">Action</span>
                                    </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    @foreach($customer->departments as $department)
                                        <tr>
                                            <td class="tb-col">
                                                <div class="media-group">
                                                    <div class="media-text">
                                                        <a href="{{route('customers.show', $customer->id)}}" class="title">{{$customer->company_name}}</a>
                                                        <span class="small text">{{$department->name}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tb-col">{{$customer->prefix}}</td>
                                            <td class="tb-col tb-col-xl">
                                                @if($department->pc_name == null)
                                                    <span class="small text">No contact person</span>
                                                @else
                                                    <div class="media-text">
                                                        <a href="#" class="title">{{$department->pc_name}}</a>
                                                        <span class="small text">{{$department->pc_email}}</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="tb-col tb-col-xl">
                                                <span class="small text">{{$department->pc_phone}}</span>
                                            </td>
                                            @if($isAdmin)
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
                                            @endif
                                        </tr>
                                    @endforeach
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
        if(confirm('By removing this customer means you will remove all the associate projects, assets, components, and accounts. Are you sure to proceed?')) {
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