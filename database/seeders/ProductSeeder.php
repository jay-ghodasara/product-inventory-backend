<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clothCategory = Category::where('slug','cloth')->first();
        $electronicsCategory = Category::where('slug','electronics')->first();
        $kitchenCategory = Category::where('slug','kitchen')->first();

        Product::insert([[
            'category_id' => $clothCategory?->id,
            'name' => 'Men Shirt',
            'sku' => 'CLOTH-MEN-SHIRT-001',
            'description' => 'Men Shirt',
            'price' => 4000,
            'cost' => 2000,
            'quantity_in_stock' => 15,
            'minimum_stock_level' => 10,
            'supplier_name' => 'Nike',
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'category_id' => $electronicsCategory?->id,
            'name' => 'LG 42 Inch TV',
            'sku' => 'ELEC-TV-002',
            'description' => 'LG 42 Inch TV',
            'price' => 22000,
            'cost' => 20000,
            'quantity_in_stock' => 10,
            'minimum_stock_level' => 5,
            'supplier_name' => 'LG India',
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'category_id' => $kitchenCategory?->id,
            'name' => 'Drawer Handle SS',
            'sku' => 'KIT-DRAWER-003',
            'description' => 'Kitchen Drawer Handle SS',
            'price' => 1200,
            'cost' => 700,
            'quantity_in_stock' => 20,
            'minimum_stock_level' => 12,
            'supplier_name' => 'SS Hardware India',
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]]
        );
    }
}
