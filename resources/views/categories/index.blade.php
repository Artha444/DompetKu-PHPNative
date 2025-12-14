<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori - DompetKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 min-h-screen">

@include('layouts.navbar')

<div class="max-w-5xl mx-auto px-4 py-8">

    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Kelola Kategori</h1>

        <!-- Form Tambah Kategori -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 rounded-2xl mb-8">
            <h2 class="text-white text-xl font-semibold mb-4">Tambah Kategori Baru</h2>
            <form action="{{ route('categories.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @csrf
                <input type="text" name="name" placeholder="Nama kategori" required
                       class="px-4 py-3 rounded-xl focus:ring-4 focus:ring-white/30">

                <select name="type" required class="px-4 py-3 rounded-xl">
                    <option value="income">Pemasukan</option>
                    <option value="expense" selected>Pengeluaran</option>
                </select>

                <input type="color" name="color" value="#ef4444" required
                       class="h-12 w-20 rounded-xl cursor-pointer">

                <button type="submit"
                        class="bg-white text-indigo-600 font-bold py-3 rounded-xl hover:bg-gray-100 transition">
                    + Tambah
                </button>
            </form>
        </div>

        <!-- Daftar Kategori -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pemasukan -->
            <div>
                <h3 class="text-lg font-bold text-green-600 mb-4 flex items-center">
                    <span class="w-4 h-4 bg-green-500 rounded-full mr-2"></span>
                    Kategori Pemasukan
                </h3>
                <div class="space-y-3">
                    @foreach($categories->where('type', 'income') as $cat)
                    <div class="flex items-center justify-between bg-green-50 p-4 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full" style="background-color: {{ $cat->color }}"></div>
                            <span class="font-medium">{{ $cat->name }}</span>
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="editCategory({{ $cat }})"
                                    class="text-blue-600 hover:text-blue-800">Edit</button>
                            <form method="POST" action="{{ route('categories.destroy', $cat) }}" class="inline">
                                @csrf @method('DELETE')
                                <button type="button" onclick="hapus({{ $cat->id }})"
                                        class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Pengeluaran -->
            <div>
                <h3 class="text-lg font-bold text-red-600 mb-4 flex items-center">
                    <span class="w-4 h-4 bg-red-500 rounded-full mr-2"></span>
                    Kategori Pengeluaran
                </h3>
                <div class="space-y-3">
                    @foreach($categories->where('type', 'expense') as $cat)
                    <div class="flex items-center justify-between bg-red-50 p-4 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full" style="background-color: {{ $cat->color }}"></div>
                            <span class="font-medium">{{ $cat->name }}</span>
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="editCategory({{ $cat }})"
                                    class="text-blue-600 hover:text-blue-800">Edit</button>
                            <form method="POST" action="{{ route('categories.destroy', $cat) }}" class="inline">
                                @csrf @method('DELETE')
                                <button type="button" onclick="hapus({{ $cat->id }})"
                                        class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        @if($categories->isEmpty())
        <div class="text-center py-12 text-gray-500">
            <p>Belum ada kategori. Tambah kategori pertama kamu di atas</p>
        </div>
        @endif
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 w-full max-w-md">
        <h3 class="text-2xl font-bold mb-6">Edit Kategori</h3>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="mb-4">
                <input type="text" name="name" id="editName" required
                       class="w-full px-4 py-3 border rounded-xl mb-4">
                <input type="color" name="color" id="editColor" required
                       class="h-12 w-full rounded-xl cursor-pointer">
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeEdit()" class="px-6 py-3 border rounded-xl">Batal</button>
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function editCategory(cat) {
    document.getElementById('editName').value = cat.name;
    document.getElementById('editColor').value = cat.color;
    document.getElementById('editForm').action = `/categories/${cat.id}`;
    document.getElementById('editModal').classList.remove('hidden');
}
function closeEdit() {
    document.getElementById('editModal').classList.add('hidden');
}
function hapus(id) {
    Swal.fire({
        title: 'Hapus kategori?',
        text: "Kategori yang masih punya transaksi tidak bisa dihapus",
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

@include('layouts.flash')

</body>
</html>