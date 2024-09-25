@extends('layouts.main')

@section('content')
@php($isAdmin = Auth::user()->role == 'admin')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Assets List</h1>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                                        <li class="breadcrumb-item"><a href="/resources">Asset Manager</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Assets list</li>
                                    </ol>
                                </nav>
                        </div>
                        <div class="nk-block-head-content">
                            @if($isAdmin)
                            <ul class="d-flex">
                                <li>
                                    <a href="/resources/create" class="btn btn-md d-md-none btn-primary">
                                        <em class="icon ni ni-plus"></em>
                                        <span>Add</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/resources/create" class="btn btn-primary d-none d-md-inline-flex">
                                        <em class="icon ni ni-plus"></em>
                                        <span>Add Assets</span>
                                    </a>
                                </li>
                            </ul>
                            @endif
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card">
                        <table class="datatable-init table" data-nk-container="table-responsive">
                            <thead class="table-light">
                                <tr>
                                    <th class="tb-col">
                                        <span class="overline-title">#</span>
                                    </th>
                                    <th class="tb-col  tb-col-xxl">
                                        <span class="overline-title">Contract</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Brand</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Model</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">S/N</span>
                                    </th>
                                    <th class="tb-col">
                                        <span class="overline-title">Category</span>
                                    </th>
                                    @if($isAdmin)
                                    <th class="tb-col tb-col-end" data-sortable="false">
                                        <span class="overline-title">Action</span>
                                    </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assets as $key=>$asset)
                                    <tr>
                                        <td class="tb-col">{{$key + 1}}</td>
                                        <td class="tb-col  tb-col-xxl">
                                            <div class="media-group">
                                                <div class="media-text">
                                                    <a href="/resources/{{$asset->id}}/show" class="title">{{$asset->contract->contract_name}}</a>
                                                    <span class="small text">{{$asset->contract->contract_number}}</span>
                                                    {{-- @if($asset->qr_code_path) --}}
                                                    <a class="link-warning" role="button" onclick="getQRCodeNewWindow('{{$asset->asset_number}}', '{{$asset->asset_number}}')" class="small text">Download QR Code</a>
                                                    {{-- <a class="link-warning" href="{{$asset->qr_code_path}}" target="_blank" class="small text">Download QR Code</a> --}}
                                                    {{-- @endif                                                 --}}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="tb-col">{{$asset->brand}}</td>
                                        <td class="tb-col tb-col-xl">{{$asset->name}}</td>
                                        <td class="tb-col"><span class="badge text-bg-info-soft">{{$asset->serial_number}}</span></td>
                                        <td class="tb-col">
                                            {{-- if hardware badge dark soft --}}
                                            @if($asset->category == 'hardware')
                                                <span class="badge text-bg-primary-soft">Hardware</span>
                                            @elseif($asset->category == 'software')
                                                <span class="badge text-bg-secondary-soft">Software</span>
                                            @else
                                                <span class="badge text-bg-info-soft">Service</span>
                                            @endif
                                        </td>
                                        @if($isAdmin)
                                        <td class="tb-col tb-col-end">
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                    <em class="icon ni ni-more-v"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                    <div class="dropdown-content py-1">
                                                        <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                            <li>
                                                                <a href="/resources/{{$asset->id}}/edit"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="#" onclick="deleteCustomer({{$asset->id}})"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="/resources/{{$asset->id}}/show"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- dropdown -->
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                                @if(count($assets) == 0)
                                    <tr>
                                        <td colspan="7" class="text-center">No assets found. Please add asset in the create asset form.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="/assets/js/data-tables/data-tables.js"></script>
{{-- <script src="/assets/js/qr-code-styling.js"></script> --}}
<script type="text/javascript" src="https://unpkg.com/qr-code-styling@1.5.0/lib/qr-code-styling.js"></script>
<script>
    // function for a tag onclick event to delete customer
    function deleteCustomer(id) {
        event.preventDefault();
        if(confirm('Are you sure you want to delete this customer?')) {
            // create form and submit as destroy method
            let form = document.createElement('form');
            form.action = '/resources/'+id;
            form.method = 'POST';
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    function getQRCode(assetId) {
        let url = `/public/resources/${assetId}/show`;

        const imagePath = "/images/coredata-logo-only.png";
        const fullLogoUrl = new URL(imagePath, window.location.origin).href;

        const qrCode = new QRCodeStyling({
            "width": 500,
            "height": 500,
            "data": url,
            "margin": 10,
            "qrOptions": {
                "typeNumber": "0",
                "mode": "Byte",
                "errorCorrectionLevel": "Q"
            },
            "imageOptions": {
                "hideBackgroundDots": true,
                "imageSize": 0.4,
                "margin": 0
            },
            "dotsOptions": {
                "type": "extra-rounded",
                "color": "#ec5146",
                "gradient": null
            },
            "backgroundOptions": {
                "color": "#ffffff"
            },
            "image": fullLogoUrl,
            "dotsOptionsHelper": {
                "colorType": {
                    "single": true,
                    "gradient": false
                },
                "gradient": {
                    "linear": true,
                    "radial": false,
                    "color1": "#6a1a4c",
                    "color2": "#6a1a4c",
                    "rotation": "0"
                }
            },
            "cornersSquareOptions": {
                "type": "extra-rounded",
                "color": "#09617b"
            },
            "cornersSquareOptionsHelper": {
                "colorType": {
                    "single": true,
                    "gradient": false
                },
                "gradient": {
                    "linear": true,
                    "radial": false,
                    "color1": "#000000",
                    "color2": "#000000",
                    "rotation": "0"
                }
            },
            "cornersDotOptions": {
                "type": "",
                "color": "#09607b"
            },
            "cornersDotOptionsHelper": {
                "colorType": {
                    "single": true,
                    "gradient": false
                },
                "gradient": {
                    "linear": true,
                    "radial": false,
                    "color1": "#000000",
                    "color2": "#000000",
                    "rotation": "0"
                }
            },
            "backgroundOptionsHelper": {
                "colorType": {
                    "single": true,
                    "gradient": false
                },
                "gradient": {
                    "linear": true,
                    "radial": false,
                    "color1": "#ffffff",
                    "color2": "#ffffff",
                    "rotation": "0"
                }
            }
        });
        // construct filename with timestamp
        const filename = "assetqr-" + new Date().getTime();
        qrCode.append(document.getElementById("canvas"));
        qrCode.download({ name: filename, extension: "svg" });
    }

    function getQRCodeNewWindow(assetId, assetLabel)
    {
        let url = `/public/resources/${assetId}/show`;
        url = new URL(url, window.location.origin).href;

        const imagePath = "/images/coredata-logo-only.png";
        const fullLogoUrl = new URL(imagePath, window.location.origin).href;
        // Open a new window
        const newWindow = window.open("", "_blank", "width=600,height=600");

        // Create the QR code
        const qrCode = new QRCodeStyling({
            "width": 400,
            "height": 400,
            "data": url,
            "margin": 10,
            "qrOptions": {
                "typeNumber": "0",
                "mode": "Byte",
                "errorCorrectionLevel": "Q"
            },
            "imageOptions": {
                "hideBackgroundDots": true,
                "imageSize": 0.4,
                "margin": 0
            },
            "dotsOptions": {
                "type": "extra-rounded",
                "color": "#ec5146",
                "gradient": null
            },
            "backgroundOptions": {
                "color": "#ffffff"
            },
            "image": fullLogoUrl,
            "dotsOptionsHelper": {
                "colorType": {
                    "single": true,
                    "gradient": false
                },
                "gradient": {
                    "linear": true,
                    "radial": false,
                    "color1": "#6a1a4c",
                    "color2": "#6a1a4c",
                    "rotation": "0"
                }
            },
            "cornersSquareOptions": {
                "type": "extra-rounded",
                "color": "#09617b"
            },
            "cornersSquareOptionsHelper": {
                "colorType": {
                    "single": true,
                    "gradient": false
                },
                "gradient": {
                    "linear": true,
                    "radial": false,
                    "color1": "#000000",
                    "color2": "#000000",
                    "rotation": "0"
                }
            },
            "cornersDotOptions": {
                "type": "",
                "color": "#09607b"
            },
            "cornersDotOptionsHelper": {
                "colorType": {
                    "single": true,
                    "gradient": false
                },
                "gradient": {
                    "linear": true,
                    "radial": false,
                    "color1": "#000000",
                    "color2": "#000000",
                    "rotation": "0"
                }
            },
            "backgroundOptionsHelper": {
                "colorType": {
                    "single": true,
                    "gradient": false
                },
                "gradient": {
                    "linear": true,
                    "radial": false,
                    "color1": "#ffffff",
                    "color2": "#ffffff",
                    "rotation": "0"
                }
            }
        });

        // Create a container for the QR code
        const mainContainer = newWindow.document.createElement("div");
        mainContainer.style.display = "flex";
        mainContainer.style.justifyContent = "center";
        mainContainer.style.alignItems = "center";
        mainContainer.style.flexDirection = "column";
        mainContainer.style.border = "2px dashed #000";
        mainContainer.style.padding = "20px";
        mainContainer.style.width = "500px";
        mainContainer.style.height = "500px";

        const qrContainer = document.createElement("div");
        qrContainer.id = "qr-container";
        qrContainer.style.display = "flex";
        qrContainer.style.justifyContent = "center";
        qrContainer.style.alignItems = "center";

        mainContainer.appendChild(qrContainer);


        // Generate the QR code in the new window
        qrCode.append(qrContainer);

        // Optionally, add a label
        const qrLabel = newWindow.document.createElement("div");
        qrLabel.textContent = assetLabel;
        qrLabel.style.textAlign = "center";
        qrLabel.style.marginTop = "10px"; // Adjust spacing
        qrLabel.style.fontSize = "26px"; // Font size
        qrLabel.style.color = "#000"; // Text color
        qrLabel.style.fontWeight = "bold"; // Font weight

        // Append the label to the new window
        mainContainer.appendChild(qrLabel);
        
        newWindow.document.body.appendChild(mainContainer);
    }
</script>
@endsection