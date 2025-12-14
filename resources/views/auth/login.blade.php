<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - DompetKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
    <h1 class="text-3xl font-bold text-center text-indigo-600 mb-8">DompetKu</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
                   required autofocus>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Password</label>
            <input type="password" name="password"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   required>
        </div>

        <div class="flex items-center mb-6">
            <input type="checkbox" name="remember" id="remember" class="mr-2">
            <label for="remember" class="text-gray-600">Ingat saya</label>
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition">
            Masuk
        </button>
    </form>

    <p class="text-center mt-6 text-gray-600">
        Belum punya akun?
        <a href="{{ url('/register') }}" class="text-indigo-600 hover:underline">Daftar di sini</a>
    </p>
</div>

</body>
</html>