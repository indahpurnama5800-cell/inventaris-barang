<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'code', 'name', 'category_id', 'supplier_id',
        'stock', 'reorder_point', 'unit', 'price', 'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Status stok: safe (Aman) / low (Perlu Restock) / critical (Stok Habis)
    public function stockStatus(): string
    {
        if ($this->stock <= 0) return 'critical';
        if ($this->stock <= $this->reorder_point) return 'low';
        return 'safe';
    }

    public function stockStatusLabel(): string
    {
        return match ($this->stockStatus()) {
            'critical' => 'Stok Habis',
            'low' => 'Perlu Restock',
            default => 'Aman',
        };
    }

    public function stockStatusBadgeClass(): string
    {
        return match ($this->stockStatus()) {
            'critical' => 'bg-danger',
            'low' => 'bg-warning text-dark',
            default => 'bg-success',
        };
    }

    // Rata-rata barang keluar per hari, dari riwayat transaksi 30 hari terakhir
    public function averageDailyUsage(int $days = 30): float
    {
        $totalOut = $this->transactions()
            ->where('type', 'out')
            ->where('transaction_date', '>=', now()->subDays($days))
            ->sum('quantity');

        return $totalOut > 0 ? round($totalOut / $days, 2) : 0;
    }

    // Estimasi jumlah hari sampai stok habis
    public function predictedDaysUntilStockout(): ?int
    {
        $avg = $this->averageDailyUsage();
        if ($avg <= 0) return null;
        return (int) floor($this->stock / $avg);
    }

    // Prioritas restock: tinggi / sedang / rendah
    public function restockPriority(): string
    {
        if ($this->stock <= 0) return 'tinggi';

        $days = $this->predictedDaysUntilStockout();

        if ($days === null) {
            return $this->stock <= $this->reorder_point ? 'sedang' : 'rendah';
        }
        if ($days <= 7) return 'tinggi';
        if ($days <= 21) return 'sedang';
        return 'rendah';
    }

    public function restockPriorityBadgeClass(): string
    {
        return match ($this->restockPriority()) {
            'tinggi' => 'bg-danger',
            'sedang' => 'bg-warning text-dark',
            default => 'bg-success',
        };
    }
}
