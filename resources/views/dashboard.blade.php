@extends('layouts.app')

@section('content')

@if($notifications->count() > 0)
<div class="mb-8 space-y-3">
    @foreach($notifications as $notification)
        <div class="bg-amber-50 border border-amber-200 text-amber-800 px-5 py-4 rounded-xl shadow-sm flex justify-between items-start" role="alert">
            <div class="flex items-start">
                <svg class="w-6 h-6 mr-3 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div>
                    <h4 class="font-bold text-sm uppercase tracking-wider text-amber-700">Reminder</h4>
                    <p class="mt-1 text-sm">{{ $notification->data['message'] ?? 'You have a task due soon.' }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endif

<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard</h2>
        <p class="text-slate-500 mt-1">Here is what's happening with your tasks today.</p>
    </div>
    <a href="{{ route('tasks.create') }}" class="hidden sm:inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-5 rounded-full shadow-md shadow-indigo-200 transition-all duration-200 hover:-translate-y-0.5">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        New Task
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 p-6 border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-in-out z-0"></div>
        <div class="relative z-10">
            <h3 class="text-slate-500 text-sm font-semibold uppercase tracking-wider flex items-center">
                <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Total Tasks
            </h3>
            <p class="text-4xl font-extrabold text-slate-900 mt-3">{{ $totalTasks }}</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 p-6 border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-in-out z-0"></div>
        <div class="relative z-10">
            <h3 class="text-slate-500 text-sm font-semibold uppercase tracking-wider flex items-center">
                <svg class="w-4 h-4 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Completed
            </h3>
            <p class="text-4xl font-extrabold text-slate-900 mt-3">{{ $completedTasks }}</p>
        </div>
    </div>
    
    
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 p-6 border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-in-out z-0"></div>
        <div class="relative z-10">
            <h3 class="text-slate-500 text-sm font-semibold uppercase tracking-wider flex items-center">
                <svg class="w-4 h-4 mr-1 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Pending
            </h3>
            <p class="text-4xl font-extrabold text-slate-900 mt-3">{{ $pendingTasks }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Progress Chart -->
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 p-8 border border-slate-100 flex flex-col">
        <h3 class="text-lg font-bold text-slate-900 mb-6 border-b border-slate-100 pb-4">Completion Progress</h3>
        <div class="relative h-64 w-full flex-grow flex items-center justify-center">
            <canvas id="progressChart"></canvas>
            @if($totalTasks === 0)
                <div class="absolute inset-0 flex items-center justify-center text-slate-400 text-sm font-medium">No tasks yet</div>
            @endif
        </div>
    </div>

    <!-- Activity Feed -->
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 p-8 border border-slate-100 flex flex-col">
        <h3 class="text-lg font-bold text-slate-900 mb-6 border-b border-slate-100 pb-4">Recent Activity</h3>
        <div class="flex-grow overflow-y-auto pr-2" style="max-height: 16rem;">
            @if($recentLogs->count() > 0)
                <div class="flow-root">
                    <ul class="-mb-8">
                        @foreach($recentLogs as $index => $log)
                        <li>
                            <div class="relative pb-8">
                                @if($index !== $recentLogs->count() - 1)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white 
                                            {{ $log->action === 'created' ? 'bg-emerald-100 text-emerald-500' : ($log->action === 'updated' ? 'bg-blue-100 text-blue-500' : 'bg-rose-100 text-rose-500') }}">
                                            @if($log->action === 'created')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            @elseif($log->action === 'updated')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-slate-600">
                                                You <span class="font-medium text-slate-900">{{ $log->action }}</span> task: 
                                                <span class="italic text-slate-800">"{{ $log->task ? $log->task->title : 'Deleted Task' }}"</span>
                                            </p>
                                        </div>
                                        <div class="text-right text-xs whitespace-nowrap text-slate-500">
                                            <time datetime="{{ $log->created_at }}">{{ $log->created_at->diffForHumans() }}</time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-full text-center py-10">
                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-slate-500 text-sm font-medium">No recent activity yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('progressChart').getContext('2d');
        const completionPercentage = {{ $completionPercentage }};
        const remainingPercentage = 100 - completionPercentage;

        @if($totalTasks > 0)
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending'],
                datasets: [{
                    data: [completionPercentage, remainingPercentage],
                    backgroundColor: [
                        '#10b981', // emerald-500
                        '#f59e0b'  // amber-500
                    ],
                    borderWidth: 0,
                    hoverOffset: 4,
                    cutout: '75%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                family: "'Instrument Sans', sans-serif",
                                size: 13
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                }
            }
        });
        @endif
    });
</script>
@endsection
