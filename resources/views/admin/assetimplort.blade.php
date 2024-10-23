@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Administrator Control Panel</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                                        <li class="breadcrumb-item"><a href="/admin">Admin Control Panel</a></li>
                                        <li class="breadcrumb-item">Import Asset</li>
                                    </ol>
                                </nav>
                        </div>
                        
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-gutter-md">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group mt-3">
                                        <label class="form-label" for="project">Select Project</label>
                                        <div class="form-control-wrap">
                                            <select class="js-select" id="project" name="project" data-search="true">
                                                @foreach($contracts as $contract)
                                                    <option value="{{$contract->id}}">{{$contract->contract_name}} - {{$contract->customer->company_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary" id="generate">Generate QR</button>
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
@endsection