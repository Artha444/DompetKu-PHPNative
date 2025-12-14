@php
use App\Models\Category;
@endphp

<div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6">Catat Transaksi Baru</h2>
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block mb-2 font-medium">Tipe</label>
                <select name="type" id="type" onchange="gantiKategori()" class="w-full px-4 py-3 border rounded-xl" required>
                    <option value="">Pilih tipe...</option>
                    <option value="income">Pemasukan</option>
                    <option value="expense">Pengeluaran</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Kategori</label>
                <select name="category_id" id="categorySelect" class="w-full px-4 py-3 border rounded-xl" required disabled>
                    <option>Pilih tipe dulu...</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 font-medium">Jumlah</label>
                    <input type="number" name="amount" class="w-full px-4 py-3 border rounded-xl" required min="1000">
                </div>
                <div>
                    <label class="block mb-2 font-medium">Tanggal</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 border rounded-xl" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-medium">Keterangan (opsional)</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 border rounded-xl"></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="px-6 py-3 border rounded-xl">Batal</button>
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    
const categories = @json($categories ?? Category::where('user_id', auth()->id())->get());

function gantiKategori() {
    const type = document.getElementById('type').value;
    const select = document.getElementById('categorySelect');
    select.innerHTML = '<option>Pilih kategori...</option>';
    select.disabled = false;

    categories.filter(c => c.type === type).forEach(cat => {
        const opt = document.createElement('option');
        opt.value = cat.id;
        opt.textContent = cat.name;
        select.appendChild(opt);
    });
}
</script>