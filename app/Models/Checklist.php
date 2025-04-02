<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $fillable = ['direction_id', 'name'];

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function blocks()
    {
        return $this->hasMany(ChecklistBlock::class);
    }

    public function submissions()
    {
        return $this->hasMany(ChecklistSubmission::class);
    }
}
