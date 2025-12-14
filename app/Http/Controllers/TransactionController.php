<?php
// app/Http/Controllers/TransactionController.php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('category')
                    ->where('user_id', Auth::id())
                    ->latest();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('description', 'like', '%'.$request->search.'%')
                  ->orWhere('amount', 'like', '%'.$request->search.'%')
                  ->orWhereHas('category', function($c) use ($request) {
                      $c->where('name', 'like', '%'.$request->search.'%');
                  });
            });
        }

        $transactions = $query->paginate(15);

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $categories = Category::where('user_id', Auth::id())
                        ->orderBy('type')
                        ->orderBy('name')
                        ->get();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'        => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'amount'      => 'required|numeric|min:1000',
            'date'        => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        // Cek apakah kategori milik user
        $category = Category::findOrFail($request->category_id);
        if ($category->user_id !== Auth::id() || $category->type !== $request->type) {
            return back()->with('error', 'Kategori tidak valid!');
        }

        Transaction::create([
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
            'amount'      => $request->amount,
            'date'        => $request->date,
            'description' => $request->description,
            'type'        => $request->type,
        ]);

        return redirect()->route('transactions.index')
               ->with('success', 'Transaksi berhasil dicatat!');
    }

    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) abort(403);

        $categories = Category::where('user_id', Auth::id())
                        ->where('type', $transaction->type)
                        ->orderBy('name')
                        ->get();

        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) abort(403);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount'      => 'required|numeric|min:1000',
            'date'        => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $transaction->update($request->only(['category_id', 'amount', 'date', 'description']));

        return redirect()->route('transactions.index')
               ->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) abort(403);

        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus!');
    }
}