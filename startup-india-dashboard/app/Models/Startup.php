<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Startup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'founder_name',
        'email',
        'phone',
        'website',
        'description',
        'founding_date',
        'industry',
        'stage',
        'funding_amount',
        'employee_count',
        'location',
        'logo',
        'status',
    ];

    /**
     * Get the milestones for the startup.
     */
    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }

    /**
     * Get the funding rounds for the startup.
     */
    public function fundingRounds()
    {
        return $this->hasMany(FundingRound::class);
    }

    /**
     * Get the metrics for the startup.
     */
    public function metrics()
    {
        return $this->hasMany(StartupMetric::class);
    }
}