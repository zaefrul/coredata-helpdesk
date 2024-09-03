@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Asset Details</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item"><a href="/resources">Asset Manager</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $asset->name }}</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="d-flex">
                                <li>
                                    <a href="/assets/{{ $asset->id }}/edit" class="btn btn-md d-md-none btn-primary">
                                        <em class="icon ni ni-edit"></em>
                                    </a>
                                </li>
                                <li>
                                    <a href="/assets/{{ $asset->id }}/edit" class="btn btn-primary d-none d-md-inline-flex">
                                        <em class="icon ni ni-edit"></em>
                                    </a>
                                </li>
                            </ul>
                            <ul class="d-flex">
                                <li>
                                    <a href="/assets/{{ $asset->id }}/edit" class="btn btn-md d-md-none btn-danger">
                                        <em class="icon ni ni-trash"></em>
                                    </a>
                                </li>
                                <li>
                                    <a href="/assets/{{ $asset->id }}/edit" class="btn btn-danger d-none d-md-inline-flex">
                                        <em class="icon ni ni-trash"></em>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                
                <div class="nk-block">
                    <div class="card">
                        <div class="nk-invoice">
                            <div class="nk-invoice-head flex-column flex-sm-row">
                                <div class="nk-invoice-head-item mb-3 mb-sm-0">
                                    <a href="/" class="logo-link">
                                        <div class="logo-wrap">
                                            <img class="logo-img logo-light" width="250px" height="auto" src="./images/2.png" srcset="./images/2.png" alt="">
                                            <img class="logo-img logo-dark" width="250px" height="auto" src="./images/2.png" srcset="./images/2.png" alt="">
                                            <img class="logo-img logo-icon" width="250px" height="auto" src="./images/2.png" srcset="./images/2.png" alt="">
                                        </div>
                                    </a>
                                    <h3 class="text-uppercase text-muted">{{ $asset->name }}</h3>
                                    <div class="nk-invoice-details mt-2">
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-1">
                                                <strong class="text-dark">Brand:</strong> 
                                                <span class="text-secondary">{{ $asset->brand }}</span>
                                            </li>
                                            <li class="mb-1">
                                                <strong class="text-dark">Serial Number:</strong> 
                                                <span class="text-secondary">{{ $asset->serial_number }}</span>
                                            </li>
                                            <li class="mb-1">
                                                <strong class="text-dark">Category:</strong> 
                                                @if($asset->category == 'hardware')
                                                    <span class="badge bg-primary text-white">Hardware</span>
                                                @else
                                                    <span class="badge bg-secondary text-white">Software</span>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="nk-invoice-head-item text-sm-end mt-5">
                                    <h5 class="text-uppercase text-muted">Contract Details</h5>
                                    <div class="nk-invoice-details mt-2">
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-1">
                                                <strong class="text-dark">Contract:</strong> 
                                                <span class="text-secondary">{{ $asset->contract->contract_name }} [{{ $asset->contract->contract_number }}]</span>
                                            </li>
                                            <li class="mb-1">
                                                <strong class="text-dark">Warranty Start:</strong> 
                                                <span class="text-secondary">{{ $asset->purchased_date->format('d-M-Y') }}</span>
                                            </li>
                                            <li class="mb-1">
                                                <strong class="text-dark">Warranty End Date:</strong> 
                                                <span class="text-secondary">{{ $asset->warranty_end->format('d-M-Y') }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <hr />
                            
                            <div class="nk-invoice-body mt-5">
                                <div class="table-responsive">
                                    <h4 class="nk-block-title mb-3">Components</h4>
                                    <table class="table nk-invoice-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="tb-col"><span class="overline-title">Component Model</span></th>
                                                <th class="tb-col"><span class="overline-title">Component Name</span></th>
                                                <th class="tb-col"><span class="overline-title">Serial Number</span></th>
                                                <th class="tb-col"><span class="overline-title">Part Number</span></th>
                                                <th class="tb-col tb-col-end"><span class="overline-title">Type</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($asset->components as $component)
                                            <tr>
                                                <td class="tb-col">{{ $component->component_model }}</td>
                                                <td class="tb-col">{{ $component->component_name }}</td>
                                                <td class="tb-col">{{ $component->serial_number }}</td>
                                                <td class="tb-col">{{ $component->part_number }}</td>
                                                <td class="tb-col tb-col-end">
                                                    <span class="badge text-bg-info-soft">{{ strtoupper(str_replace('_', ' ', $component->component_type)) }}</span>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @if($asset->components->count() == 0)
                                            <tr>
                                                <td colspan="5" class="text-center">No components found for this asset.</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4"><strong>Total Components:</strong></td>
                                                <td class="tb-col-end"><strong>{{ $asset->components->count() }}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div><!-- .nk-invoice-body -->
                        </div><!-- .nk-invoice -->
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
    function deleteAsset(id) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this asset?')) {
            let form = document.createElement('form');
            form.action = '/assets/' + id;
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
