<?php

namespace Database\Seeders;

use App\Models\Startup;
use Illuminate\Database\Seeder;

class StartupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startups = [
            [
                'name' => 'EcoTech Solutions',
                'founder_name' => 'Raj Patel',
                'email' => 'raj@ecotech.com',
                'phone' => '+91 98765 43210',
                'website' => 'https://ecotech.com',
                'description' => 'Developing sustainable technology solutions for environmental challenges.',
                'founding_date' => '2020-05-15',
                'industry' => 'CleanTech',
                'stage' => 'seed',
                'funding_amount' => 500000.00,
                'employee_count' => 12,
                'location' => 'Bangalore',
                'status' => 'active',
            ],
            [
                'name' => 'MediConnect',
                'founder_name' => 'Priya Sharma',
                'email' => 'priya@mediconnect.in',
                'phone' => '+91 87654 32109',
                'website' => 'https://mediconnect.in',
                'description' => 'Healthcare platform connecting patients with specialized doctors.',
                'founding_date' => '2019-11-03',
                'industry' => 'HealthTech',
                'stage' => 'early',
                'funding_amount' => 1200000.00,
                'employee_count' => 25,
                'location' => 'Mumbai',
                'status' => 'active',
            ],
            [
                'name' => 'FinEdge',
                'founder_name' => 'Vikram Singh',
                'email' => 'vikram@finedge.co',
                'phone' => '+91 76543 21098',
                'website' => 'https://finedge.co',
                'description' => 'AI-powered fintech platform for personal finance management.',
                'founding_date' => '2021-02-10',
                'industry' => 'FinTech',
                'stage' => 'seed',
                'funding_amount' => 750000.00,
                'employee_count' => 18,
                'location' => 'Delhi',
                'status' => 'active',
            ],
            [
                'name' => 'AgroSmart',
                'founder_name' => 'Nitin Gupta',
                'email' => 'nitin@agrosmart.in',
                'phone' => '+91 65432 10987',
                'website' => 'https://agrosmart.in',
                'description' => 'Smart agriculture solutions using IoT and data analytics.',
                'founding_date' => '2018-07-22',
                'industry' => 'AgriTech',
                'stage' => 'growth',
                'funding_amount' => 3500000.00,
                'employee_count' => 42,
                'location' => 'Pune',
                'status' => 'active',
            ],
            [
                'name' => 'EduLabs',
                'founder_name' => 'Meera Joshi',
                'email' => 'meera@edulabs.org',
                'phone' => '+91 54321 09876',
                'website' => 'https://edulabs.org',
                'description' => 'Interactive learning platform for K-12 education.',
                'founding_date' => '2020-01-15',
                'industry' => 'EdTech',
                'stage' => 'early',
                'funding_amount' => 900000.00,
                'employee_count' => 22,
                'location' => 'Hyderabad',
                'status' => 'active',
            ],
        ];

        foreach ($startups as $startup) {
            Startup::create($startup);
        }

        // Create additional random startups
        Startup::factory(15)->create();
    }
}