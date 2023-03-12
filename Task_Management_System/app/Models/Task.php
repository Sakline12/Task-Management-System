<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table='tasks';
    protected $fillable = [
        'project_id',
        'task_name',
        'task_description',
        'task_assigned',
        'task_Status',
        'start_date',
        'end_date'
    ];

    public function project(){
        return $this->belongsTo(Project::class,'project_id','id');
    }

    public function comment(){
        return $this->hasMany(Comment::class,'task_id','id');
    }
}
