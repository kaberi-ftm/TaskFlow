<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\ActivityLog;

class TaskObserver
{
    private function log(Task $task, string $action)
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            ActivityLog::create([
                'task_id' => $task->id,
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'action' => $action
            ]);
        }
    }

    public function created(Task $task): void
    {
        $this->log($task, 'created');
    }

    public function updated(Task $task): void
    {
        $this->log($task, 'updated');
    }

    public function deleted(Task $task): void
    {
        $this->log($task, 'deleted');
    }
}
