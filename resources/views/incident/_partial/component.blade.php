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
            <tr>
                <td>{{ \App\Helper\SettingHelper::getLabelValue('component_type', $component->component_type) }}</td>
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
                        <a href="{{ route('assets.edit', $component->id) }}" class="btn btn-sm btn-warning">Replace</a>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>