<?php

namespace Database\Seeders;

use App\Models\Incident;
use Illuminate\Database\Seeder;

class IncidentNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Incident::withoutEvents(function () {
            $incidents = Incident::all();

            foreach ($incidents as $incident) {
                $ticket_number = $incident->incident_number;
                $ticketsplit = explode("-", $ticket_number);
                $ticket_number = $ticketsplit[0] . "-" . str_pad($ticketsplit[1], 3, "0", STR_PAD_LEFT);
                if(isset($ticketsplit[2])) {
                    $ticket_number = $ticket_number . "-" . $ticketsplit[2];
                }
                $incident->incident_number = $ticket_number;
                $incident->save();
            }
        });
    }
}