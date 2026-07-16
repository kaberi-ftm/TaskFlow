<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $totalTasks = $user->tasks()->count();
        $completedTasks = $user->tasks()->where('status', 'completed')->count();
        $pendingTasks = $user->tasks()->where('status', 'pending')->count();
        
        $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        $recentLogs = ActivityLog::where('user_id', $user->id)
            ->with('task')
            ->latest()
            ->take(10)
            ->get();
            
        $notifications = $user->unreadNotifications;

        return view('dashboard', compact(
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'completionPercentage',
            'recentLogs',
            'notifications'
        ));
    }
}
