<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waiting extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'file_path', 'note']; // 'note' alanını ekledik

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
