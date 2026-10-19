<x-admin-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Katalog Produk</h1>
                <p class="text-sm text-gray-500">Kelola inventaris produk, stok, harga, dan varian</p>
            </div>
            <a href="{{ route('admin.product.add') }}" class="bg-primary hover:bg-secondary text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-plus"></i> Tambah Produk Baru
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
            <form action="{{ route('admin.products') }}" method="GET" class="w-full md:w-80 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-emerald-700">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="name" value="{{ request('name') }}" placeholder="Cari nama produk..."
                       class="w-full pl-10 pr-4 py-2 bg-matchaCream border border-emerald-200 rounded-xl text-sm focus:outline-none focus:border-primary">
            </form>
            @if(request('name'))
                <a href="{{ route('admin.products') }}" class="text-xs font-semibold text-gray-500 hover:text-red-500">
                    <i class="fa-solid fa-xmark"></i> Reset Pencarian
                </a>
            @endif
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-matchaLight/50 text-gray-700 text-xs uppercase font-bold border-b border-emerald-100">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Produk</th>
                            <th class="px-6 py-4">SKU</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Merek</th>
                            <th class="px-6 py-4">Harga</th>
                            <th class="px-6 py-4 text-center">Stok</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($products as $product)
                            <tr class="hover:bg-matchaCream/50 transition">
                                <td class="px-6 py-4 font-bold text-gray-700">#{{ $product->id }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 p-1 flex items-center justify-center overflow-hidden shrink-0">
                                            @if($product->image)
                                                <img src="{{ asset('uploads/products/thumbnails/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                                            @else
                                                <i class="fa-solid fa-box text-emerald-600 text-lg"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $product->name }}</p>
                                            @if($product->featured)
                                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md mt-0.5">
                                                    <i class="fa-solid fa-star text-[9px] text-amber-500"></i> Unggulan
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-gray-500">{{ $product->SKU }}</td>
                                <td class="px-6 py-4 text-xs font-semibold text-gray-700">
                                    {{ $product->category?->name ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-xs font-semibold text-gray-700">
                                    {{ $product->brand?->name ?? '—' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($product->sale_price)
                                        <div class="flex flex-col">
                                            <span class="font-bold text-emerald-800">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                            <span class="text-xs text-gray-400 line-through">Rp {{ number_format($product->regular_price, 0, ',', '.') }}</span>
                                        </div>
                                    @else
                                        <span class="font-bold text-gray-800">Rp {{ number_format($product->regular_price, 0, ',', '.') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($product->stock_status === 'instock')
                                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            Tersedia ({{ $product->quantity }})
                                        </span>
                                    @else
                                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            Habis
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($product->status)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Tayang
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-800 hover:bg-emerald-100 flex items-center justify-center transition" title="Edit">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.product.delete', ['id' => $product->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk {{ $product->name }}?');">
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
                                <td colspan="9" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fa-solid fa-boxes-stacked text-3xl mb-2 text-gray-300"></i>
                                    <p class="font-medium">Belum ada produk di katalog.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
