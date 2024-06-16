<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    public $timestamps = false;

    public function details()
    {
        return $this->hasMany(FormDetail::class);
    }
}
