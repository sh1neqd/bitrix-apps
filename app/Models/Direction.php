<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    protected $fillable = ['name'];

    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }
}
