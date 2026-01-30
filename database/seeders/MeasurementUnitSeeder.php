<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MeasurementUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        $units = [
            // Weight
            ['name' => 'Kilogram', 'symbol' => 'kg', 'type' => 'weight', 'description' => 'Unit of mass'],
            ['name' => 'Gram', 'symbol' => 'g', 'type' => 'weight', 'description' => 'Unit of mass'],
            ['name' => 'Pound', 'symbol' => 'lb', 'type' => 'weight', 'description' => 'Unit of mass'],
            ['name' => 'Ton', 'symbol' => 't', 'type' => 'weight', 'description' => 'Metric ton'],
            
            // Length
            ['name' => 'Meter', 'symbol' => 'm', 'type' => 'length', 'description' => 'Unit of length'],
            ['name' => 'Centimeter', 'symbol' => 'cm', 'type' => 'length', 'description' => 'Unit of length'],
            ['name' => 'Millimeter', 'symbol' => 'mm', 'type' => 'length', 'description' => 'Unit of length'],
            ['name' => 'Kilometer', 'symbol' => 'km', 'type' => 'length', 'description' => 'Unit of length'],
            ['name' => 'Inch', 'symbol' => 'in', 'type' => 'length', 'description' => 'Unit of length'],
            ['name' => 'Foot', 'symbol' => 'ft', 'type' => 'length', 'description' => 'Unit of length'],
            
            // Volume
            ['name' => 'Liter', 'symbol' => 'L', 'type' => 'volume', 'description' => 'Unit of volume'],
            ['name' => 'Milliliter', 'symbol' => 'mL', 'type' => 'volume', 'description' => 'Unit of volume'],
            ['name' => 'Gallon', 'symbol' => 'gal', 'type' => 'volume', 'description' => 'Unit of volume'],
            
            // Quantity/Count
            ['name' => 'Piece', 'symbol' => 'pcs', 'type' => 'quantity', 'description' => 'Individual units'],
            ['name' => 'Box', 'symbol' => 'box', 'type' => 'quantity', 'description' => 'Boxed items'],
            ['name' => 'Carton', 'symbol' => 'ctn', 'type' => 'quantity', 'description' => 'Carton packaging'],
            ['name' => 'Dozen', 'symbol' => 'dz', 'type' => 'quantity', 'description' => '12 units'],
            ['name' => 'Pack', 'symbol' => 'pack', 'type' => 'quantity', 'description' => 'Package of items'],
        ];

        foreach ($units as &$unit) {
            $unit['is_active'] = true;
            $unit['created_at'] = $now;
            $unit['updated_at'] = $now;
        }

        DB::table('measurement_units')->insert($units);
    }
}
