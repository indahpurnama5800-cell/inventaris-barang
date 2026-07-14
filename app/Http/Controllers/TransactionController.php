<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use App\Services\AuditLogService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('item');

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->whereHas('item', function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('code', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        $transactions = $query->latest('transaction_date')->paginate(10)->withQueryString();
        $items = Item::orderBy('name')->get();

        return view('transactions.index', compact('transactions', 'items'));
    }

    public function create()
    {
        $items = Item::orderBy('name')->get();
        return view('transactions.create', compact('items'));
    }

    public function store(Request $request, AuditLogService $audit)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $item = Item::findOrFail($validated['item_id']);

        if ($validated['type'] === 'in') {
            $item->increment('stock', $validated['quantity']);
        } else {
            if ($item->stock < $validated['quantity']) {
                return back()->withInput()->withErrors(['quantity' => 'Stok barang tidak cukup.']);
            }
            $item->decrement('stock', $validated['quantity']);
        }

        $trx = Transaction::create($validated);

        $label = $validated['type'] === 'in' ? 'masuk' : 'keluar';
        $audit->log('create', 'Transaction', $trx->id, "Transaksi {$label}: {$item->name} x{$validated['quantity']}");

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dicatat.');
    }

    public function edit(Transaction $transaction)
    {
        $items = Item::orderBy('name')->get();
        return view('transactions.edit', compact('transaction', 'items'));
    }

    public function update(Request $request, Transaction $transaction, AuditLogService $audit)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $oldItem = $transaction->item;
        if ($transaction->type === 'in') {
            $oldItem->decrement('stock', $transaction->quantity);
        } else {
            $oldItem->increment('stock', $transaction->quantity);
        }

        $newItem = Item::findOrFail($validated['item_id']);
        if ($validated['type'] === 'in') {
            $newItem->increment('stock', $validated['quantity']);
        } else {
            $newItem->decrement('stock', $validated['quantity']);
        }

        $transaction->update($validated);
        $audit->log('update', 'Transaction', $transaction->id, "Memperbarui transaksi #{$transaction->id}");

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction, AuditLogService $audit)
    {
        $item = $transaction->item;
        if ($transaction->type === 'in') {
            $item->decrement('stock', $transaction->quantity);
        } else {
            $item->increment('stock', $transaction->quantity);
        }

        $audit->log('delete', 'Transaction', $transaction->id, "Menghapus transaksi #{$transaction->id}");
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
