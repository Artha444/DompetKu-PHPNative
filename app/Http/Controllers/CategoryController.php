<?php
// app/Http/Controllers/CategoryController.php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())
                        ->orderBy('type')
                        ->orderBy('name')
                        ->get();

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:50',
            'type'  => 'required|in:income,expense',
            'color' => 'required|string|size:7', // #RRGGBB
        ]);

        Category::create([
            'user_id' => Auth::id(),
            'name'    => $request->name,
            'type'    => $request->type,
            'color'   => $request->color,
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, Category $category)
    {
        if ($category->user_id !== Auth::id()) abort(403);

        $request->validate([
            'name'  => 'required|string|max:50',
            'color' => 'required|string|size:7',
        ]);

        $category->update($request->only('name', 'color'));

        return back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        if ($category->user_id !== Auth::id()) abort(403);

        // Cek apakah masih ada transaksi
        if ($category->transactions()->exists()) {
            return back()->with('error', 'Tidak bisa hapus kategori yang masih punya transaksi!');
        }

        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}