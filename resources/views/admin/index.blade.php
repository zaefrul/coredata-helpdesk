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
                                        <li class="breadcrumb-item"><a href="/resources">Admin Control Panel</a></li>
                                    </ol>
                                </nav>
                        </div>
                        
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"></h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Manage Component Type Option</p>

                                    {{-- list group button --}}
                                    <div class="list-group">
                                        <a href="/admin/migration" class="list-group-item list-group-item-action">Run Migration</a>
                                        <a href="/admin/seeder" class="list-group-item list-group-item-action">Run Seeder</a>
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