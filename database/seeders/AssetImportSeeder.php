<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AssetsImport;

class AssetImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customerId = 1; // Define the customer_id
        $departmentId = 2; // Define the department_id

        // Replace the path with your actual path to the Excel file
        $filePath = storage_path('app/public/BULK_INSERT_UPSI_hardware.xlsx');

        // Use the AssetsImport class to read the file and import the data
        Excel::import(new AssetsImport($customerId, $departmentId), $filePath);

        $this->command->info('Asset data imported successfully.');
    }
}
