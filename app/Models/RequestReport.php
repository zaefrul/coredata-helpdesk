<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'status',
        'report_type',
        'request_by',
        'report_file',
    ];


    // Report Type Constants
    public const CASE_BY_CONTRACT = 'case_by_contract';
    public const LABEL = [
        self::CASE_BY_CONTRACT => 'Case by Contract',
    ];

    // Report Status Constants
    public const STATUS_PENDING = 'pending';
    public const STATUS_EXTRACTING = 'extracting';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_EMAILED = 'emailed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_LABEL = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_EXTRACTING => 'Extracting',
        self::STATUS_COMPLETED => 'Completed',
        self::STATUS_EMAILED => 'Emailed',
        self::STATUS_FAILED => 'Failed',
    ];
}
