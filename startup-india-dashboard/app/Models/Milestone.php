<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'startup_id',
        'title',
        'description',
        'date',
        'status',
        'type',
    ];

    /**
     * Get the startup that owns the milestone.
     */
    public function startup()
    {
        return $this->belongsTo(Startup::class);
    }
}