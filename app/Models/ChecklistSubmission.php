<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistSubmission extends Model
{
    protected $fillable = [
        'checklist_id',
        'manager_id',
        'call_status',
        'call_date_time',
        'client_phone',
        'total_score',
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function blocks()
    {
        return $this->hasMany(SubmissionBlock::class, 'submission_id');
    }
}
