<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>Transaksi - DompetKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 min-h-screen">

@include('layouts.navbar')

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Transaksi</h1>
            <button onclick="openModal()" class="bg-indigo-600 text-white px-6 py-3 rounded-xl hover:bg-indigo-700 transition">
                + Transaksi Baru
            </button>
        </div>

        <!-- Form Pencarian -->
        <form method="GET" class="mb-6">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari transaksi..."
                   class="w-full md:w-96 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-indigo-500">
        </form>

        <!-- Tabel -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3 text-right">Jumlah</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-4">{{ $t->date->format('d/m/Y') }}</td>
                        <td class="px-4 py-4">
                            <span class="px-3 py-1 rounded-full text-white text-sm"
                                  style="background-color: {{ $t->category->color }}">
                                {{ $t->category->name }}
                            </span>
                        </td>
                        <td class="px-4 py-4">{{ $t->description ?? '-' }}</td>
                        <td class="px-4 py-4 text-right font-semibold
                            {{ $t->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $t->type == 'income' ? '+' : '-' }}Rp {{ number_format($t->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-4">
                            <a href="{{ route('transactions.edit', $t) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                            <form method="POST" action="{{ route('transactions.destroy', $t) }}" class="inline">
                                @csrf @method('DELETE')
                                <button type="button" onclick="hapus({{ $t->id }})" class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-12 text-gray-500">
                            Belum ada transaksi. <a href="{{ route('transactions.create') }}" class="text-indigo-600">Catat sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $transactions->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@include('transactions.modal-create')

<script>
function openModal() {
    document.getElementById('modal').classList.remove('hidden');
}
function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}
function hapus(id) {
    Swal.fire({
        title: 'Yakin hapus transaksi?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.querySelector(`form[action*="${id}"]`).submit();
        }
    });
}
</script>
</body>
</html>