<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    protected $fillable = ['name', 'supervisor'];

    public function submissions()
    {
        return $this->hasMany(ChecklistSubmission::class);
    }

    public static function findOrCreateByName($name)
    {
        return self::firstOrCreate(['name' => $name]);
    }
}
