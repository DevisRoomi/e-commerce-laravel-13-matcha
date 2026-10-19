<x-admin-layout>
    <div class="space-y-6">
        <!-- Top Banner -->
        <div class="bg-gradient-to-r from-primary to-secondary text-white p-6 rounded-2xl shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">🍵 Selamat Datang, {{ Auth::user()->name }}!</h1>
                <p class="text-emerald-100 text-sm mt-1">Panel administrasi e-commerce matcha terpadu. Pantau performa toko dari sini.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-white/15 backdrop-blur-sm text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                    Sistem Aktif
                </span>
            </div>
        </div>

        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Card 1: Total Orders -->
            <div class="bg-white p-5 rounded-2xl border border-emerald-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Pesanan</p>
                    <h3 class="text-2xl font-extrabold text-primary mt-1">0</h3>
                    <p class="text-xs text-emerald-600 mt-1 font-medium"><i class="fa-solid fa-arrow-trend-up"></i> Baru mulai</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-matchaLight text-primary flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
            </div>

            <!-- Card 2: Total Revenue -->
            <div class="bg-white p-5 rounded-2xl border border-emerald-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Pendapatan</p>
                    <h3 class="text-2xl font-extrabold text-primary mt-1">Rp 0</h3>
                    <p class="text-xs text-emerald-600 mt-1 font-medium"><i class="fa-solid fa-chart-line"></i> Toko online siap</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-matchaLight text-primary flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-rupiah-sign"></i>
                </div>
            </div>

            <!-- Card 3: Total Products -->
            <div class="bg-white p-5 rounded-2xl border border-emerald-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Produk</p>
                    <h3 class="text-2xl font-extrabold text-primary mt-1">8</h3>
                    <p class="text-xs text-emerald-600 mt-1 font-medium">Koleksi Matcha</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-matchaLight text-primary flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
            </div>

            <!-- Card 4: Customers -->
            <div class="bg-white p-5 rounded-2xl border border-emerald-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan</p>
                    <h3 class="text-2xl font-extrabold text-primary mt-1">1</h3>
                    <p class="text-xs text-emerald-600 mt-1 font-medium">User terdaftar</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-matchaLight text-primary flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-user-group"></i>
                </div>
            </div>
        </div>

        <!-- Recent Activity / Guidance Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-emerald-100 shadow-sm">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                        <i class="fa-solid fa-bolt text-secondary"></i>
                        Aksi Cepat Pengelolaan
                    </h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-4 rounded-xl bg-matchaCream border border-emerald-100 text-center hover:shadow-md transition">
                        <div class="w-10 h-10 mx-auto rounded-xl bg-primary text-white flex items-center justify-center mb-2">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <h4 class="font-bold text-sm text-gray-800">Tambah Produk</h4>
                        <p class="text-xs text-gray-500 mt-1">Video 17 - 18</p>
                    </div>

                    <div class="p-4 rounded-xl bg-matchaCream border border-emerald-100 text-center hover:shadow-md transition">
                        <div class="w-10 h-10 mx-auto rounded-xl bg-primary text-white flex items-center justify-center mb-2">
                            <i class="fa-solid fa-tags"></i>
                        </div>
                        <h4 class="font-bold text-sm text-gray-800">Kelola Merek</h4>
                        <p class="text-xs text-gray-500 mt-1">Video 07 - 11</p>
                    </div>

                    <div class="p-4 rounded-xl bg-matchaCream border border-emerald-100 text-center hover:shadow-md transition">
                        <div class="w-10 h-10 mx-auto rounded-xl bg-primary text-white flex items-center justify-center mb-2">
                            <i class="fa-solid fa-folder-tree"></i>
                        </div>
                        <h4 class="font-bold text-sm text-gray-800">Kelola Kategori</h4>
                        <p class="text-xs text-gray-500 mt-1">Video 12 - 16</p>
                    </div>
                </div>
            </div>

            <!-- Store Status Box -->
            <div class="bg-white p-6 rounded-2xl border border-emerald-100 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        Status Aplikasi
                    </h3>
                    <ul class="text-sm space-y-2.5 text-gray-600 mt-4">
                        <li class="flex items-center justify-between">
                            <span>Framework:</span>
                            <strong class="text-emerald-800">Laravel 13</strong>
                        </li>
                        <li class="flex items-center justify-between">
                            <span>Database:</span>
                            <strong class="text-emerald-800">MySQL (FlyEnv)</strong>
                        </li>
                        <li class="flex items-center justify-between">
                            <span>Tema Desain:</span>
                            <strong class="text-emerald-800">Matcha Green Palette</strong>
                        </li>
                        <li class="flex items-center justify-between">
                            <span>Katalog Model:</span>
                            <strong class="text-emerald-800">Muslimah / Modest</strong>
                        </li>
                    </ul>
                </div>
                <div class="pt-4 border-t border-gray-100 mt-4">
                    <a href="{{ route('home.index') }}" target="_blank" class="block w-full py-2.5 bg-primary hover:bg-secondary text-white text-center rounded-xl font-bold text-xs uppercase tracking-wider transition">
                        Buka Halaman Utama Toko
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
