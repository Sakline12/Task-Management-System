<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table='projects';
    protected $fillable = [
        'user_id',
        'project_name',
        'project_description',
        'project_assigned',
        'project_Status',
        'start_date',
        'end_date'

    ];

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function task(){
        return $this->hasMany(Task::class,'project_id','id');
    }
}
