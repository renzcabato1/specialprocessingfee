<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    public function form_request()
    {
        return $this->belongsTo(FormRequest::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'encode_by', 'id');
    }
}
