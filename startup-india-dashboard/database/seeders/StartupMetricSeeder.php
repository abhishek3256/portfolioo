<?php

namespace Database\Seeders;

use App\Models\Startup;
use App\Models\StartupMetric;
use Illuminate\Database\Seeder;

class StartupMetricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startups = Startup::all();
        $metricTypes = ['revenue', 'users', 'growth_rate', 'burn_rate', 'customer_acquisition_cost', 'churn_rate'];

        foreach ($startups as $startup) {
            // Create metrics for the past 6 months
            for ($month = 6; $month >= 0; $month--) {
                $date = date('Y-m-d', strtotime("first day of -$month months"));
                
                // Add various metrics
                foreach ($metricTypes as $metricType) {
                    switch ($metricType) {
                        case 'revenue':
                            // Monthly revenue in thousands
                            $baseValue = rand(5, 200) * 1000;
                            // Gradually increase by 5-15% per month
                            $value = $baseValue * (1 + ((6 - $month) * (rand(5, 15) / 100)));
                            StartupMetric::create([
                                'startup_id' => $startup->id,
                                'metric_name' => 'Monthly Revenue',
                                'metric_value' => round($value, 2),
                                'date' => $date,
                                'notes' => 'Monthly recurring revenue',
                            ]);
                            break;
                            
                        case 'users':
                            // User count
                            $baseUsers = rand(100, 5000);
                            // Growth rate between 10-30% per month
                            $users = $baseUsers * (1 + ((6 - $month) * (rand(10, 30) / 100)));
                            StartupMetric::create([
                                'startup_id' => $startup->id,
                                'metric_name' => 'Active Users',
                                'metric_value' => round($users),
                                'date' => $date,
                                'notes' => 'Monthly active users',
                            ]);
                            break;
                            
                        case 'growth_rate':
                            // Growth rate percentage
                            $growthRate = rand(5, 25);
                            StartupMetric::create([
                                'startup_id' => $startup->id,
                                'metric_name' => 'Growth Rate',
                                'metric_value' => $growthRate . '%',
                                'date' => $date,
                                'notes' => 'Month-over-month growth percentage',
                            ]);
                            break;
                            
                        case 'burn_rate':
                            // Burn rate in thousands
                            $burnRate = rand(10, 100) * 1000;
                            StartupMetric::create([
                                'startup_id' => $startup->id,
                                'metric_name' => 'Burn Rate',
                                'metric_value' => round($burnRate, 2),
                                'date' => $date,
                                'notes' => 'Monthly cash burn',
                            ]);
                            break;
                            
                        case 'customer_acquisition_cost':
                            // CAC
                            $cac = rand(20, 200);
                            StartupMetric::create([
                                'startup_id' => $startup->id,
                                'metric_name' => 'Customer Acquisition Cost',
                                'metric_value' => $cac,
                                'date' => $date,
                                'notes' => 'Average cost to acquire new customer',
                            ]);
                            break;
                            
                        case 'churn_rate':
                            // Churn rate percentage
                            $churnRate = rand(1, 8) + (rand(0, 99) / 100);
                            StartupMetric::create([
                                'startup_id' => $startup->id,
                                'metric_name' => 'Churn Rate',
                                'metric_value' => $churnRate . '%',
                                'date' => $date,
                                'notes' => 'Monthly customer churn percentage',
                            ]);
                            break;
                    }
                }
            }
        }
    }
}