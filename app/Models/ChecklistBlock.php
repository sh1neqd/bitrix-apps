<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistBlock extends Model
{
    protected $fillable = ['checklist_id', 'title', 'max_score'];

    // Связь с чеклистом
    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    // Связь с ошибками через промежуточную таблицу block_errors
    public function possibleErrors()
    {
        return $this->belongsToMany(Error::class, 'block_errors', 'block_id', 'error_id')
            ->withPivot('timing');
    }
}
