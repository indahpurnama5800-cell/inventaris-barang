<?php
namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Services\StockPredictionService;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(StockPredictionService $prediction)
    {
        $totalItems = Item::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        $totalTransactions = Transaction::count();
        $needRestockCount = Item::where(function ($query) {
            $query->where('stock', '<=', 0)
                ->orWhere(function ($q) {
                    $q->where('stock', '>', 0)
                        ->whereColumn('stock', '<=', 'reorder_point');
                });
        })->count();
        $outOfStockCount = Item::where('stock', '<=', 0)->count();

        $restockItems = Item::with(['category', 'supplier'])
            ->where(function ($query) {
                $query->where('stock', '<=', 0)
                    ->orWhere(function ($q) {
                        $q->where('stock', '>', 0)
                            ->whereColumn('stock', '<=', 'reorder_point');
                    });
            })
            ->orderBy('stock', 'asc')
            ->get();
        $latestItems = Item::with('category')->latest()->limit(6)->get();

        $recentActivities = AuditLog::latest()->limit(8)->get();

        $atRiskItems = $prediction->itemsAtRiskOfStockout(21)->take(8);

        $days = collect(range(29, 0))->map(fn ($i) => Carbon::today()->subDays($i));
        $trend = $days->map(function (Carbon $date) {
            $in = Transaction::where('type', 'in')->whereDate('transaction_date', $date)->sum('quantity');
            $out = Transaction::where('type', 'out')->whereDate('transaction_date', $date)->sum('quantity');
            return ['date' => $date->format('d/m'), 'masuk' => (int) $in, 'keluar' => (int) $out];
        });

        return view('dashboard.index', compact(
            'totalItems', 'totalCategories', 'totalSuppliers', 'totalTransactions',
            'needRestockCount', 'outOfStockCount', 'restockItems', 'latestItems',
            'recentActivities', 'atRiskItems', 'trend'
        ));
    }
}
