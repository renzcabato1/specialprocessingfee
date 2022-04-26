<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormRequest extends Model
{
    //
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'encode_by','id');
    }
    public function bank_info()
    {
        return $this->belongsTo(Bank::class,'bank','id');
    }
    public function attachments()
    {
        return $this->hasMany(Attachment::class,'id','form_request_id');
    }
}
