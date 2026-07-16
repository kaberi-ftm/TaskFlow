<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskDueReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendTaskReminders extends Command
{
    protected $signature = 'send:task-reminders';
    protected $description = 'Send notifications for tasks due within 24 hours';

    public function handle()
    {
        $tasks = Task::where('status', 'pending')
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [Carbon::today(), Carbon::tomorrow()])
            ->get();

        foreach ($tasks as $task) {
            $task->user->notify(new TaskDueReminder($task));
        }

        $this->info("Sent reminders for {$tasks->count()} tasks.");
    }
}
