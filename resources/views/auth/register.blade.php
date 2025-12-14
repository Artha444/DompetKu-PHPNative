<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - DompetKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-indigo-600">DompetKu</h1>
        <p class="text-gray-600 mt-2">Kelola keuangan pribadi & rumah tangga dengan mudah</p>
    </div>

    <form method="POST" action="{{ url('/register') }}">
        @csrf

        <!-- Nama -->
        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
                   placeholder="Masukkan nama kamu" required autofocus>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
                   placeholder="contoh@gmail.com" required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">Password</label>
            <input type="password" name="password"
                   class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-red-500 @enderror"
                   placeholder="Minimal 6 karakter" required>
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Konfirmasi Password -->
        <div class="mb-8">
            <label class="block text-gray-700 font-medium mb-2">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   placeholder="Ketik ulang password" required>
        </div>

        <!-- Tombol Daftar -->
        <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 rounded-xl hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-lg">
            Daftar Sekarang
        </button>
    </form>

    <p class="text-center mt-8 text-gray-600">
        Sudah punya akun?
        <a href="{{ url('/login') }}" class="text-indigo-600 font-semibold hover:underline">
            Masuk di sini
        </a>
    </p>
</div>

</body>
</html>