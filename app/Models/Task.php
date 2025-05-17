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
        'user_id',
        'project_id',
        'start_date',
        'due_date',
        'status',
        'attachments',
        'approval_requested_at', // eklendi
        'approved_at',           // eklendi
    ];

    protected $casts = [
        'approval_requested_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    // Tarihleri belirli bir formatta almak için
    public function getApprovalRequestedAtFormattedAttribute()
    {
        return $this->approval_requested_at ? $this->approval_requested_at->format('d-m-Y H:i:s') : '-';
    }

    public function getApprovedAtFormattedAttribute()
    {
        return $this->approved_at ? $this->approved_at->format('d-m-Y H:i:s') : '-';
    }

    // Task.php (Model)
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }


    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedProject()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }


    public function project()
    {
        return $this->belongsTo(Project::class);

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public static function getUserTasks($userId)
    {
        return self::where('user_id', $userId)->get();
    }


    public function waitings()
    {
        return $this->hasMany(Waiting::class, 'task_id');
    }
    
    public function approveds()
    {
        return $this->hasMany(Approved::class, 'task_id');
    }
    
    public function reviseds()
    {
        return $this->hasMany(Revised::class, 'task_id');
    }
    

}








