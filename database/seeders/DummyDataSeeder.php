<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\Users::first();

        if (!$user) {
            // Should not happen if UserSeeder runs first, but safety check
            return;
        }

        // Create Categories
        $categories = \App\Models\Category::factory(5)->create([
            'user_id' => $user->id
        ]);

        // Create Customers
        $customers = \App\Models\Customer::factory(10)->create([
            'user_id' => $user->id
        ]);

        // Create Products
        $products = \App\Models\Product::factory(20)->recycle($categories)->create([
            'user_id' => $user->id
        ]);

        // Create Sales (Invoices)
        \App\Models\Invoice::factory(10)
            ->recycle($customers)
            ->create([
                'user_id' => $user->id
            ])
            ->each(function ($invoice) use ($products, $user) {
                // Add products to invoice
                \App\Models\InvoiceProduct::factory(rand(1, 5))->create([
                    'invoice_id' => $invoice->id,
                    'user_id' => $user->id,
                    'product_id' => $products->random()->id
                ]);
            });
    }
}
