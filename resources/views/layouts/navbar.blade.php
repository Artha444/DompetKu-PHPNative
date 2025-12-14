<nav class="bg-white shadow-lg border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex space-x-8">
                <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-indigo-600">DompetKu</a>
                <a href="{{ route('transactions.index') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Transaksi</a>
                <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Kategori</a>
            
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-700">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-600 hover:text-red-800">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</nav>