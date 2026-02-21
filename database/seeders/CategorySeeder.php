<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Cloth', 'slug' => 'cloth'],
            ['name' => 'Kitchen', 'slug' => 'kitchen'],
            ['name' => 'Hardware Parts', 'slug' => 'hardware_parts'],
            ['name' => 'Electronics', 'slug' => 'electronics'],
        ];

        foreach($data as $key=>$value)
        {
            Category::firstOrCreate([
                'name' => $value['name'],
                'slug' => $value['slug']
            ]);
        }
    }
}
