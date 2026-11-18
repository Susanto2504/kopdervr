<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

        <div class="text-center mb-8">
            <img src="img/Cuplikan layar 2026-11-18 190923.png" alt="">
            <p class="text-sm text-gray-500 mt-2">
                Silakan masuk menggunakan akun admin terdaftar
            </p>
        </div>

        @if(session('error'))
            <div class="mb-5 rounded-lg bg-red-100 text-red-700 px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 rounded-lg bg-red-100 text-red-700 px-4 py-3 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kata Sandi
                </label>
                <input
                    type="password"
                    name="kata_sandi"
                    placeholder="Masukkan kata sandi"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >
            </div>

            <button
                type="submit"
                class="w-full rounded-lg bg-red-600 py-3 font-semibold text-white hover:bg-red-700 transition"
            >
                Login
            </button>
        </form>

    </div>

</body>
</html>
