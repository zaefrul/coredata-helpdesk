@extends('layouts.auth')

@section('css')
<style type="text/css">
    .hide-from-mobile {
        display: block;
    }

    .show-for-mobile {
        display: none;
    }

    @media(max-width: 576px) {
        .hide-from-mobile {
            display: none;
        }

        .show-for-mobile {
            display: block;
        }
    }
</style>
@endsection

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block">
                    <div class="card hide-from-mobile">
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
                                                    <span class="badge bg-primary text-white fs-6">Hardware</span>
                                                @else
                                                    <span class="badge bg-secondary text-white fs-6">Software</span>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="nk-invoice-head-item text-sm-end mt-5 nk-invoice-contract">
                                    <h5 class="text-uppercase text-muted">Contract Details</h5>
                                    <div class="nk-invoice-details mt-2">
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-3" style="text-align: justify;">
                                                <strong class="text-dark">Contract:</strong> 
                                                <span class="text-secondary">{{ $asset->contract->contract_name }}</span>
                                            </li>
                                            <li class="mb-3">
                                                <strong class="text-dark">Contract Number:</strong> 
                                                <span class="badge text-bg-light fs-6">{{ $asset->contract->contract_number }}</span>
                                            </li>
                                            <li class="mb-3">
                                                <strong class="text-dark">Warranty:</strong> 
                                                <span class="text-secondary">{{ $asset->purchased_date->format('d/M/Y') }} - {{ $asset->warranty_end->format('d/M/Y') }}</span> @if($asset->warranty_end->isPast()) <span class="badge text-bg-danger text-white fs-6">Expired</span> @else <span class="badge text-bg-success text-white fs-6">Active</span> @endif
                                            </li>
                                            <li class="mb-3">
                                                <strong class="text-dark">Warranty Level:</strong> 
                                                <span class="text-secondary">
                                                    @if($asset->warranty_level == 'third-party')
                                                        <span class="badge text-bg-warning fs-6">3rd Party</span>
                                                    @else
                                                        <span class="badge text-bg-success fs-6">Back to Back</span>
                                                    @endif
                                                </span>
                                            </li>
                                            @if($asset->location)
                                            <li class="mb-3">
                                                <strong class="text-dark">Location:</strong> 
                                                <span class="text-secondary">{{$asset->location}}</span>
                                            </li>
                                            @endif
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


                            <div class="nk-invoice-body mt-5">
                                <div class="table-responsive">
                                    <h4 class="nk-block-title mb-3">Preventive Maintenance</h4>
                                    <table class="table nk-invoice-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="tb-col"><span class="overline-title">PM Number</span></th>
                                                <th class="tb-col"><span class="overline-title">Title</span></th>
                                                <th class="tb-col"><span class="overline-title">Status</span></th>
                                                <th class="tb-col"><span class="overline-title">Schedule Date</span></th>
                                                <th class="tb-col tb-col-end"><span class="overline-title">Agent</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- preventive maintenance / schedule task --}}
                                            @php
                                                $count = $asset->contract->preventive_maintenance;

                                                if($count < $scheduleTasks->count()) {
                                                    $count = $scheduleTasks->count();
                                                }

                                            @endphp

                                            @if($count > 0)
                                                @for($i=0; $i<$count; $i++)
                                                    @if($scheduleTasks->count() > $i)
                                                        <tr>
                                                            <td class="tb-col">{{ $scheduleTasks[$i]->incident_number }}</td>
                                                            <td class="tb-col">{{ $scheduleTasks[$i]->title }}</td>
                                                            <td class="tb-col">
                                                                @if($scheduleTasks[$i]->status == 'open')
                                                                    <span class="badge text-bg-info">Pending</span>
                                                                @elseif($scheduleTasks[$i]->status == 'verified')
                                                                    <span class="badge text=bg-success">Completed</span>
                                                                @else
                                                                    <span class="badge text-bg-info">{{ \App\Models\Incident::STATUS_LABELS[$scheduleTasks[$i]->status] }}</span>
                                                                @endif
                                                            </td>
                                                            <td class="tb-col">{{ $scheduleTasks[$i]->start_date ? $scheduleTasks[$i]->start_date->format('d/m/Y') : $scheduleTasks[$i]->created_at->format('d/m/Y') }}</td>
                                                            <td class="tb-col tb-col-end">{{ $scheduleTasks[$i]->currentAssignee ? $scheduleTasks[$i]->currentAssignee->name : '-' }}</td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td class="tb-col">{{ $i+1 }}</td>
                                                            <td class="tb-col">Not Scheduled</td>
                                                            <td class="tb-col">
                                                                <span class="badge text-bg-warning">Not Scheduled</span>
                                                            </td>
                                                            <td class="tb-col">-</td>
                                                            <td class="tb-col tb-col-end">-</td>
                                                        </tr>
                                                    @endif
                                                @endfor
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- .nk-invoice -->
                    </div><!-- .card -->
                    <div class="card show-for-mobile">
                        <div class="row">
                            {{-- coredata logo --}}
                            <div class="col-12 text-center">
                                <a href="/" class="logo-link">
                                    <div class="logo-wrap m-3">
                                        <img class="logo-img logo-light" width="250px" height="auto" src="./images/2.png" srcset="./images/2.png" alt="">
                                        <img class="logo-img logo-dark" width="250px" height="auto" src="./images/2.png" srcset="./images/2.png" alt="">
                                        <img class="logo-img logo-icon" width="250px" height="auto" src="./images/2.png" srcset="./images/2.png" alt="">
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <table class="table nk-invoice-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="tb-col" colspan="2">
                                                <span class="text-secondary">{{ $asset->contract->contract_name }}</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="tb-col">
                                                <strong>Contract Number:</strong> 
                                            </td>
                                            <td>
                                                <span class="text-secondary">{{ $asset->contract->contract_number }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tb-col">
                                                <strong>Period:</strong> 
                                            </td>
                                            <td>
                                                <span class="text-secondary">{{ $asset->contract->start_date->format('Y') }} - {{ $asset->contract->end_date->format('Y') }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tb-col">
                                                <strong>Brand:</strong> 
                                            </td>
                                            <td>
                                                <span class="text-secondary">{{ $asset->brand }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tb-col">
                                                <strong>Serial Number:</strong> 
                                            </td>
                                            <td>
                                                <span class="text-secondary">{{ $asset->serial_number }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tb-col">
                                                <strong>Category:</strong> 
                                            </td>
                                            <td>
                                                @if($asset->category == 'hardware')
                                                    <span class="badge bg-primary text-white fs-6">Hardware</span>
                                                @else
                                                    <span class="badge bg-secondary text-white fs-6">Software</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tb-col">
                                                <strong>Warranty (from):</strong> 
                                            </td>
                                            <td>
                                                <span class="text-secondary">{{ $asset->purchased_date->format('d/M/Y') }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tb-col">
                                                <strong>Warranty (to):</strong> 
                                            </td>
                                            <td>
                                                <span class="text-secondary">{{ $asset->warranty_end->format('d/M/Y') }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tb-col">
                                                <strong>Warranty (Status):</strong>
                                            </td>
                                            <td>
                                                <span class="text-secondary">
                                                    @if($asset->warranty_end->isPast())
                                                        <span class="badge text-bg-danger text-white fs-6">Expired</span>
                                                    @else
                                                        <span class="badge text-bg-success text-white fs-6">Active</span>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tb-col">
                                                <strong>Warranty Level:</strong> 
                                            </td>
                                            <td>
                                                <span class="text-secondary">
                                                    @if($asset->warranty_level == 'third-party')
                                                        <span class="badge text-bg-warning fs-6">3rd Party</span>
                                                    @else
                                                        <span class="badge text-bg-success fs-6">Back to Back</span>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($asset->components->count() > 0)
                            {{-- header component --}}
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h4 class="nk-block-title mb-3 mt-3">Components</h4>
                                </div>
                            </div>
                            {{-- component table --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        @foreach($asset->components as $component)
                                            <table class="table nk-invoice-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="tb-col" colspan="2">
                                                            <span class="badge text-bg-info">{{ strtoupper(str_replace('_', ' ', $component->component_type)) }}</span>
                                                            <span class="overline-title">{{ $component->component_model }} - {{ $component->component_name }}</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="tb-col">
                                                            <strong>Serial Number:</strong> 
                                                        </td>
                                                        <td>
                                                            <span class="text-secondary">{{ $component->serial_number }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tb-col">
                                                            <strong>Part Number:</strong> 
                                                        </td>
                                                        <td>
                                                            <span class="text-secondary">{{ $component->part_number }}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        {{-- preventive maintenance / schedule task --}}
                        @php
                            $count = $asset->contract->preventive_maintenance;

                            if($count < $scheduleTasks->count()) {
                                $count = $scheduleTasks->count();
                            }

                        @endphp
    
                        @if($count > 0)
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table nk-invoice-table">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th colspan="3">Preventive Maintenance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for($i=0; $i<$count; $i++)
                                                    <tr>
                                                        <td class="tb-col" colspan="2">
                                                            <span class="overline-title">PM - {{ $i+1 }}</span>
                                                        </td>
                                                        <td class="tb-col tb-col-end">
                                                            @if($scheduleTasks->count() > $i )
                                                                @if($scheduleTasks[$i]->status == 'open')
                                                                    <span class="badge text-bg-info">Pending</span>
                                                                @elseif($scheduleTasks[$i]->status == 'verified')
                                                                    <span class="badge text-bg-success">Completed</span>
                                                                @else
                                                                    <span class="badge text-bg-info">{{ \App\Models\Incident::STATUS_LABELS[$scheduleTasks[$i]->status] }}</span>
                                                                @endif
                                                                <span class="badge text-bg-light" style="margin-left: 0.5rem">{{ $scheduleTasks[$i]->start_date ? $scheduleTasks[$i]->start_date->format('d/m/Y') : $scheduleTasks[$i]->created_at->format('d/m/Y') }}</span>
                                                            @else
                                                                <span class="badge text-bg-info">Pending</span>
                                                                <span class="badge text-bg-warning">Not Scheduled</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- end prevntive maintenance --}}

                        {{-- activity logs --}}
                        @if($replaceComponentLogs->count() > 0)
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table nk-invoice-table">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th colspan="3">Activity Logs</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($replaceComponentLogs as $log)
                                                    <tr>
                                                        <td colspan="3" class="tb-col ">
                                                            {{ $log->description }} - <span class="badge text-bg-light">{{ $log->created_at->format('d/m/Y') }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row mt-3 mb-3">
                            <div class="col-12 d-flex justify-content-center align-items-center">
                                <a href="{{ route('incidents.frompublic', ['contractid' => $asset->contract_id, 'assetid' => $asset->id,]) }}" class="btn btn-warning btn-sm">Report an Incident</a>
                            </div>
                        </div>
                    </div>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection