<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockError extends Model
{
    protected $fillable = ['block_id', 'error_id', 'timing'];

    public function block()
    {
        return $this->belongsTo(ChecklistBlock::class);
    }

    public function error()
    {
        return $this->belongsTo(Error::class);
    }
}
