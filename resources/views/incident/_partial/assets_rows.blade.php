@foreach($assets as $key => $asset)
<div class="accordion" id="accordionPanelsStayOpenExample_{{$key}}">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$asset->id}}" aria-expanded="true" aria-controls="collapse{{$asset->id}}">
            {{$asset->name}} - {{$asset->serial_number}}
            </button>
        </h2>
        <div id="collapse{{$asset->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$asset->id}}" data-bs-parent="#accordionPanelsStayOpenExample_{{$key}}">
            <div class="accordion-body">
                <div class="row g-gs mt-1">
                    <div class="col-lg-12">
                        <div class="small">Asset / Software Name</div>
                        <h5 class="small">{{$asset->name}}</h5>
                    </div><!-- .col -->
                    <div class="col-lg-6">
                        <div class="small">Serial Number</div>
                        <h5 class="small">{{$asset->serial_number}}</h5>
                    </div><!-- .col -->
                    <div class="col-lg-3">
                        <div class="small">Model</div>
                        <h5 class="small">{{$asset->brand ?? '-'}}</h5>
                    </div><!-- .col -->
                    <div class="col-lg-3">
                        <div class="small">Location</div>
                        <h5 class="small">{{$asset->location ?? '-'}}</h5>
                    </div><!-- .col -->
                    <div class="col-lg-3">
                        <div class="small">Category</div>
                        <h5 class="small">{{ucfirst($asset->category) ?? '-'}}</h5>
                    </div><!-- .col -->
                </div><!-- .row -->
                
                <div class="row mt-3">
                    <div class="col-lg-3">
                        <div class="small">Warranty Level</div>
                        <h5 class="small">{{ucfirst($asset->warranty_level) ?? '-'}}</h5>
                    </div><!-- .col -->
                    <div class="col-lg-3">
                        <div class="small">Warranty Start</div>
                        <h5 class="small">{{$asset->purchased_date ? $asset->purchased_date->format('d M Y') : '-'}}</h5>
                    </div><!-- .col -->
                    <div class="col-lg-3">
                        <div class="small">Warranty End</div>
                        <h5 class="small">{{$asset->warranty_end ? $asset->warranty_end->format('d M Y') : '-'}}</h5>
                    </div><!-- .col -->
                    <div class="col-lg-3">
                        <div class="small">Warranty Status</div>
                        <h5 class="small">
                            @if($asset->warranty_end && $asset->warranty_end->isPast())
                                <span class="badge text-bg-danger">Expired</span>
                            @else
                                <span class="badge text-bg-success">Active</span>
                            @endif
                        </h5>
                    </div><!-- .col -->
                </div>

                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="small">Description</div>
                        <h5 class="small">{{$asset->description ?? '-'}}</h5>
                    </div><!-- .col -->
                </div>

                <div class="row mt-3">
                    <div class="col-lg-12">
                        @include('incident._partial.component', ['components' => $asset->components])
                    </div><!-- .col -->
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach