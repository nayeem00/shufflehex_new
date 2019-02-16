<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedProject extends Model
{
    protected $fillable = [
        'project_id', 'user_id','folder_id',
    ];
    protected $dates=['deleted_at'];

    public function projects()
    {
        return $this->belongsTo('App\Project');
    }
}
