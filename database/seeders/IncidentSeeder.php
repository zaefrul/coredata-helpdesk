<?php

namespace Database\Seeders;

use App\Helper\IncidentLogic;
use Illuminate\Database\Seeder;
use App\Models\Incident;
use App\Models\Asset;
use App\Models\User;
use App\Models\Customer;
use App\Models\Contract;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class IncidentSeeder extends Seeder
{
    public function run()
    {
        $incidents = [
            [
                'title' => 'Server Disk Space Low',
                'description' => 'Disk space is running low on the primary database server, causing performance issues.',
                'created_date' => '2024-02-14',
                'priority' => 'high',
                'status' => 'open'
            ],
            [
                'title' => 'Network Latency in Data Center',
                'description' => 'High latency detected in the data center network, affecting application performance.',
                'created_date' => '2024-05-03',
                'priority' => 'medium',
                'status' => 'in_progress'
            ],
            [
                'title' => 'Server Memory Usage Spikes',
                'description' => 'Random memory usage spikes on app servers, causing intermittent crashes.',
                'created_date' => '2024-03-21',
                'priority' => 'high',
                'status' => 'open'
            ],
            [
                'title' => 'Data Center Cooling System Malfunction',
                'description' => 'Cooling system in data center is malfunctioning, causing overheating risks for servers.',
                'created_date' => '2024-04-18',
                'priority' => 'low',
                'status' => 'open'
            ],
            [
                'title' => 'Failed Backup on Database Server',
                'description' => 'Backup process failed on database server, data loss risks identified.',
                'created_date' => '2024-01-27',
                'priority' => 'critical',
                'status' => 'closed'
            ],
            [
                'title' => 'CPU Usage High on Load Balancer',
                'description' => 'Load balancer CPU usage has been above 90% for over an hour, potential failure risk.',
                'created_date' => '2024-06-05',
                'priority' => 'high',
                'status' => 'open'
            ],
            [
                'title' => 'Unauthorized Access Attempt on Server',
                'description' => 'Multiple unauthorized login attempts detected on server 12.',
                'created_date' => '2024-07-10',
                'priority' => 'medium',
                'status' => 'resolved'
            ],
            [
                'title' => 'Server Not Responding',
                'description' => 'Application server 8 is not responding to ping requests, suspected hardware failure.',
                'created_date' => '2024-02-23',
                'priority' => 'high',
                'status' => 'in_progress'
            ],
            [
                'title' => 'Storage Failure in SAN',
                'description' => 'A storage drive in the SAN has failed, causing potential data accessibility issues.',
                'created_date' => '2024-03-15',
                'priority' => 'critical',
                'status' => 'open'
            ],
            [
                'title' => 'Internet Link Down in Data Center',
                'description' => 'The primary internet link is down in the data center, causing connectivity issues for multiple services.',
                'created_date' => '2024-06-12',
                'priority' => 'critical',
                'status' => 'open'
            ],
            [
                'title' => 'Patch Installation Failed on Web Server',
                'description' => 'Security patch failed to install on web server 5, leaving it vulnerable to threats.',
                'created_date' => '2024-01-18',
                'priority' => 'medium',
                'status' => 'resolved'
            ],
            [
                'title' => 'Database Connection Timeout',
                'description' => 'Database connection timeout issues are affecting user transactions.',
                'created_date' => '2024-03-01',
                'priority' => 'medium',
                'status' => 'open'
            ],
            [
                'title' => 'Security Vulnerability Detected',
                'description' => 'A critical security vulnerability was detected in web server software.',
                'created_date' => '2024-06-25',
                'priority' => 'critical',
                'status' => 'closed'
            ],
            [
                'title' => 'Unexpected Server Shutdown',
                'description' => 'Server 3 experienced an unexpected shutdown, leading to service outages.',
                'created_date' => '2024-02-07',
                'priority' => 'high',
                'status' => 'in_progress'
            ],
            [
                'title' => 'File System Corruption',
                'description' => 'File system corruption detected on app server 7, impacting service.',
                'created_date' => '2024-07-15',
                'priority' => 'critical',
                'status' => 'open'
            ],
            [
                'title' => 'Network Switch Overheating',
                'description' => 'Network switch overheating, risk of network failure in zone 2.',
                'created_date' => '2024-08-10',
                'priority' => 'high',
                'status' => 'open'
            ],
            [
                'title' => 'Power Outage in Data Center',
                'description' => 'Partial power outage in data center affecting racks 4-8.',
                'created_date' => '2024-03-20',
                'priority' => 'critical',
                'status' => 'resolved'
            ],
            [
                'title' => 'Slow Application Performance',
                'description' => 'Users are experiencing slow performance across several application instances.',
                'created_date' => '2024-04-29',
                'priority' => 'medium',
                'status' => 'open'
            ],
            [
                'title' => 'Corrupted Database Table',
                'description' => 'A database table has become corrupted, causing data inconsistencies.',
                'created_date' => '2024-05-18',
                'priority' => 'high',
                'status' => 'in_progress'
            ],
            [
                'title' => 'Load Balancer Failover Not Working',
                'description' => 'Load balancer failover did not trigger during a server outage, causing downtime.',
                'created_date' => '2024-06-19',
                'priority' => 'high',
                'status' => 'resolved'
            ],
            [
                'title' => 'Firmware Update Failed on Router',
                'description' => 'Firmware update failed on data center router, causing network instability.',
                'created_date' => '2024-05-07',
                'priority' => 'medium',
                'status' => 'closed'
            ],
            [
                'title' => 'Duplicate IP Address Conflict',
                'description' => 'IP address conflict detected in the server rack, causing network outages.',
                'created_date' => '2024-07-22',
                'priority' => 'high',
                'status' => 'open'
            ],
            [
                'title' => 'SSL Certificate Expiry',
                'description' => 'SSL certificate on web server 1 has expired, causing security warnings for users.',
                'created_date' => '2024-02-25',
                'priority' => 'high',
                'status' => 'in_progress'
            ],
            [
                'title' => 'Backup Server Unreachable',
                'description' => 'The backup server is not reachable from the main data center, backup operations halted.',
                'created_date' => '2024-06-15',
                'priority' => 'critical',
                'status' => 'open'
            ],
            [
                'title' => 'High Packet Loss Detected',
                'description' => 'High packet loss detected in the data center network, causing service degradation.',
                'created_date' => '2024-03-29',
                'priority' => 'medium',
                'status' => 'closed'
            ],
            [
                'title' => 'Virtual Machine Crashed',
                'description' => 'Virtual machine hosting critical applications has crashed and is not rebooting.',
                'created_date' => '2024-01-16',
                'priority' => 'high',
                'status' => 'open'
            ],
            [
                'title' => 'Database Query Performance Degraded',
                'description' => 'Database queries taking longer than expected, degrading user experience.',
                'created_date' => '2024-07-19',
                'priority' => 'medium',
                'status' => 'open'
            ],
            [
                'title' => 'Firewall Misconfiguration',
                'description' => 'Misconfigured firewall rules blocking critical network traffic.',
                'created_date' => '2024-03-12',
                'priority' => 'critical',
                'status' => 'open'
            ],
            [
                'title' => 'Hardware Failure in Rack 5',
                'description' => 'Multiple hardware failures detected in rack 5, affecting services.',
                'created_date' => '2024-08-19',
                'priority' => 'high',
                'status' => 'open'
            ],
            [
                'title' => 'Email Server Not Delivering Messages',
                'description' => 'Email server is not delivering messages, affecting communication channels.',
                'created_date' => '2024-04-22',
                'priority' => 'critical',
                'status' => 'resolved'
            ],
            [
                'title' => 'Server Backup Taking Longer Than Expected',
                'description' => 'Daily server backup taking unusually long, impacting performance.',
                'created_date' => '2024-05-28',
                'priority' => 'medium',
                'status' => 'in_progress'
            ],
            [
                'title' => 'Security Breach Attempt',
                'description' => 'An attempted security breach was detected and blocked by the firewall.',
                'created_date' => '2024-02-11',
                'priority' => 'high',
                'status' => 'closed'
            ]
        ];

        // get all available asset ids
        $assetIds = Asset::all()->pluck('id')->toArray();
        foreach ($incidents as $incidentData) {
            $asset_id = $assetIds[array_rand($assetIds)];

            $asset = Asset::find($asset_id);

            // get contract
            $contract = Contract::find($asset->contract_id);

            // get customer id
            $customer_id = $contract->customer_id;

            //get department
            $department = Department::find($contract->department_id);

            $user_id = User::where('email', $department->pc_email)->first()->id;
            $contract_id = $contract->id;
            $current_assignee_id = User::whereIn('role', ['admin', 'agent'])->inRandomOrder()->first()->id;

            $incident_number = IncidentLogic::createIncidentNumber($customer_id);

            // random site location
            $site_location = ['Data Center', 'Office', 'Remote Site', 'Cloud Server', 'Hosting Provider', 'Customer Site', 'Warehouse', 'Lab', 'Production Floor', 'Server Room'];

            // Create the incident with the related foreign keys
            Incident::create([
                'incident_number' => $incident_number,
                'asset_id' => $asset_id,
                'user_id' => $user_id,
                'customer_id' => $customer_id,
                'title' => $incidentData['title'],
                'description' => $incidentData['description'],
                'priority' => $incidentData['priority'],
                'status' => $incidentData['status'],
                'site_location' => $site_location[array_rand($site_location)],
                'created_at' => Carbon::createFromFormat('Y-m-d', $incidentData['created_date']),
                'updated_at' => Carbon::createFromFormat('Y-m-d', $incidentData['created_date']),
                'contract_id' => $contract_id,
                'current_assignee_id' => $current_assignee_id,
            ]);
        }
    }
}
