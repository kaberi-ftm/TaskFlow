<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    private array $allowedSubjects = ['Math', 'Science', 'History', 'Literature', 'Computer Science', 'Art', 'Other'];

    public function index(Request $request)
    {
        $tasks = Auth::user()->tasks()
            ->search($request->input('search'))
            ->status($request->input('status'))
            ->priority($request->input('priority'))
            ->subject($request->input('subject'))
            ->latest()
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $subjects = $this->allowedSubjects;
        return view('tasks.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date|after_or_equal:today',
            'subject' => 'nullable|string|in:' . implode(',', $this->allowedSubjects),
            'priority' => 'nullable|in:high,medium,low',
        ]);

        Auth::user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        abort_if($task->user_id !== Auth::id(), 403);
        $subjects = $this->allowedSubjects;
        return view('tasks.edit', compact('task', 'subjects'));
    }

    public function update(Request $request, Task $task)
    {
        abort_if($task->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date|after_or_equal:today',
            'subject' => 'nullable|string|in:' . implode(',', $this->allowedSubjects),
            'priority' => 'nullable|in:high,medium,low',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        abort_if($task->user_id !== Auth::id(), 403);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function toggle(Task $task)
    {
        abort_if($task->user_id !== Auth::id(), 403);
        $task->update(['status' => $task->status === 'completed' ? 'pending' : 'completed']);
        return back()->with('success', 'Task status updated.');
    }
}
