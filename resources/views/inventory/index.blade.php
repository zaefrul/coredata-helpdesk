@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Inventory List</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                                        <li class="breadcrumb-item"><a href="/inventories">Inventory Manager</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Inventory list</li>
                                    </ol>
                                </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="d-flex">
                                <li>
                                    <a href="/projects/create" class="btn btn-md d-md-none btn-primary">
                                        <em class="icon ni ni-plus"></em>
                                        <span>Add</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/projects/create" class="btn btn-primary d-none d-md-inline-flex">
                                        <em class="icon ni ni-plus"></em>
                                        <span>Add Inventory</span>
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
                                        <span class="overline-title">Model</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Type</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Item</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">S/N</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">P/N</span>
                                    </th>
                                    <th class="tb-col tb-col-end" data-sortable="false">
                                        <span class="overline-title">Action</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($inventories->count())
                                    @foreach($inventories as $inventory)
                                        <tr>
                                            <td class="tb-col">
                                                <span>{{ $inventory->model }}</span>
                                            </td>
                                            <td class="tb-col">
                                                <span>
                                                    {{ \App\Helper\SettingHelper::getLabelValue('component_type', $inventory->type) }}
                                                </span>
                                            </td>
                                            <td class="tb-col">
                                                <span>{{ $inventory->item }}</span>
                                            </td>
                                            <td class="tb-col">
                                                <span>{{ $inventory->serial_number }}</span>
                                            </td>
                                            <td class="tb-col">
                                                <span>{{ $inventory->part_number }}</span>
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
                                                                    <a href="/inventories/{{$inventory->id}}/edit"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" onclick="deleteItem({{$inventory->id}})"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                                </li>
                                                                <li>
                                                                    <a href="/inventories/{{$inventory->id}}/show"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div><!-- dropdown -->
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">No inventory found</td>
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
    function deleteItem(id) {
        event.preventDefault();
        if(confirm('Are you sure you want to delete this item?')) {
            // create form and submit as destroy method
            let form = document.createElement('form');
            form.action = '/inventories/'+id;
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