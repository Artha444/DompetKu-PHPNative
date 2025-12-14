<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi - DompetKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

@include('layouts.navbar')

<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">
            Catat Transaksi Baru
        </h1>

        <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Tipe Transaksi -->
            <div>
                <label class="block text-lg font-medium text-gray-700 mb-3">Tipe Transaksi</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center p-4 border-2 rounded-xl cursor-pointer has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                        <input type="radio" name="type" value="income" class="mr-3 w-5 h-5 text-green-600" required onchange="filterCategories()">
                        <span class="text-lg font-medium">Pemasukan</span>
                    </label>
                    <label class="flex items-center p-4 border-2 rounded-xl cursor-pointer has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                        <input type="radio" name="type" value="expense" class="mr-3 w-5 h-5 text-red-600" required onchange="filterCategories()">
                        <span class="text-lg font-medium">Pengeluaran</span>
                    </label>
                </div>
            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-lg font-medium text-gray-700 mb-3">Kategori</label>
                <select name="category_id" id="categorySelect" required
                        class="w-full px-5 py-4 border-2 rounded-xl focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 text-lg">
                    <option value="">Pilih tipe transaksi dulu...</option>
                </select>
            </div>

            <!-- Jumlah & Tanggal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-lg font-medium text-gray-700 mb-3">Jumlah (Rp)</label>
                    <input type="number" name="amount" min="1000" required placeholder="50000"
                           class="w-full px-5 py-4 border-2 rounded-xl focus:ring-4 focus:ring-indigo-300 text-lg">
                </div>
                <div>
                    <label class="block text-lg font-medium text-gray-700 mb-3">Tanggal</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" required
                           class="w-full px-5 py-4 border-2 rounded-xl focus:ring-4 focus:ring-indigo-300 text-lg">
                </div>
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-lg font-medium text-gray-700 mb-3">Keterangan (opsional)</label>
                <textarea name="description" rows="4" placeholder="Contoh: Gaji bulan Desember"
                          class="w-full px-5 py-4 border-2 rounded-xl focus:ring-4 focus:ring-indigo-300 text-lg"></textarea>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end gap-4 pt-6">
                <a href="{{ route('transactions.index') }}"
                   class="px-8 py-4 border-2 border-gray-300 rounded-xl hover:bg-gray-50 font-medium text-lg">
                    Batal
                </a>
                <button type="submit"
                        class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 font-bold text-lg shadow-lg">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const categories = @json($categories);

function filterCategories() {
    const type = document.querySelector('input[name="type"]:checked')?.value;
    const select = document.getElementById('categorySelect');
    
    select.innerHTML = '<option value="">Pilih kategori...</option>';
    
    if (!type) return;

    categories
        .filter(cat => cat.type === type)
        .forEach(cat => {
            const opt = document.createElement('option');
            opt.value = cat.id;
            opt.textContent = cat.name;
            opt.style.color = '#1f2937';
            select.appendChild(opt);
        });
}

// Jalankan saat halaman dibuka (jika ada kategori default)
document.addEventListener('DOMContentLoaded', filterCategories);
</script>

</body>
</html>