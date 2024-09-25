@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Report & Data Extraction</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                                        <li class="breadcrumb-item"><a href="/reports">Report & Data Extraction</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Report list</li>
                                    </ol>
                                </nav>
                        </div>
                        <div class="nk-block-head-content">
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <h6 class="card-title">Report - Cases by Contract</h6>
                                </div>
                            </div>
                            <form action="{{route('reports.case_by_contract')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contract">Contract</label>
                                            <select class="js-select" id="contract_id" name="contract_id" data-search="true">
                                                @foreach($contracts as $contract)
                                                <option value="{{$contract->id}}">{{$contract->contract_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">Generate Report</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="card-title">Report Generation Status</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="datatable-init table" data-nk-container="table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Generated At</th>
                                                <th>Report Name</th>
                                                <th>Status</th>
                                                <th>Download</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($requestReport as $report)
                                            <tr>
                                                <td>
                                                    {{-- if less than one day show diffForHumans else show normal datetime --}}
                                                    @if($report->created_at->diffInDays() < 1)
                                                        {{$report->created_at->diffForHumans()}}
                                                    @else
                                                        {{$report->created_at}}
                                                    @endif
                                                </td>
                                                <td>{{\App\Models\RequestReport::LABEL[$report->report_type]}}</td>
                                                <td>
                                                    @if($report->status == 'pending')
                                                        <span class="badge text-bg-light">Pending</span>
                                                    @elseif($report->status == 'extracting')
                                                        <span class="badge text-bg-warning">Extracting</span>
                                                    @elseif($report->status == 'completed' || $report->status == 'emailed')
                                                        <span class="badge text-bg-success">Completed</span>
                                                    @elseif($report->status == 'failed')
                                                        <span class="badge text-bg-danger">Failed</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($report->status == 'completed' || $report->status == 'emailed' && $report->report_file)
                                                        <a href="{{$report->report_file}}" class="btn btn-primary">Download</a>
                                                    @else
                                                        <span class="badge text-bg-light">N/A</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                            @if(count($requestReport) == 0)
                                            <tr>
                                                <td colspan="4" class="text-center">No report generated</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
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
<script src="/assets/js/data-tables/data-tables.js"></script>
@endsection