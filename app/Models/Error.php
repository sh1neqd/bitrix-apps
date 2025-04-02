<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    protected $fillable = ['description', 'weight'];

    public function blockErrors()
    {
        return $this->belongsToMany(ChecklistBlock::class, 'block_errors', 'error_id', 'block_id');
    }
}
