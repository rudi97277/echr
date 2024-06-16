<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormDetail extends Model
{
    public function component()
    {
        return $this->belongsTo(FormComponent::class, 'component_code', 'code');
    }
}
