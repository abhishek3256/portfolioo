<?php

namespace Database\Seeders;

use App\Models\FundingRound;
use App\Models\Startup;
use Illuminate\Database\Seeder;

class FundingRoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startups = Startup::all();
        $roundTypes = ['pre-seed', 'seed', 'series_a', 'series_b', 'series_c', 'series_d', 'other'];
        $investors = [
            'Sequoia Capital India', 
            'Accel Partners', 
            'Tiger Global', 
            'Nexus Venture Partners', 
            'Blume Ventures',
            'Elevation Capital', 
            'Lightspeed Venture Partners', 
            'Kalaari Capital', 
            'Matrix Partners India',
            'SoftBank Vision Fund',
            'Indian Angel Network',
            'Y Combinator',
            'StartupXseed Ventures',
            '3one4 Capital',
            'Venture Catalysts'
        ];

        foreach ($startups as $startup) {
            // Not all startups will have funding
            if (rand(0, 10) < 8) {
                // Determine number of funding rounds based on stage
                $roundCount = 1; // default
                
                switch ($startup->stage) {
                    case 'idea':
                    case 'pre-seed':
                        $roundCount = rand(0, 1);
                        break;
                    case 'seed':
                        $roundCount = rand(1, 2);
                        break;
                    case 'early':
                        $roundCount = rand(1, 3);
                        break;
                    case 'growth':
                    case 'mature':
                        $roundCount = rand(2, 4);
                        break;
                }

                // Create funding rounds
                for ($i = 0; $i < $roundCount; $i++) {
                    // Determine round type based on index
                    $roundType = $roundTypes[min($i, count($roundTypes) - 1)];
                    
                    // Determine funding amount based on round type
                    $amount = 0;
                    switch ($roundType) {
                        case 'pre-seed':
                            $amount = rand(50, 300) * 1000;
                            break;
                        case 'seed':
                            $amount = rand(300, 1000) * 1000;
                            break;
                        case 'series_a':
                            $amount = rand(1000, 5000) * 1000;
                            break;
                        case 'series_b':
                            $amount = rand(5000, 15000) * 1000;
                            break;
                        case 'series_c':
                        case 'series_d':
                            $amount = rand(15000, 50000) * 1000;
                            break;
                        default:
                            $amount = rand(100, 2000) * 1000;
                    }
                    
                    // Determine valuation (typically 4-10x the funding amount)
                    $valuation = $amount * rand(4, 10);
                    
                    // Select random investors
                    $investorCount = rand(1, 3);
                    $roundInvestors = [];
                    for ($j = 0; $j < $investorCount; $j++) {
                        $roundInvestors[] = $investors[array_rand($investors)];
                    }
                    $investorString = implode(', ', array_unique($roundInvestors));
                    
                    // Determine date (chronological from founding date)
                    $date = $startup->founding_date;
                    $date = date('Y-m-d', strtotime($date . ' + ' . ($i * rand(4, 12)) . ' months'));
                    
                    FundingRound::create([
                        'startup_id' => $startup->id,
                        'round_type' => $roundType,
                        'amount' => $amount,
                        'investors' => $investorString,
                        'date' => $date,
                        'valuation' => $valuation,
                        'notes' => 'Funding will be used for ' . 
                                  ['product development', 'market expansion', 'team growth', 'R&D', 'operations'][rand(0, 4)]
                    ]);
                }
            }
        }
    }
}