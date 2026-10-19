<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Matcha E-Commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-emerald-50 text-emerald-900 font-sans">
    <div class="min-h-screen flex flex-col items-center justify-center">
        <div class="bg-white p-8 rounded-2xl shadow-lg border border-emerald-200 text-center max-w-md w-full">
            <h1 class="text-3xl font-bold mb-2">🌿 Admin Dashboard</h1>
            <p class="text-gray-600 mb-6">Selamat datang, Admin! Anda berhasil masuk ke area khusus pengelola.</p>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-emerald-700 text-white py-2 rounded-xl font-semibold hover:bg-emerald-800 transition">
                    Logout
                </button>
            </form>
        </div>
    </div>
</body>
</html>
