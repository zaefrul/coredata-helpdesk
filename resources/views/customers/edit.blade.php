@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Edit Customer Details</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customer Manage</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Edit Customer - {{$customer->prefix}}</li>
                                    </ol>
                                </nav>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-body">
                            <form method="POST" action="{{ route('customers.update', $customer->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row g-3 gx-gs">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company" class="form-label">Company name</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-building"></em></div>
                                                <input type="text" class="form-control " id="company" name="company" required value="{{$customer->company_name}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_person" class="form-label">Contact person name</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-user"></em></div>
                                                <input type="text" class="form-control" id="contact_person" name="contact_person" required value="{{$customer->contact_person}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_number" class="form-label">Phone number</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-call"></em></div>
                                                <input type="text" class="form-control" id="phone_number" name="phone_number" required value="{{$customer->phone_number}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email address</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-at"></em></div>
                                                <input type="email" class="form-control" id="email" name="email" required value="{{$customer->email}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="prefix" class="form-label">Company prefix (short name)</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-building"></em></div>
                                                <input type="text" class="form-control" id="prefix" required name="prefix" placeholder="SUHAKAM, MOT, MBSJ, PTD.." value="{{$customer->prefix}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="users_notification" class="form-label">Email Address (for notifications)</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="js-tags" id="users_notification" name="users_notification" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 g-3 gx-gs">
                                    {{-- submit btn --}}
                                    <div class="col-12">
                                        <div class="form-group mt-2">
                                            <button type="submit" class="btn btn-primary">Edit Customer</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    //all input fields with class 'form-control' will be affected. each key/change will convert to uppercase
    //this is to ensure that all data entered are in uppercase pure javascript
    // all input type exept for password and email
    document.querySelectorAll('.form-control').forEach(function (input) {
        console.log(input)
        if(input.type === 'password' || input.type === 'email') return;
        input.addEventListener('keyup', function (e) {
            this.value = this.value.toUpperCase();
        });
        //change
        input.addEventListener('change', function (e) {
            this.value = this.value.toUpperCase();
        });
    });
</script>
@endsection