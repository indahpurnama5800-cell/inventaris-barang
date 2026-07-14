<?php
namespace Database\Seeders;

use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $items = Item::inRandomOrder()->limit(150)->get();

        foreach ($items as $item) {
            $transactionCount = fake()->numberBetween(1, 6);

            for ($i = 0; $i < $transactionCount; $i++) {
                Transaction::create([
                    'item_id' => $item->id,
                    'type' => fake()->randomElement(['in', 'in', 'out', 'out', 'out']),
                    'quantity' => fake()->numberBetween(1, 25),
                    'transaction_date' => Carbon::today()->subDays(fake()->numberBetween(0, 59)),
                    'notes' => fake()->boolean(50) ? 'Penerimaan dari supplier' : 'Pengeluaran untuk operasional',
                ]);
            }
        }
    }
}
