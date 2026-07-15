@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">My Tasks</h2>
        <p class="text-slate-500 mt-1">Manage and organize your academic tasks.</p>
    </div>
    <a href="{{ route('tasks.create') }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-5 rounded-full shadow-md shadow-indigo-200 transition-all duration-200 hover:-translate-y-0.5">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Create Task
    </a>
</div>

<div class="bg-white p-6 rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 mb-8">
    <form method="GET" action="{{ route('tasks.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
        <div class="w-full md:w-1/3">
            <label for="search" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search tasks..." class="pl-10 w-full rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm py-2 px-3 text-slate-700 outline-none transition-shadow bg-slate-50 hover:bg-white focus:bg-white border">
            </div>
        </div>
        
        <div class="w-full md:w-1/6">
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Status</label>
            <select name="status" class="w-full rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm py-2.5 px-3 text-slate-700 outline-none transition-shadow bg-slate-50 hover:bg-white focus:bg-white border">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        
        <div class="w-full md:w-1/6">
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Priority</label>
            <select name="priority" class="w-full rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm py-2.5 px-3 text-slate-700 outline-none transition-shadow bg-slate-50 hover:bg-white focus:bg-white border">
                <option value="">All Priorities</option>
                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
            </select>
        </div>
        
        <div class="w-full md:w-1/6">
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Subject</label>
            <select name="subject" class="w-full rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm py-2.5 px-3 text-slate-700 outline-none transition-shadow bg-slate-50 hover:bg-white focus:bg-white border">
                <option value="">All Subjects</option>
                @foreach(['Math', 'Science', 'History', 'Literature', 'Computer Science', 'Art', 'Other'] as $subject)
                    <option value="{{ $subject }}" {{ request('subject') == $subject ? 'selected' : '' }}>{{ $subject }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="w-full md:w-auto flex space-x-3">
            <button type="submit" class="w-full md:w-auto bg-slate-800 hover:bg-slate-900 text-white font-medium py-2.5 px-6 rounded-xl shadow-sm transition-colors">
                Filter
            </button>
            <a href="{{ route('tasks.index') }}" class="w-full md:w-auto bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium py-2.5 px-6 rounded-xl shadow-sm transition-colors text-center">
                Clear
            </a>
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50/50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-16">Status</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Task</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Subject</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Priority</th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($tasks as $task)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-5 whitespace-nowrap text-center align-middle">
                        <form method="POST" action="{{ route('tasks.toggle', $task) }}" class="inline-flex">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-8 h-8 rounded-full border-2 flex items-center justify-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $task->status === 'completed' ? 'border-emerald-500 bg-emerald-50 text-emerald-500 focus:ring-emerald-500' : 'border-slate-300 text-transparent hover:border-indigo-400 focus:ring-indigo-500' }}" title="Toggle Status">
                                <svg class="w-5 h-5 {{ $task->status === 'completed' ? 'opacity-100' : 'opacity-0 group-hover:opacity-30 text-indigo-400' }} transition-opacity" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex flex-col">
                            <span class="text-base font-bold text-slate-900 {{ $task->status === 'completed' ? 'line-through text-slate-400' : '' }}">
                                {{ $task->title }}
                            </span>
                            @if($task->due_date)
                            <div class="flex items-center mt-1 text-xs font-medium {{ \Carbon\Carbon::parse($task->due_date)->isPast() && $task->status !== 'completed' ? 'text-rose-500' : 'text-slate-500' }}">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                            </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap text-sm text-slate-600 font-medium">
                        {{ $task->subject ?? '—' }}
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap">
                        @if($task->priority === 'high')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-rose-100 text-rose-700">High</span>
                        @elseif($task->priority === 'medium')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-amber-100 text-amber-700">Medium</span>
                        @elseif($task->priority === 'low')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-emerald-100 text-emerald-700">Low</span>
                        @else
                            <span class="text-slate-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('tasks.edit', $task) }}" class="p-2 text-indigo-500 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4 text-slate-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-1">No tasks found</h3>
                            <p class="text-slate-500 text-sm max-w-sm mb-4">You haven't created any tasks yet, or none match your current filters.</p>
                            <a href="{{ route('tasks.create') }}" class="text-indigo-600 font-medium hover:text-indigo-800 transition-colors">Create your first task &rarr;</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
