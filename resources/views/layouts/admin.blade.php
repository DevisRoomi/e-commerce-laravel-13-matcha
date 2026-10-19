<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>🌿 Admin Panel - Matcha E-Commerce</title>
    <link href="{{ asset('assets/images/favicon.ico') }}" rel="shortcut icon" type="image/x-icon" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#31522C',    /* Forest Green */
                        secondary: '#526531',  /* Basil Green */
                        sidebar: '#1E341B',    /* Dark Matcha */
                        sidebarActive: '#284624',
                        matchaLight: '#EEF3DF',
                        matchaCream: '#F6F9EF',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="bg-[#F4F7EE] font-sans antialiased text-gray-800">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-sidebar text-gray-100 transition-transform transform -translate-x-full md:translate-x-0 md:static md:inset-0 flex flex-col border-r border-[#284624]">
            <!-- Logo Brand -->
            <div class="flex items-center justify-between px-6 h-16 bg-[#162714] border-b border-[#284624]">
                <a href="{{ route('admin.index') }}" class="flex items-center gap-2 text-white font-bold text-lg tracking-wide">
                    <span>🍵 MATCHA ADMIN</span>
                </a>
                <button id="close-sidebar-btn" class="md:hidden text-gray-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto py-4 no-scrollbar">
                <nav class="px-3 space-y-1">
                    <a href="{{ route('admin.index') }}" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.index') ? 'bg-primary text-white shadow-md font-semibold' : 'text-emerald-100 hover:bg-sidebarActive hover:text-white' }}">
                        <i class="fa-solid fa-gauge-high w-5 text-center"></i>
                        <span>Dashboard</span>
                    </a>

                    <p class="px-4 text-[11px] font-bold text-emerald-400 uppercase tracking-wider mt-5 mb-2">Manajemen Toko</p>

                    <a href="{{ route('admin.products') }}" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.product*') ? 'bg-primary text-white shadow-md font-semibold' : 'text-emerald-100 hover:bg-sidebarActive hover:text-white' }}">
                        <i class="fa-solid fa-box w-5 text-center"></i>
                        <span>Produk</span>
                    </a>

                    <a href="{{ route('admin.categories') }}" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.categor*') ? 'bg-primary text-white shadow-md font-semibold' : 'text-emerald-100 hover:bg-sidebarActive hover:text-white' }}">
                        <i class="fa-solid fa-layer-group w-5 text-center"></i>
                        <span>Kategori</span>
                    </a>

                    <a href="{{ route('admin.brands') }}" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.brand*') ? 'bg-primary text-white shadow-md font-semibold' : 'text-emerald-100 hover:bg-sidebarActive hover:text-white' }}">
                        <i class="fa-solid fa-tag w-5 text-center"></i>
                        <span>Merek (Brands)</span>
                    </a>

                    <a href="#" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-emerald-100 hover:bg-sidebarActive hover:text-white transition">
                        <i class="fa-solid fa-ticket w-5 text-center"></i>
                        <span>Kupon & Promo</span>
                    </a>

                    <a href="#" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-emerald-100 hover:bg-sidebarActive hover:text-white transition">
                        <i class="fa-solid fa-cart-shopping w-5 text-center"></i>
                        <span>Pesanan (Orders)</span>
                    </a>

                    <a href="#" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-emerald-100 hover:bg-sidebarActive hover:text-white transition">
                        <i class="fa-solid fa-users w-5 text-center"></i>
                        <span>Pelanggan</span>
                    </a>

                    <p class="px-4 text-[11px] font-bold text-emerald-400 uppercase tracking-wider mt-5 mb-2">Pengaturan & Toko</p>

                    <a href="{{ route('home.index') }}" target="_blank" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-emerald-100 hover:bg-sidebarActive hover:text-white transition">
                        <i class="fa-solid fa-store w-5 text-center"></i>
                        <span>Lihat Toko Depan</span>
                    </a>

                    <a href="#" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-emerald-100 hover:bg-sidebarActive hover:text-white transition">
                        <i class="fa-solid fa-gear w-5 text-center"></i>
                        <span>Pengaturan Sistem</span>
                    </a>
                </nav>
            </div>

            <!-- Footer Sidebar: Logout -->
            <div class="p-4 border-t border-[#284624] bg-[#162714]">
                <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();"
                   class="flex items-center gap-3 w-full px-4 py-2.5 text-red-300 hover:text-red-100 hover:bg-red-900/30 rounded-xl font-medium transition">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                    <span>Keluar (Logout)</span>
                </a>
            </div>
        </aside>

        <!-- Sidebar Overlay Mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>

        <!-- Main Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <!-- Top Header -->
            <header class="bg-white border-b border-emerald-100 h-16 flex items-center justify-between px-6 z-30 shadow-sm">
                <button id="mobile-menu-btn" class="text-gray-600 focus:outline-none md:hidden">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>

                <div class="hidden md:flex items-center bg-[#F6F9EF] border border-emerald-200 rounded-xl px-3.5 py-1.5 w-96">
                    <i class="fa-solid fa-magnifying-glass text-emerald-700"></i>
                    <input type="text" placeholder="Cari data di panel admin..." class="bg-transparent border-none outline-none ml-2 text-sm w-full text-gray-700 placeholder-emerald-800/40">
                </div>

                <div class="flex items-center gap-5">
                    <a href="{{ route('home.index') }}" title="Kunjungi Toko" class="text-sm font-medium text-emerald-800 hover:text-emerald-950 flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 transition">
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                        <span>Ke Website</span>
                    </a>

                    <div class="h-6 w-px bg-gray-200"></div>

                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()?->name ?? 'Admin' }}</p>
                            <span class="inline-block text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">
                                Administrator
                            </span>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm shadow">
                            {{ substr(Auth::user()?->name ?? 'Admin', 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#F4F7EE] p-6">
                {{ $slot }}
            </main>

        </div>
    </div>

    <!-- Scripts -->
    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const closeSidebarBtn = document.getElementById('close-sidebar-btn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            const isClosed = sidebar.classList.contains('-translate-x-full');
            if (isClosed) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', toggleSidebar);
        if (closeSidebarBtn) closeSidebarBtn.addEventListener('click', toggleSidebar);
        if (overlay) overlay.addEventListener('click', toggleSidebar);
    </script>
</body>
</html>
