<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $month = Carbon::now()->month;
        $year  = Carbon::now()->year;

        // Total pemasukan & pengeluaran bulan ini
        $income = $user->transactions()
            ->where('type', 'income')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');

        $expense = $user->transactions()
            ->where('type', 'expense')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');

        // Chart: Pengeluaran per kategori (expense only)
        $expensesByCategory = $user->transactions()
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.type', 'expense')
            ->whereMonth('transactions.date', $month)
            ->whereYear('transactions.date', $year)
            ->selectRaw('categories.name, categories.color, SUM(transactions.amount) as total')
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->get();

        $saldo = $income - $expense;

        return view('dashboard', compact('income', 'expense', 'saldo', 'expensesByCategory'));
    }
}