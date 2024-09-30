@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Change Login Wallpaper</h1>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item"><a href="/admin">Admin Control Panel</a></li>
                                    <li class="breadcrumb-item">Wallpaper Setting</li>
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
                                </div>
                            </div>
                            {{-- @php $selected = $settings->where('key', 'login_wallpaper')->first()->value; @endphp --}}
                            <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                @foreach($wallpapers as $wallpaper)
                                    <div class="row mt-3">
                                        <div class="col-xs-12 col-md-4">
                                            {{-- checkbox then image as label --}}
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="wallpaper{{ $wallpaper }}" name="wallpaper" value="{{ $wallpaper }}" {{ $wallpaper == $selected ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="wallpaper{{ $wallpaper }}">
                                                    <img src="{{ asset('assets/images/mask/'.$wallpaper) }}" alt="wallpaper" class="img-thumbnail">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="row mt-3">
                                    <div class="col-xs-12">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection