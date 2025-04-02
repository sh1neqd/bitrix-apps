<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionBlock extends Model
{
    protected $fillable = [
        'submission_id',
        'block_id',
        'checked',
        'comment',
        'score',
    ];

    public function submission()
    {
        return $this->belongsTo(ChecklistSubmission::class, 'submission_id');
    }

    public function block()
    {
        return $this->belongsTo(ChecklistBlock::class, 'block_id');
    }


    public function errors()
    {
        return $this->hasMany(SubmissionError::class);
    }
}
