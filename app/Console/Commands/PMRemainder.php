<?php

namespace App\Console\Commands;

use App\Mail\PMReminderEmail;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class PMReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'incident:pm-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind agents of PM tasks that are due in 30, 15, and 7 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Scheduled task: ' . $this->signature . ' started at ' . now());

        $adminFallbackUser = User::where('email', 'admin@coredata.com.my')->first();
        // Days to remind before the task due
        $daysToRemind = [30, 15, 7];

        // Loop through the reminder days and process tasks
        foreach ($daysToRemind as $days) {
            $this->info("Checking tasks due in $days days...");

            // Get all PM tasks that are due in $days
            $tasks = Incident::where('incident_number', 'like', "%-PM")
                ->whereDate('start_date', '=', now()->addDays($days))
                ->get();

            if ($tasks->isEmpty()) {
                $this->info("No tasks found for $days days.");
                continue;
            }

            foreach ($tasks as $task) {
                $agent = $task->currentAssignee;

                if (!$agent) {
                    $this->info('No agent assigned to task ' . $task->incident_number);
                    $agent = $adminFallbackUser;
                }

                // Send the email reminder to the agent
                Mail::to($agent->email)->send(new PMReminderEmail($task, $agent));
                $this->info("Sent reminder to agent {$agent->email} for task {$task->incident_number}");
            }
        }

        $this->info('Scheduled task: ' . $this->signature . ' ended at ' . now());
    }
}
