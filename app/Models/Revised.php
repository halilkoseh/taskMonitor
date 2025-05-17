<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revised extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'file_path', 'note'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
