<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function projectAttachment()
    {
        return $this->hasMany(ProjectAttachment::class);
    }
}
