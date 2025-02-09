<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FavouriteSector;

class FavouriteSectorSeeder extends Seeder {
    public function run(): void {
        $sectors = [
            'Technology',  
            'FinTech',  
            'E-Commerce',  
            'Healthcare & HealthTech',  
            'Education & EdTech',  
            'Renewable Energy',  
            'Manufacturing',  
            'Logistics & Transportation',  
            'Real Estate',  
            'Artificial Intelligence',  
            'Big Data & Analytics',  
            'CyberSecurity',  
            'Digital Marketing',  
            'General Trade',  
            'Travel & Tourism',  
            'Food & Beverage',  
            'Retail',  
            'Sports & Entertainment',  
            'Robotics',  
            'AgriTech',  
            'Environmental & Sustainability',  
            'AR/VR',  
            'Digital Payments',  
            'Financial Services',  
            'Media & Communication',  
            'Gaming',  
            'BioTech',  
            'InsurTech',  
            'Property Development',  
            'Social Innovation'

        ];

        foreach ($sectors as $sector) {
            FavouriteSector::create(['name' => $sector]);
        }
    }
}
