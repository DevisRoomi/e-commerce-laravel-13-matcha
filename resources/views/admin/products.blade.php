<x-admin-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Katalog Produk</h1>
                <p class="text-sm text-gray-500">Kelola inventaris produk, stok, harga, dan varian</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.products.export') }}" class="bg-white hover:bg-matchaCream text-emerald-900 border border-emerald-200 px-4 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-file-excel text-emerald-700"></i> Ekspor Excel
                </a>
                <button type="button" onclick="printDiv('printableArea')" class="bg-white hover:bg-matchaCream text-emerald-900 border border-emerald-200 px-4 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-print"></i> Cetak / Print
                </button>
                <button type="button" id="bulk-delete-btn" class="hidden bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-trash"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                </button>
                <a href="{{ route('admin.product.add') }}" class="bg-primary hover:bg-secondary text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-plus"></i> Tambah Produk Baru
                </a>
            </div>
        </div>

        <!-- Alert Notification -->
        @if(Session::has('status'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ Session::get('status') }}</span>
            </div>
        @endif

        <!-- Filter & Search Bar (Video 22) -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-emerald-100">
            <form id="filter-form" action="{{ route('admin.products') }}" method="GET" class="flex flex-col lg:flex-row items-center justify-between gap-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 w-full lg:w-auto flex-1">
                    <!-- Search Input -->
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-emerald-700">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau SKU..."
                               onkeypress="if(event.key === 'Enter') this.form.submit();"
                               class="w-full pl-10 pr-4 py-2 bg-matchaCream border border-emerald-200 rounded-xl text-sm focus:outline-none focus:border-primary">
                    </div>

                    <!-- Category Select -->
                    <div>
                        <select name="category" onchange="this.form.submit()" class="w-full px-3 py-2 bg-matchaCream border border-emerald-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:border-primary">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Brand Select -->
                    <div>
                        <select name="brand" onchange="this.form.submit()" class="w-full px-3 py-2 bg-matchaCream border border-emerald-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:border-primary">
                            <option value="">Semua Merek</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Select -->
                    <div>
                        <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 bg-matchaCream border border-emerald-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:border-primary">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Tayang (Published)</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                </div>

                @if(request()->hasAny(['search', 'category', 'brand', 'status']))
                    <a href="{{ route('admin.products') }}" class="text-xs font-semibold text-red-600 hover:text-red-700 whitespace-nowrap flex items-center gap-1.5 px-3 py-2 rounded-xl bg-red-50 hover:bg-red-100 transition">
                        <i class="fa-solid fa-rotate-left"></i> Reset Filter
                    </a>
                @endif
            </form>
        </div>

        <!-- Products Table -->
        <form id="bulk-action-form" action="{{ route('admin.products.bulk.delete') }}" method="POST">
            @csrf
            @method('DELETE')
            <div id="printableArea" class="bg-white rounded-2xl shadow-sm border border-emerald-100 overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 min-w-[1050px]">
                    <thead class="bg-matchaLight/50 text-gray-700 text-xs uppercase font-bold border-b border-emerald-100">
                        <tr>
                            <th class="p-3 w-8 text-center">
                                <input type="checkbox" id="select-all" class="w-4 h-4 rounded text-primary focus:ring-primary border-gray-300 cursor-pointer">
                            </th>
                            <th class="p-3 w-10">ID</th>
                            <th class="p-3 min-w-[240px]">
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_order' => request('sort_by') === 'name' && request('sort_order') === 'asc' ? 'desc' : 'asc']) }}"
                                   class="flex items-center gap-1 hover:text-primary transition">
                                    <span>Produk</span>
                                    <i class="fa-solid {{ request('sort_by') === 'name' ? (request('sort_order') === 'asc' ? 'fa-sort-up text-primary' : 'fa-sort-down text-primary') : 'fa-sort text-gray-400' }} text-xs"></i>
                                </a>
                            </th>
                            <th class="p-3 whitespace-nowrap">SKU</th>
                            <th class="p-3 whitespace-nowrap">Kategori</th>
                            <th class="p-3 whitespace-nowrap">Merek</th>
                            <th class="p-3 whitespace-nowrap">
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'regular_price', 'sort_order' => request('sort_by') === 'regular_price' && request('sort_order') === 'asc' ? 'desc' : 'asc']) }}"
                                   class="flex items-center gap-1 hover:text-primary transition">
                                    <span>Harga</span>
                                    <i class="fa-solid {{ request('sort_by') === 'regular_price' ? (request('sort_order') === 'asc' ? 'fa-sort-up text-primary' : 'fa-sort-down text-primary') : 'fa-sort text-gray-400' }} text-xs"></i>
                                </a>
                            </th>
                            <th class="p-3 text-center whitespace-nowrap">
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'quantity', 'sort_order' => request('sort_by') === 'quantity' && request('sort_order') === 'asc' ? 'desc' : 'asc']) }}"
                                   class="flex items-center justify-center gap-1 hover:text-primary transition">
                                    <span>Stok</span>
                                    <i class="fa-solid {{ request('sort_by') === 'quantity' ? (request('sort_order') === 'asc' ? 'fa-sort-up text-primary' : 'fa-sort-down text-primary') : 'fa-sort text-gray-400' }} text-xs"></i>
                                </a>
                            </th>
                            <th class="p-3 text-center whitespace-nowrap">Status</th>
                            <th class="p-3 text-right whitespace-nowrap min-w-[90px]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($products as $product)
                            <tr class="hover:bg-matchaCream/50 transition">
                                <td class="p-3 text-center">
                                    <input type="checkbox" name="ids[]" value="{{ $product->id }}" class="product-checkbox w-4 h-4 rounded text-primary focus:ring-primary border-gray-300 cursor-pointer">
                                </td>
                                <td class="p-3 font-bold text-gray-700">#{{ $product->id }}</td>
                                <td class="p-3 min-w-[240px]">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-10 h-10 rounded-lg bg-gray-50 border border-gray-100 p-1 flex items-center justify-center overflow-hidden shrink-0">
                                            @if($product->image)
                                                <img src="{{ asset('uploads/products/thumbnails/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                                            @else
                                                <i class="fa-solid fa-box text-emerald-600 text-base"></i>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-gray-900 leading-snug text-xs sm:text-sm">{{ $product->name }}</p>
                                            @if($product->featured)
                                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded mt-0.5">
                                                    <i class="fa-solid fa-star text-[8px] text-amber-500"></i> Unggulan
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                    <td class="p-3 font-mono text-xs text-gray-500 whitespace-nowrap">{{ $product->SKU }}</td>
                                    <td class="p-3 text-xs font-semibold text-gray-700 whitespace-nowrap">
                                        {{ $product->category?->name ?? '—' }}
                                    </td>
                                    <td class="p-3 text-xs font-semibold text-gray-700 whitespace-nowrap">
                                        {{ $product->brand?->name ?? '—' }}
                                    </td>
                                    <td class="p-3 whitespace-nowrap">
                                        @if($product->sale_price)
                                            <div class="flex flex-col">
                                                <span class="font-bold text-emerald-800 text-xs">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                                <span class="text-[11px] text-gray-400 line-through">Rp {{ number_format($product->regular_price, 0, ',', '.') }}</span>
                                            </div>
                                        @else
                                            <span class="font-bold text-gray-800 text-xs">Rp {{ number_format($product->regular_price, 0, ',', '.') }}</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center whitespace-nowrap">
                                        @if($product->stock_status === 'instock')
                                            <span class="inline-block px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800">
                                                Tersedia ({{ $product->quantity }})
                                            </span>
                                        @else
                                            <span class="inline-block px-2 py-0.5 rounded-full text-[11px] font-semibold bg-red-100 text-red-700">
                                                Habis
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center whitespace-nowrap">
                                        @if($product->status)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Tayang
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-600">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}" class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-800 hover:bg-emerald-100 flex items-center justify-center transition" title="Edit">
                                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            </a>
                                            <form action="{{ route('admin.product.delete', ['id' => $product->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk {{ $product->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition" title="Hapus">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="px-6 py-12 text-center text-gray-400">
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
        </form>
    </div>

    <!-- Bulk Action JavaScript (Video 21) -->
    <script>
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.product-checkbox');
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
        const selectedCount = document.getElementById('selected-count');
        const bulkForm = document.getElementById('bulk-action-form');

        function updateBulkUI() {
            const checked = document.querySelectorAll('.product-checkbox:checked');
            const count = checked.length;
            if (selectedCount) selectedCount.innerText = count;
            if (count > 0) {
                bulkDeleteBtn.classList.remove('hidden');
                bulkDeleteBtn.classList.add('inline-flex');
            } else {
                bulkDeleteBtn.classList.add('hidden');
                bulkDeleteBtn.classList.remove('inline-flex');
                if (selectAll) selectAll.checked = false;
            }
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateBulkUI();
            });
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateBulkUI);
        });

        if (bulkDeleteBtn) {
            bulkDeleteBtn.addEventListener('click', function() {
                const count = document.querySelectorAll('.product-checkbox:checked').length;
                if (count > 0 && confirm(`Apakah Anda yakin ingin menghapus ${count} produk terpilih?`)) {
                    bulkForm.submit();
                }
            });
        }

        // Print Function (Video 23)
        function printDiv(divId) {
            const printContents = document.getElementById(divId).innerHTML;
            const originalContents = document.body.innerHTML;
            document.body.innerHTML = `
                <div style="padding: 24px; font-family: 'Plus Jakarta Sans', system-ui, sans-serif;">
                    <div style="margin-bottom: 20px; border-bottom: 2px solid #31522C; padding-bottom: 12px;">
                        <h2 style="font-size: 22px; font-weight: bold; color: #31522C; margin: 0;">🍵 MATCHA E-COMMERCE - DAFTAR PRODUK</h2>
                        <p style="font-size: 13px; color: #666; margin: 4px 0 0 0;">Laporan cetak data inventaris dan katalog barang toko</p>
                    </div>
                    ${printContents}
                </div>
            `;
            window.print();
            document.body.innerHTML = originalContents;
            window.location.reload();
        }
    </script>
</x-admin-layout>
