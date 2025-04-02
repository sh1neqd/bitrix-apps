<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionError extends Model
{
    protected $fillable = [
        'submission_block_id',
        'error_id',
        'timing',
    ];

    public function submissionBlock()
    {
        return $this->belongsTo(SubmissionBlock::class);
    }

    public function error()
    {
        return $this->belongsTo(Error::class);
    }
}
