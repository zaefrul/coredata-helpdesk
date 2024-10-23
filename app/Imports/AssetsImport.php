<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssetsImport implements ToModel, WithHeadingRow
{
    protected $customerId;
    protected $departmentId;

    public function __construct($customerId, $departmentId)
    {
        $this->customerId = $customerId;
        $this->departmentId = $departmentId;
    }

    /**
     * Map the rows to the Asset model.
     *
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // if key is not found, return null
        if (!array_key_exists('contract', $row)) {
            return null;
        }
        
        $contract = Contract::where('contract_number', $row['contract'])->first();
        if(!$contract) {
            // You can log the error or handle it in any other way
            // For example, you can use Laravel's Log facade to log the error
            // Log::error('Contract not found for contract number: ' . $row['contract']);
            Log::error('ASSET_IMPORT_SEEDER: Contract not found for contract number: ' . $row['contract']);
            return null;
        }

        // Assuming you have a model `Asset` with the respective fields
        return new Asset([
            'name' => $row['model_name'],
            'brand' => $row['brand_name'],
            'serial_number' => $row['serial_number'],
            'category' => $row['category'],
            'details' => $row['asset_description'],
            'warranty_level' => $row['warranty_level'],
            'contract_id' => $contract ? $contract->id : null,  // Ensure this matches your DB schema
            'purchased_date' => $contract ? $contract->start_date : null,  // Based on the "Same as Contract Period"
            'warranty_end' => $contract ? $contract->end_date : null,  // Based on the "Same as Contract Period"
            'location' => $row['location'],
        ]);
    }
}
