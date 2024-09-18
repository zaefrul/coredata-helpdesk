<table class="datatable-init table" data-nk-container="table-responsive">
    <thead class="table-light">
        <tr>
            <th class="tb-col">
                <span class="overline-title">Type</span>
            </th>
            <th class="tb-col">
                <span class="overline-title">Details</span>
            </th>
            <th class="tb-col">
                <span class="overline-title">Serial No.</span>
            </th>
            <th class="tb-col">
                <span class="overline-title">Part No.</span>
            </th>
            @if(Auth::user()->role != 'user')
                <th>
                    <span class="overline-title">Action</span>
                </th>
            @endif
        </tr>
    </thead>
    <tbody>
        @if(count($components) == 0)
            <tr>
                <td colspan="5" class="text-center">No component found</td>
            </tr>
        @endif
        @foreach($components as $component)
            @php
                $component_type = \App\Helper\SettingHelper::getLabelValue('component_type', $component->component_type);
            @endphp
            <tr>
                <td>{{ $component_type }}</td>
                <td>
                    <div class="media-group">
                        <div class="media-text">
                            <a href="{{ route('assets.show', $component->asset_id) }}" class="title">{{ $component->component_model }}</a>
                            <span class="small text">{{ $component->component_name }}</span>
                        </div>
                    </div>
                </td>
                <td>{{ $component->serial_number }}</td>
                <td>{{ $component->part_number }}</td>
                @if(Auth::user()->role != 'user')
                    <td>
                        <a href="{{ route('assets.edit', $component->id) }}" class="btn btn-sm btn-warning replaceBtn" 
                            data-bs-toggle="modal" data-bs-target="#exampleModal" 
                            data-part-type="{{ $component->component_type }}" 
                            data-part-model="{{ $component->component_model }}"
                            data-part-name="{{ $component->component_name }}"
                            data-part-serial="{{ $component->serial_number }}"
                            data-part-part="{{ $component->part_number }}"
                            data-part-id="{{ $component->id }}"
                        >Replace</a>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Part Replacement In</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row mt-3">
                <div class="col-lg-12">
                    <table class="datatable-init table" data-nk-container="table-responsive">
                        <thead class="table-light">
                            <tr>
                                <th class="tb-col">
                                    <span class="overline-title">Part No.</span>
                                </th>
                                <th class="tb-col">
                                    <span class="overline-title">Serial Number</span>
                                </th>
                                <th class="tb-col">
                                    <span class="overline-title">Description</span>
                                </th>
                                <th class="tb-col">
                                    <span class="overline-title">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="inventory-table-body">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-sm btn-primary">Save changes</button>
        </div>
    </div>
    </div>
</div>

@push('js-stack')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(e) {
                if(e.target.classList.contains('replaceBtn')) {
                    let partType = e.target.getAttribute('data-part-type');
                    let partModel = e.target.getAttribute('data-part-model');
                    let partName = e.target.getAttribute('data-part-name');
                    let partSerial = e.target.getAttribute('data-part-serial');
                    let partPart = e.target.getAttribute('data-part-part');
                    let partId = e.target.getAttribute('data-part-id');
                    let modal = document.getElementById('exampleModal');
                    let modalTitle = modal.querySelector('.modal-title');
                    let modalBody = modal.querySelector('.modal-body');

                    var partFullString = partType + ' - ' + partModel + ' ' + partName + ' ' + partSerial + ' ' + partPart;

                    // replace double space with single space
                    partFullString = partFullString.replace(/\s+/g, ' ');
                    modalTitle.innerHTML = 'Part Replacement In ' + partFullString;
                    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // fetch inventory data
                    fetch('{{route("inventories.search")}}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({
                            search: partType
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        let inventoryTableBody = modalBody.querySelector('#inventory-table-body');
                        inventoryTableBody.innerHTML = '';
                        data.forEach(inventory => {
                            const description = `
                                <div class="media-group">
                                    <div class="media-text">
                                        <div class="title">${inventory.model}</div>
                                        <span class="small text-muted">${inventory.item}</span>
                                    </div>
                                </div>
                            `;
                            let tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${inventory.part_number}</td>
                                <td>${inventory.serial_number}</td>
                                <td>${description}</td>
                                <td>
                                    <input type="hidden" name="part_id" value="${partId}" />
                                    <input type="hidden" name="inventory_id" value="${inventory.id}" />
                                    <button class="btn btn-sm btn-success select-replacement">Select</button>
                                </td>
                            `;
                            inventoryTableBody.appendChild(tr);
                        });
                    })
                }

                // for select inventory
                if(e.target.classList.contains('select-replacement')) {
                    if(confirm('Are you sure to replace this part?')) {
                        let inventoryId = e.target.parentElement.querySelector('input[name="inventory_id"]').value;
                        let componentId = document.querySelector('input[name="part_id"]').value;
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        fetch('{{route("incident.replace.part", $incident->id)}}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                            },
                            body: JSON.stringify({
                                inventoryId,
                                componentId,
                                incidentId: {{$incident->id}}
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: data.message,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK',
                                    preConfirm: () => {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: data.message,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Something went wrong. Please try again later.',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                });
                        });
                    }
                }


            });
        });
    </script>
@endpush