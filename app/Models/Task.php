<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status',
        'subject',
        'priority',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query->where('title', 'LIKE', '%' . $keyword . '%');
        }
        return $query;
    }

    public function scopeStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopePriority($query, $priority)
    {
        if ($priority) {
            return $query->where('priority', $priority);
        }
        return $query;
    }

    public function scopeSubject($query, $subject)
    {
        if ($subject) {
            return $query->where('subject', $subject);
        }
        return $query;
    }
}
