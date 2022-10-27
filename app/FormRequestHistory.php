<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class FormRequestHistory extends Model
{
    //
    public function bo_companies()
    {
        return $this->belongsTo(FormRequest::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'action_by', 'id');
    }
}
