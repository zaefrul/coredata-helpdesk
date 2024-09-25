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
                                        <li class="breadcrumb-item">Generate Asset QR by Project</li>
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
{{-- <script src="/assets/js/qr-code-styling.js"></script> --}}
<script type="text/javascript" src="https://unpkg.com/qr-code-styling@1.5.0/lib/qr-code-styling.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const project = document.getElementById('project');
        const generate = document.getElementById('generate');
        generate.addEventListener('click', function(){
            const projectId = project.value;
            
            url = '/admin/assets/bycontract/' + projectId + '?field=asset_number';
            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                }
            })
            .then(response => response.json())
            .then(data => {
                createQRForEachAssetInTable(data);
            })
            .catch(error => console.error(error));
        });
    });

    function createQRForEachAssetInTable(assets) {
    const newWindow = window.open();
    const pageContainer = newWindow.document.createElement("div");
    pageContainer.style.display = "flex";
    pageContainer.style.flexWrap = "wrap"; // Allow wrapping for pagination
    pageContainer.style.justifyContent = "space-around"; // Center items
    pageContainer.style.width = "800px"; // Width for the printed page
    pageContainer.style.padding = "20px";
    
    if (assets.length > 0) {
        assets.forEach(asset => {
            const assetQR = getQRCodeObject(asset.asset_number);
            const assetQRWithLabel = getAssetQRWithLabel(assetQR, asset.asset_number, newWindow);
            pageContainer.appendChild(assetQRWithLabel);
        });

        newWindow.document.body.appendChild(pageContainer);
    } else {
        const noAsset = newWindow.document.createElement("div");
        noAsset.innerText = "No asset found";
        pageContainer.appendChild(noAsset);
        newWindow.document.body.appendChild(pageContainer);
    }
}

function getAssetQRWithLabel(qr, text, newWindow) {
    const mainContainer = getEachQRContainer(newWindow);

    const qrContainer = newWindow.document.createElement("div");
    qr.append(qrContainer);
    mainContainer.appendChild(qrContainer);

    const textContainer = newWindow.document.createElement("div");
    textContainer.innerText = text;
    textContainer.style.textAlign = "center"; // Center label
    textContainer.style.fontWeight = "bold"; // Bold label
    textContainer.style.fontSize = "20px"; // Adjust font size
    mainContainer.appendChild(textContainer);

    return mainContainer;
}

function getEachQRContainer(newWindow) {
    const mainContainer = newWindow.document.createElement("div");
    mainContainer.style.display = "flex";
    mainContainer.style.flexDirection = "column";
    mainContainer.style.alignItems = "center";
    mainContainer.style.border = "2px dashed #000";
    mainContainer.style.padding = "20px";
    mainContainer.style.width = "300px"; // Adjust for layout
    mainContainer.style.height = "auto"; // Let height be dynamic
    mainContainer.style.margin = "10px"; // Space between QR codes
    mainContainer.style.pageBreakInside = "avoid"; // Avoid breaking inside the container
    return mainContainer;
}

function getQRCodeObject(assetNumber) {
    let url = `/public/resources/${assetNumber}/show`;
    url = new URL(url, window.location.origin).href;

    const imagePath = "/images/coredata-logo-only.png";
    const fullLogoUrl = new URL(imagePath, window.location.origin).href;

    // Create the QR code
    const qrCode = new QRCodeStyling({
            "width": 300,
            "height": 300,
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

    return qrCode;
}

// Add a print button function if needed
function printQR() {
    window.print();
}

</script>
@endsection