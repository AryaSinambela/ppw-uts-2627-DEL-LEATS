<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Equipment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        $cat1 = Category::create(['name' => 'Server & Cloud', 'code' => 'SRV']);
        $cat2 = Category::create(['name' => 'Internet of Things', 'code' => 'IOT']);
        $cat3 = Category::create(['name' => 'Multimedia & Drone', 'code' => 'DRN']);

        
        Equipment::insert([
            [
                'category_id' => $cat1->id, 'asset_code' => 'EQ-SRV-001', 'name' => 'Dell PowerEdge R740', 
                'specification' => 'Intel Xeon Silver, 64GB RAM', 'condition' => 'baik', 'status' => 'tersedia', 'daily_rental_fee' => 150000
            ],
            [
                'category_id' => $cat1->id, 'asset_code' => 'EQ-SRV-002', 'name' => 'HP ProLiant DL380', 
                'specification' => 'Intel Xeon Gold, 128GB RAM', 'condition' => 'baik', 'status' => 'dipinjam', 'daily_rental_fee' => 200000
            ],
            [
                'category_id' => $cat2->id, 'asset_code' => 'EQ-IOT-001', 'name' => 'Raspberry Pi 4', 
                'specification' => '8GB RAM, Broadcom BCM2711', 'condition' => 'rusak_ringan', 'status' => 'dalam_perbaikan', 'daily_rental_fee' => 25000
            ],
            [
                'category_id' => $cat2->id, 'asset_code' => 'EQ-IOT-002', 'name' => 'Arduino Mega 2560', 
                'specification' => 'ATmega2560 Microcontroller', 'condition' => 'baik', 'status' => 'tersedia', 'daily_rental_fee' => 10000
            ],
            [
                'category_id' => $cat3->id, 'asset_code' => 'EQ-DRN-001', 'name' => 'DJI Mavic 3', 
                'specification' => '4/3 CMOS Hasselblad Camera', 'condition' => 'baik', 'status' => 'tersedia', 'daily_rental_fee' => 300000
            ],
            [
                'category_id' => $cat3->id, 'asset_code' => 'EQ-DRN-002', 'name' => 'Sony A7 IV', 
                'specification' => '33MP Full-Frame Exmor R', 'condition' => 'rusak_berat', 'status' => 'dalam_perbaikan', 'daily_rental_fee' => 250000
            ],
        ]);
    }
}