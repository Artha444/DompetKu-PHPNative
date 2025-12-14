<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - DompetKu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>

<body class="bg-gray-50 min-h-screen">

  <!-- Navbar -->
  <nav class="bg-white shadow-lg border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <h1 class="text-2xl font-bold text-indigo-600">DompetKu</h1>
        </div>
        <div class="flex items-center space-x-6">
          <span class="text-gray-700">Halo, <strong>{{ auth()->user()->name }}</strong></span>
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
              Keluar
            </button>
          </form>
        </div>
      </div>
    </div>
  </nav>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header Selamat Datang -->
    <div class="mb-8">
      <h2 class="text-3xl font-bold text-gray-800">Selamat datang kembali!</h2>
      <p class="text-gray-600 mt-1">{{ now()->translatedFormat('l, d F Y') }}</p>
    </div>

    <!-- Ringkasan Keuangan Bulan Ini -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-green-500 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-green-100 text-sm">Pemasukan Bulan Ini</p>
        <p class="text-3xl font-bold mt-2">Rp {{ number_format($income ?? 0, 0, ',', '.') }}</p>
      </div>

      <div class="bg-red-500 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-red-100 text-sm">Pengeluaran Bulan Ini</p>
        <p class="text-3xl font-bold mt-2">Rp {{ number_format($expense ?? 0, 0, ',', '.') }}</p>
      </div>

      <div class="@if(($income - $expense) >= 0) bg-blue-500 @else bg-orange-500 @endif text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm opacity-90">Saldo Bersih</p>
        <p class="text-3xl font-bold mt-2">
          Rp {{ number_format(($income ?? 0) - ($expense ?? 0), 0, ',', '.') }}
        </p>
        @if(($income - $expense) < 0)
          <p class="text-sm mt-2 opacity-90">Pengeluaran melebihi pemasukan!</p>
          @endif
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Grafik Pengeluaran per Kategori -->
      <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">
          Pengeluaran per Kategori - {{ now()->translatedFormat('F Y') }}
        </h3>
        <canvas id="expenseChart" height="300"></canvas>
      </div>

      <!-- Tombol Cepat -->
      <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">Aksi Cepat</h3>
        <div class="grid grid-cols-2 gap-4">
          <a href="{{ route('transactions.create') }}"
            class="bg-indigo-600 text-white text-center py-4 rounded-xl hover:bg-indigo-700 transition font-medium">
            + Catat Pemasukan
          </a>
          <a href="{{ route('transactions.create') }}"
            class="bg-red-600 text-white text-center py-4 rounded-xl hover:bg-red-700 transition font-medium">
            - Catat Pengeluaran
          </a>
          <a href="{{ route('categories.index') }}"
            class="bg-purple-600 text-white text-center py-4 rounded-xl hover:bg-purple-700 transition font-medium col-span-2">
            Kelola Kategori
          </a>
          
        </div>
      </div>
    </div>

    <!-- Transaksi Terakhir (Opsional nanti) -->
    <div class="mt-8 bg-white rounded-2xl shadow-lg p-6">
      <h3 class="text-xl font-semibold text-gray-800 mb-4">5 Transaksi Terakhir</h3>
      <div class="text-center text-gray-500 py-8">
        <p>Fitur ini akan muncul setelah kamu mencatat transaksi pertama</p>
        <a href="{{ route('transactions.create') }}" class="text-indigo-600 hover:underline">+ Tambah transaksi sekarang</a>
      </div>
    </div>
  </div>

  <script>
    // Chart Pengeluaran per Kategori
    const ctx = document.getElementById('expenseChart').getContext('2d');
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: [
          @foreach($expensesByCategory as $item)
          "{{ $item->name }}",
          @endforeach
        ],
        datasets: [{
          data: [
            @foreach($expensesByCategory as $item) {
              {
                $item - > total
              }
            },
            @endforeach
          ],
          backgroundColor: [
            @foreach($expensesByCategory as $item)
            "{{ $item->color }}",
            @endforeach
          ],
          borderWidth: 2,
          borderColor: '#fff'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              padding: 20,
              font: {
                size: 14
              }
            }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.label || '';
                if (label) label += ': ';
                label += 'Rp ' + context.parsed.toLocaleString('id-ID');
                return label;
              }
            }
          }
        }
      }
    });
  </script>

</body>

</html>