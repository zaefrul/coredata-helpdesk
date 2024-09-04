@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Crete New Account</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                                        <li class="breadcrumb-item"><a href="/project">Account Manager</a></li>
                                        <li class="breadcrumb-item">Create Account</li>
                                    </ol>
                                </nav>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-body">
                            <form method="POST" action="{{route('users.store')}}">
                                @csrf
                                <div class="row g-3 gx-gs">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Customer</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select" id="customer_id" name="customer_id" required>
                                                    <option>Select Customer</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->company_name }} [{{$customer->prefix}}]</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Name</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-user"></em></div>
                                                <input type="text" class="form-control " id="name" name="name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-mail"></em></div>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password" class="form-label">Phone No.</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-call"></em></div>
                                                <input type="text" class="form-control" id="phone" name="phone" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-lock-alt"></em></div>
                                                <input type="password" class="form-control" id="password" name="password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-lock-alt"></em></div>
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mt-3">  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="role" class="form-label">Role</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-icon start"><em class="icon ni ni-user-circle"></em></div>
                                                <select class="js-select" id="role" name="role" required>
                                                    <option value="admin">Admin</option>
                                                    <option value="agent">Agent</option>
                                                    <option value="user">User</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 gx-gs mt-3">  
                                    <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">Create Account</button>
                                                <a href="/users" class="btn btn-outline-secondary">Cancel</a>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Select2
        document.querySelectorAll('.form-control').forEach(function(el) {
            // convert to to uppercase
            el.addEventListener('keyup', function(e) {
                // email or password will not be converted to uppercase
                if(this.type === 'password' || this.type === 'email') return;
                this.value = this.value.toUpperCase();
            });
            el.addEventListener('change', function(e) {
                if(this.type === 'password' || this.type === 'email') return;
                this.value = this.value.toUpperCase();
            });
        });
    });
</script>
@endsection
                        