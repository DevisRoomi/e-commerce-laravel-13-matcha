<x-admin-layout>
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tambah Produk Baru</h1>
                <p class="text-sm text-gray-500">Lengkapi informasi produk, harga, stok, dan galeri foto</p>
            </div>
            <a href="{{ route('admin.products') }}" class="px-4 py-2 rounded-xl text-sm font-semibold bg-gray-100 hover:bg-gray-200 text-gray-700 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-emerald-100">
            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Nama Produk *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               placeholder="Contoh: Premium Uji Ceremonial Matcha 100g"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary text-sm @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-bold text-gray-700 mb-1">Slug URL *</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug') }}" required
                               placeholder="premium-uji-ceremonial-matcha-100g"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 font-mono text-xs focus:outline-none focus:border-primary text-gray-600 @error('slug') border-red-500 @enderror">
                        @error('slug')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Category & Brand -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category_id" class="block text-sm font-bold text-gray-700 mb-1">Kategori Produk</label>
                        <select id="category_id" name="category_id" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary text-sm text-gray-700">
                            <option value="">— Pilih Kategori —</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="brand_id" class="block text-sm font-bold text-gray-700 mb-1">Merek (Brand)</label>
                        <select id="brand_id" name="brand_id" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary text-sm text-gray-700">
                            <option value="">— Pilih Merek —</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Descriptions -->
                <div>
                    <label for="short_description" class="block text-sm font-bold text-gray-700 mb-1">Deskripsi Singkat</label>
                    <textarea id="short_description" name="short_description" rows="2"
                              placeholder="Ringkasan poin keunggulan produk untuk preview kartu..."
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary text-sm">{{ old('short_description') }}</textarea>
                </div>

                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-1">Deskripsi Lengkap Produk</label>
                    <textarea id="description" name="description" rows="4"
                              placeholder="Penjelasan detail bahan, asal daerah, takaran seduh, atau spesifikasi pakaian..."
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary text-sm">{{ old('description') }}</textarea>
                </div>

                <!-- Pricing, SKU, Inventory -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="regular_price" class="block text-sm font-bold text-gray-700 mb-1">Harga Normal (Rp) *</label>
                        <input type="number" step="0.01" id="regular_price" name="regular_price" value="{{ old('regular_price') }}" required
                               placeholder="150000"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary text-sm @error('regular_price') border-red-500 @enderror">
                        @error('regular_price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sale_price" class="block text-sm font-bold text-gray-700 mb-1">Harga Diskon (Rp)</label>
                        <input type="number" step="0.01" id="sale_price" name="sale_price" value="{{ old('sale_price') }}"
                               placeholder="125000"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary text-sm @error('sale_price') border-red-500 @enderror">
                        @error('sale_price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="SKU" class="block text-sm font-bold text-gray-700 mb-1">Kode SKU *</label>
                        <input type="text" id="SKU" name="SKU" value="{{ old('SKU', 'MTC-' . rand(1000, 9999)) }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary font-mono text-xs @error('SKU') border-red-500 @enderror">
                        @error('SKU')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="quantity" class="block text-sm font-bold text-gray-700 mb-1">Jumlah Stok *</label>
                        <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 10) }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary text-sm @error('quantity') border-red-500 @enderror">
                        @error('quantity')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Stock Status & Flags -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-2 items-center">
                    <div>
                        <label for="stock_status" class="block text-sm font-bold text-gray-700 mb-1">Status Ketersediaan</label>
                        <select id="stock_status" name="stock_status" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary text-sm text-gray-700">
                            <option value="instock" {{ old('stock_status') === 'instock' ? 'selected' : '' }}>Tersedia (In Stock)</option>
                            <option value="outofstock" {{ old('stock_status') === 'outofstock' ? 'selected' : '' }}>Habis (Out of Stock)</option>
                        </select>
                    </div>

                    <div class="pt-5">
                        <label class="inline-flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}
                                   class="w-5 h-5 rounded text-primary focus:ring-primary border-gray-300">
                            <span class="text-sm font-bold text-gray-700">Produk Unggulan (Featured)</span>
                        </label>
                    </div>

                    <div class="pt-5">
                        <label class="inline-flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="status" value="1" {{ old('status', 1) ? 'checked' : '' }}
                                   class="w-5 h-5 rounded text-primary focus:ring-primary border-gray-300">
                            <span class="text-sm font-bold text-gray-700">Tayangkan Produk (Publish)</span>
                        </label>
                    </div>
                </div>

                <!-- Main Image Upload -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Foto Utama Produk *</label>
                    <div class="flex flex-col sm:flex-row items-center gap-6 p-4 rounded-xl border-2 border-dashed border-emerald-200 bg-matchaCream/30">
                        <div id="preview-container" class="w-24 h-24 rounded-xl bg-white border border-gray-200 p-2 flex items-center justify-center shrink-0 overflow-hidden shadow-sm">
                            <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-contain hidden">
                            <i id="preview-icon" class="fa-solid fa-box-open text-3xl text-emerald-300"></i>
                        </div>
                        <div class="flex-1 text-center sm:text-left">
                            <input type="file" id="image" name="image" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-secondary cursor-pointer">
                            <p class="text-xs text-gray-400 mt-2">Format: PNG, JPG, JPEG, WEBP. Maksimal 2MB.</p>
                        </div>
                    </div>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gallery Images Upload -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Galeri Foto Tambahan (Opsional)</label>
                    <div class="p-4 rounded-xl border-2 border-dashed border-emerald-200 bg-matchaCream/30">
                        <input type="file" id="images" name="images[]" multiple accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-secondary file:text-white hover:file:bg-primary cursor-pointer">
                        <p class="text-xs text-gray-400 mt-2">Dapat memilih lebih dari satu foto untuk galeri slider produk.</p>
                    </div>
                    @error('images.*')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.products') }}" class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 transition">
                        Batal
                    </a>
                    <button type="submit" class="bg-primary hover:bg-secondary text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md transition flex items-center gap-2">
                        <i class="fa-solid fa-check"></i> Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Live Auto Slug & Preview -->
    <script>
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const previewIcon = document.getElementById('preview-icon');

        nameInput.addEventListener('input', function() {
            slugInput.value = this.value
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
        });

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    previewIcon.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-admin-layout>
