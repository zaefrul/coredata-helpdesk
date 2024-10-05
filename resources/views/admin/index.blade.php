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
                                </ol>
                            </nav>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-title">Application Settings</p>
                                    <p class="text-info small fw-ligt fst-italic">Adjust value for the application</p>
                                    {{-- list group button --}}
                                    <div class="list-group">
                                        <a href="/admin/components" class="list-group-item list-group-item-action">Component Type Setting</a>
                                        @php($switch = \App\Helper\SettingHelper::getValue('email_service', 'switch') == 'on' ? true : false)
                                        <div class="list-group-item d-flex justify-content-between">
                                            <span>Email Service</span>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" value="on" id="emailService" @if($switch) checked @endif>
                                                <label class="form-check-label" for="emailService">
                                                    @if($switch)
                                                        <span class="badge text-bg-success">ON</span>
                                                    @else
                                                        <span class="badge text-bg-danger-soft">OFF</span>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>
                                        <a href="{{route('settings.assets.qr')}}" class="list-group-item list-group-item-action">Regenerate Assets QR Code</a>
                                        <a href="{{route('settings.emails')}}" class="list-group-item list-group-item-action">Contract End Email(s) Setting</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-title">Critical Component [Developer Option]</p>
                                    <p class="text-danger small fw-ligt fst-italic">* Danger! this option could potentialy break the application!</p>
                                    {{-- list group button --}}
                                    <div class="list-group">
                                        <a href="/admin/migration" class="list-group-item list-group-item-action bg-danger-soft">Run Migration</a>
                                        <a href="/admin/seeder" class="list-group-item list-group-item-action bg-danger-soft">Run Seeder</a>
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
    document.addEventListener('DOMContentLoaded', function() {
        const emailService = document.getElementById('emailService');
        emailService.addEventListener('change', function() {
            const status = emailService.checked ? 'on' : 'off';
            const url = status == 'on' ? '/admin/emails/on' : '/admin/emails/off';
            window.location.href = url;
        });
    });
</script>
@endsection