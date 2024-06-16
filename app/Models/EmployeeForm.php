<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeForm extends Model
{
    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(FormDetail::class, 'form_id', 'form_id');
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
