<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
