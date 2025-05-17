<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'description', 'project_manager'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id', 'id');
    }

    public function manager()
    {
        // The second argument is the foreign key column in 'projects' table
        // that references the 'users' table (i.e., 'project_manager').
        return $this->belongsTo(User::class, 'project_manager');
    }

    public static function getUserProjects($userId)
    {
        return self::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }
}
