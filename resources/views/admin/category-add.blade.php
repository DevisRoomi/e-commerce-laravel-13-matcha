<x-admin-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tambah Kategori Baru</h1>
                <p class="text-sm text-gray-500">Buat klasifikasi kategori atau subkategori produk</p>
            </div>
            <a href="{{ route('admin.categories') }}" class="px-4 py-2 rounded-xl text-sm font-semibold bg-gray-100 hover:bg-gray-200 text-gray-700 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-emerald-100">
            <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Category Name -->
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Nama Kategori *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           placeholder="Contoh: Ceremonial Matcha, Pakaian Muslimah"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category Slug -->
                <div>
                    <label for="slug" class="block text-sm font-bold text-gray-700 mb-1">Slug URL *</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}" required
                           placeholder="ceremonial-matcha"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 font-mono text-xs focus:outline-none focus:border-primary text-gray-600 @error('slug') border-red-500 @enderror">
                    @error('slug')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parent Category (Video 16: Subcategories) -->
                <div>
                    <label for="parent_id" class="block text-sm font-bold text-gray-700 mb-1">Kategori Induk (Parent Category)</label>
                    <select id="parent_id" name="parent_id" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary text-sm text-gray-700">
                        <option value="">— Tidak Ada (Jadikan Kategori Utama) —</option>
                        @foreach($parent_categories as $pcat)
                            <option value="{{ $pcat->id }}" {{ old('parent_id') == $pcat->id ? 'selected' : '' }}>
                                {{ $pcat->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika kategori ini berdiri sendiri sebagai kategori utama.</p>
                    @error('parent_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category Logo / Image -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Gambar / Ikon Kategori</label>
                    <div class="flex flex-col sm:flex-row items-center gap-6 p-4 rounded-xl border-2 border-dashed border-emerald-200 bg-matchaCream/30">
                        <div id="preview-container" class="w-24 h-24 rounded-xl bg-white border border-gray-200 p-2 flex items-center justify-center shrink-0 overflow-hidden shadow-sm">
                            <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-contain hidden">
                            <i id="preview-icon" class="fa-solid fa-image text-3xl text-emerald-300"></i>
                        </div>
                        <div class="flex-1 text-center sm:text-left">
                            <input type="file" id="image" name="image" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-secondary cursor-pointer">
                            <p class="text-xs text-gray-400 mt-2">Format: PNG, JPG, JPEG, WEBP. Maksimal ukuran 2MB.</p>
                        </div>
                    </div>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Checkbox -->
                <div class="pt-2">
                    <label class="inline-flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="status" value="1" {{ old('status', 1) ? 'checked' : '' }}
                               class="w-5 h-5 rounded text-primary focus:ring-primary border-gray-300">
                        <span class="text-sm font-bold text-gray-700">Aktifkan Kategori (Tampilkan di Menu Toko)</span>
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.categories') }}" class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 transition">
                        Batal
                    </a>
                    <button type="submit" class="bg-primary hover:bg-secondary text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md transition flex items-center gap-2">
                        <i class="fa-solid fa-check"></i> Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Live Auto Slug & Image Preview Script -->
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
