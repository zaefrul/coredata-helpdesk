<?php

namespace App\Helper;

use App\Models\Customer;
use App\Models\Incident;
use App\Models\IncidentConversation;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class IncidentLogic
{
    public static function createIncidentNumber(int $customer_id): string
    {
        // get the last incident number
        $lastIncident = Incident::where('customer_id', $customer_id)->orderBy('id', 'desc')->count();
        if ($lastIncident) {
            $newIncidentNumber = $lastIncident + 1;
        } else {
            $newIncidentNumber = 1;
        }

        // 3 digit number
        $newIncidentNumber = str_pad($newIncidentNumber, 3, '0', STR_PAD_LEFT);

        // get customer prefix select only prefix
        $customerPrefix = Customer::find($customer_id)->prefix;

        // replace all spaces with hyphen and remove leading and trailing hyphens
        $customerPrefix = trim(preg_replace('/\s+/', '-', $customerPrefix), '-');

        // create new incident number
        $newIncidentNumber = $customerPrefix . '-' . $newIncidentNumber;

        return $newIncidentNumber;
    }

    public static function createScheduleTaskNumber(int $customer_id): string
    {
        $incidentNumber = self::createIncidentNumber($customer_id);
        $incidentNumber = $incidentNumber . '-ST';
        return $incidentNumber;
    }

    public static function createPreventiveMaintenanceNumber(int $customer_id): string
    {
        $incidentNumber = self::createIncidentNumber($customer_id);
        $incidentNumber = $incidentNumber . '-PM';
        return $incidentNumber;
    }

    public static function attachmentUploadHandler($request, $incident)
    {
        $images = [];
        if ($request->hasFile('attachments')) {
            $uploadedFiles = $request->file('attachments');
            foreach ($uploadedFiles as $key => $file) {
                // Store the file in the 'incident_images' directory       
                $currFileExtension = $file->getClientOriginalExtension();
                $type = $file->getClientMimeType();
                $size = $file->getSize();
                $name = $file->getClientOriginalName();

                // rename file to incident number + datetime
                $newFileName = $incident->incident_number . '_' . date('YmdHis') . '_' . $key . '.' . $currFileExtension;

                // Store the file in the storage directory
                $file->move(public_path('uploads'), $newFileName);
                $path = 'uploads/' . $newFileName;

                // Create a new attachment record in the database
                $incident->attachments()->create([
                    'file_name' => $name,
                    'file_path' => $path,
                    'file_type' => $type,
                    'file_size' => $size,
                    'file_extension' => $currFileExtension,
                    'incident_id' => $incident->id,
                ]);

                $images[$key] = $path;
            }
        }

        return $images;
    }

    public static function processActivityLogsDescription($activityLogs, $skipComment = false)
    {
        if(!isset($activityLogs)) return;
        $activityLogs->map(function($activity) use ($skipComment) {
            if($activity->description == 'Comment added' && !$skipComment) {
                $activity->user = $activity->user;
                $activity->comment = IncidentConversation::where('id', $activity->comment_id)->first()->message;
            } else if (str_contains($activity->description, 'Changed current_assignee_id')) {
                $activity->user = $activity->user;
                //remove single quote from string
                $activity->description = str_replace("'", "", $activity->description);

                $from = User::where('id', explode(' ', $activity->description)[3])->first();
                $to = User::where('id', explode(' ', $activity->description)[5])->first();

                //construct description with user link to route users.show
                if($from && $to)
                    $activity->description = 'Incident assigned from <a href="'. route('users.show', $from->id) .'">' . $from->name . '</a> to <a href="'. route('users.show', $to->id) .'">' . $to->name . '</a>';
                else
                    $activity->description = 'Incident assigned changed.';
                // $activity->description = 'Incident assigned from <a href="'. route('users.show', $from->id) .'">' . $from->name . '</a> to ' . $to;
            } 
            // if description contains word 'Component Replaced:, get the id 'number' and translate it to component name
            else if (str_contains($activity->description, 'Component Replaced:')) {
            
                $componentId = explode(' ', $activity->description);
                // remove '' from the string
                $componentId[2] = str_replace("'", "", $componentId[2]);
                $componentId[6] = str_replace("'", "", $componentId[6]);
                $oldItem = $componentId[2];
                $newItem = $componentId[6];
                $oldIv = Inventory::withoutGlobalScope('withoutReplacement')->find($oldItem);
                $newIv = Inventory::withoutGlobalScope('withoutReplacement')->find($newItem) ?? Inventory::withTrashed()->find($newItem);
                $activity->description = 'Component Replaced: ' . SettingHelper::getLabelValue('component_type', $oldIv->type) . ' ' . $oldIv->model . ' ['. $oldIv->part_number .'] to ' . $newIv->model . ' ['. $newIv->part_number .']';

            } else if(str_contains($activity->description, 'Attachments :')) {
                $imgPathArrayString = explode(' ', $activity->description)[2];
                $imgArray = json_decode($imgPathArrayString);

                $activity->description = 'Attachments : ' . print_r($imgArray, true);

                $html = '<div class="fst-italic mb-2 mt-2">Attachment uploaded to the ticket.</div>';
                $html .= '<div id="uploadedimg" class="carousel carousel-dark slide mb-2 mt-2" data-bs-ride="carousel">';
                $html .= '<div class="carousel-inner">';
                foreach ($imgArray as $key => $img) {
                    $html .= '<div class="carousel-item ' . ($key == 0 ? 'active' : '') . '">';
                    $html .= '<img src="' . $img . '" class="d-block w-100" alt="...">';
                    $html .= '</div>';
                }
                $html .= '</div>';
                $html .= '<button class="carousel-control-prev" type="button" data-bs-target="#uploadedimg" data-bs-slide="prev">';
                $html .= '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                $html .= '<span class="visually-hidden">Previous</span>';
                $html .= '</button>';
                $html .= '<button class="carousel-control-next" type="button" data-bs-target="#uploadedimg" data-bs-slide="next">';
                $html .= '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                $html .= '<span class="visually-hidden">Next</span>';
                $html .= '</button>';
                $html .= '</div>';

                if($activity->comment_id) {
                    $activity->comment = IncidentConversation::where('id', $activity->comment_id)->first()->message;
                    $activity->description = $html . '<div class="fst-italic mb-2 mt-2">Comment added: ' . $activity->comment . '</div>';
                }

                $activity->description = $html;
            }

            $activity->description = str_replace(
                ["'open'", "'in_progress'", "'resolved'", "'closed'"],
                [
                    '<span class="badge text-bg-info fs-6">Open</span>',
                    '<span class="badge text-bg-info fs-6">In Progress</span>',
                    '<span class="badge text-bg-success fs-6">Resolved</span>',
                    '<span class="badge text-bg-warning fs-6">Closed</span>'
                ],
                $activity->description
            );

            $activity->description = str_replace(
                ["'unasigned'", "'low'", "'medium'", "'high'", "'critical'"],
                [
                    '<span class="badge text-bg-light fs-6">Unassigned <em class="icon ni ni-cross"></em></span>',
                    '<span class="badge text-bg-info fs-6">Low <em class="icon ni ni-chevrons-down"></em></span>',
                    '<span class="badge text-bg-warning fs-6">Medium <em class="icon ni ni-chevron-down"></em></span>',
                    '<span class="badge text-bg-danger-soft fs-6">High <em class="icon ni ni-chevron-up"></em></span>',
                    '<span class="badge text-bg-danger fs-6">Critical <em class="icon ni ni-chevrons-up"></em></span>'
                ],
                $activity->description
            );

            // translate componentId to component name
        });

        return $activityLogs;
    }
}
