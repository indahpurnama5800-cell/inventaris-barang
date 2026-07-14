<?php
namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Collection;

/**
 * Prediksi kehabisan stok berbasis rata-rata barang keluar (moving average)
 * dari riwayat transaksi 30 hari terakhir. Bukan model AI eksternal — logika
 * utamanya ada di Item::averageDailyUsage() dan Item::predictedDaysUntilStockout().
 */
class StockPredictionService
{
    // Barang yang diprediksi habis dalam $withinDays hari, diurutkan dari yang paling mendesak
    public function itemsAtRiskOfStockout(int $withinDays = 21): Collection
    {
        return Item::with(['category', 'supplier'])->get()
            ->filter(function (Item $item) use ($withinDays) {
                $days = $item->predictedDaysUntilStockout();
                return $days !== null && $days <= $withinDays;
            })
            ->sortBy(fn (Item $item) => $item->predictedDaysUntilStockout())
            ->values();
    }

    // Rekomendasi jumlah pemesanan ulang agar cukup untuk 30 hari ke depan
    public function suggestedReorderQuantity(Item $item, int $targetDaysCoverage = 30): int
    {
        $avgDaily = $item->averageDailyUsage();
        if ($avgDaily <= 0) {
            return max($item->reorder_point * 2 - $item->stock, 0);
        }
        $target = (int) ceil($avgDaily * $targetDaysCoverage);
        return max($target - $item->stock, 0);
    }
}
