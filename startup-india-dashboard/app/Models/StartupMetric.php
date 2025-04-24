<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StartupMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'startup_id',
        'metric_name',
        'metric_value',
        'date',
        'notes',
    ];

    /**
     * Get the startup that owns the metric.
     */
    public function startup()
    {
        return $this->belongsTo(Startup::class);
    }
}