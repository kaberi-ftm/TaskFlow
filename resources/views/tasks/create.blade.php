@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Create Task</h2>
            <p class="text-slate-500 mt-1">Add a new task to your academic planner.</p>
        </div>
        <a href="{{ route('tasks.index') }}" class="text-slate-500 hover:text-indigo-600 font-medium transition-colors flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Tasks
        </a>
    </div>

    
    <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <form method="POST" action="{{ route('tasks.store') }}" class="p-8">
            @csrf

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">Title <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all duration-200 bg-slate-50 hover:bg-white focus:bg-white text-slate-900 shadow-sm" placeholder="E.g., Complete Math Assignment">
                    @error('title')<p class="text-rose-500 text-xs font-medium mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all duration-200 bg-slate-50 hover:bg-white focus:bg-white text-slate-900 shadow-sm" placeholder="Add any extra details or instructions here...">{{ old('description') }}</textarea>
                    @error('description')<p class="text-rose-500 text-xs font-medium mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-semibold text-slate-700 mb-2">Subject</label>
                        <select name="subject" id="subject" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all duration-200 bg-slate-50 hover:bg-white focus:bg-white text-slate-900 shadow-sm appearance-none">
                            <option value="">Select a subject...</option>
                            @foreach(['Math', 'Science', 'History', 'Literature', 'Computer Science', 'Art', 'Other'] as $subject)
                                <option value="{{ $subject }}" {{ old('subject') == $subject ? 'selected' : '' }}>{{ $subject }}</option>
                            @endforeach
                        </select>
                        @error('subject')<p class="text-rose-500 text-xs font-medium mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Priority -->
                    <div>
                        <label for="priority" class="block text-sm font-semibold text-slate-700 mb-2">Priority</label>
                        <select name="priority" id="priority" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all duration-200 bg-slate-50 hover:bg-white focus:bg-white text-slate-900 shadow-sm appearance-none">
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')<p class="text-rose-500 text-xs font-medium mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Due Date -->
                <div>
                    <label for="due_date" class="block text-sm font-semibold text-slate-700 mb-2">Due Date</label>
                    <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all duration-200 bg-slate-50 hover:bg-white focus:bg-white text-slate-900 shadow-sm">
                    @error('due_date')<p class="text-rose-500 text-xs font-medium mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end space-x-3">
                <a href="{{ route('tasks.index') }}" class="px-6 py-3 rounded-xl font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all duration-200 hover:-translate-y-0.5">
                    Save Task
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
