<?php

namespace Database\Seeders;

use App\Models\Milestone;
use App\Models\Startup;
use Illuminate\Database\Seeder;

class MilestoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startups = Startup::all();

        foreach ($startups as $startup) {
            // Create 3-5 milestones for each startup
            $milestoneCount = rand(3, 5);
            for ($i = 0; $i < $milestoneCount; $i++) {
                $status = ['planned', 'in_progress', 'completed', 'delayed'][rand(0, 3)];
                $type = ['product', 'business', 'funding', 'team', 'partnership'][rand(0, 4)];
                
                $date = $startup->founding_date;
                $date = date('Y-m-d', strtotime($date . ' + ' . rand(1, 24) . ' months'));
                
                Milestone::create([
                    'startup_id' => $startup->id,
                    'title' => $this->getMilestoneTitle($type),
                    'description' => $this->getMilestoneDescription($type),
                    'date' => $date,
                    'status' => $status,
                    'type' => $type,
                ]);
            }
        }
    }

    /**
     * Get a random milestone title based on type
     */
    private function getMilestoneTitle($type)
    {
        $titles = [
            'product' => [
                'MVP Launch', 
                'Beta Release', 
                'Product v1.0 Launch', 
                'Feature X Implementation',
                'Mobile App Release'
            ],
            'business' => [
                'Business Registration', 
                'First Customer', 
                '100 Customers Milestone', 
                'First Profitable Month',
                'Market Expansion'
            ],
            'funding' => [
                'Pre-Seed Funding', 
                'Seed Round Closed', 
                'Series A Funding', 
                'Grant Approval',
                'Strategic Investment'
            ],
            'team' => [
                'First Team Member Hire', 
                'CTO Onboarding', 
                'Team Size Reached 10', 
                'Advisory Board Formation',
                'International Team Expansion'
            ],
            'partnership' => [
                'Strategic Partnership', 
                'Distribution Agreement', 
                'Corporate Collaboration', 
                'Industry Alliance',
                'Government Partnership'
            ],
        ];

        return $titles[$type][rand(0, 4)];
    }

    /**
     * Get a random milestone description based on type
     */
    private function getMilestoneDescription($type)
    {
        $descriptions = [
            'product' => [
                'Successfully launched the minimum viable product to initial test users.',
                'Released beta version to selected users for feedback and testing.',
                'Official launch of product version 1.0 with all core features.',
                'Implementation of key feature to enhance product capabilities.',
                'Launched mobile application for iOS and Android platforms.'
            ],
            'business' => [
                'Completed business registration and legal formalities.',
                'Acquired first paying customer, validating business model.',
                'Reached milestone of 100 active customers.',
                'Achieved first month of positive cash flow.',
                'Expanded operations to new market regions.'
            ],
            'funding' => [
                'Secured pre-seed funding to initiate product development.',
                'Successfully closed seed round to accelerate growth.',
                'Raised Series A funding for scaling operations.',
                'Received government grant for innovative technology.',
                'Secured strategic investment from industry leader.'
            ],
            'team' => [
                'Hired first team member to support core operations.',
                'Onboarded experienced CTO to lead technical development.',
                'Team expanded to 10 members across different functions.',
                'Formed advisory board with industry experts.',
                'Expanded team with international talent.'
            ],
            'partnership' => [
                'Established strategic partnership with industry leader.',
                'Signed distribution agreement to expand market reach.',
                'Initiated collaboration with corporate entity.',
                'Joined industry alliance for standardization and advocacy.',
                'Secured partnership with government initiative.'
            ],
        ];

        return $descriptions[$type][rand(0, 4)];
    }
}