<x-admin-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Merek / Brands</h1>
                <p class="text-sm text-gray-500">Kelola daftar merek, partner, dan produsen produk</p>
            </div>
            <a href="{{ route('admin.brand.add') }}" class="bg-primary hover:bg-secondary text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-plus"></i> Tambah Merek Baru
            </a>
        </div>

        <!-- Alert Notification -->
        @if(Session::has('status'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ Session::get('status') }}</span>
            </div>
        @endif

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-emerald-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <form action="{{ route('admin.brands') }}" method="GET" class="w-full md:w-80 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-emerald-700">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="name" value="{{ request('name') }}" placeholder="Cari nama merek..."
                       class="w-full pl-10 pr-4 py-2 bg-matchaCream border border-emerald-200 rounded-xl text-sm focus:outline-none focus:border-primary">
            </form>
            @if(request('name'))
                <a href="{{ route('admin.brands') }}" class="text-xs font-semibold text-gray-500 hover:text-red-500">
                    <i class="fa-solid fa-xmark"></i> Reset Pencarian
                </a>
            @endif
        </div>

        <!-- Brands Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-matchaLight/50 text-gray-700 text-xs uppercase font-bold border-b border-emerald-100">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Merek</th>
                            <th class="px-6 py-4">Slug</th>
                            <th class="px-6 py-4 text-center">Produk</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($brands as $brand)
                            <tr class="hover:bg-matchaCream/50 transition">
                                <td class="px-6 py-4 font-bold text-gray-700">#{{ $brand->id }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 p-1 flex items-center justify-center overflow-hidden shrink-0">
                                            @if($brand->image)
                                                <img src="{{ asset('uploads/brands/thumbnails/' . $brand->image) }}" alt="{{ $brand->name }}" class="w-full h-full object-contain">
                                            @else
                                                <i class="fa-solid fa-tag text-emerald-600 text-lg"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $brand->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-gray-500">{{ $brand->slug }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                        0
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($brand->status)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.brand.edit', ['id' => $brand->id]) }}" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-800 hover:bg-emerald-100 flex items-center justify-center transition" title="Edit">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.brand.delete', ['id' => $brand->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus merek {{ $brand->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition" title="Hapus">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fa-solid fa-tag text-3xl mb-2 text-gray-300"></i>
                                    <p class="font-medium">Belum ada merek / brand terdaftar.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($brands->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $brands->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
