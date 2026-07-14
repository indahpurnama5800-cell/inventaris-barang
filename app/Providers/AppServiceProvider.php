<?php

namespace App\Providers;

use App\Models\Item;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Membagikan data notifikasi stok menipis ke seluruh halaman (dipakai di layouts/app.blade.php)
        View::composer('layouts.app', function ($view) {
            if (auth()->check()) {
                $lowStockItems = Item::whereColumn('stock', '<=', 'reorder_point')
                    ->orderBy('stock')
                    ->limit(6)
                    ->get();

                $view->with('lowStockNotifItems', $lowStockItems);
                $view->with('lowStockNotifCount', $lowStockItems->count());
            }
        });
    }
}
