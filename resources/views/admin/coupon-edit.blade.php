<x-admin-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Kupon: {{ $coupon->code }}</h1>
                <p class="text-sm text-gray-500">Perbarui nilai diskon, syarat belanja, atau masa aktif kupon</p>
            </div>
            <a href="{{ route('admin.coupons') }}" class="px-4 py-2 rounded-xl text-sm font-semibold bg-gray-100 hover:bg-gray-200 text-gray-700 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-emerald-100">
            <form action="{{ route('admin.coupon.update', ['id' => $coupon->id]) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Code & Type -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="code" class="block text-sm font-bold text-gray-700 mb-1">Kode Kupon *</label>
                        <input type="text" id="code" name="code" value="{{ old('code', $coupon->code) }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary text-sm font-mono uppercase @error('code') border-red-500 @enderror">
                        @error('code')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-bold text-gray-700 mb-1">Tipe Diskon *</label>
                        <select id="type" name="type" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary text-sm text-gray-700">
                            <option value="percent" {{ old('type', $coupon->type) === 'percent' ? 'selected' : '' }}>Persentase (%)</option>
                            <option value="fixed" {{ old('type', $coupon->type) === 'fixed' ? 'selected' : '' }}>Potongan Tetap (Nominal Rp)</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Value & Cart Value -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="value" class="block text-sm font-bold text-gray-700 mb-1">Nilai Potongan *</label>
                        <input type="number" step="0.01" id="value" name="value" value="{{ old('value', $coupon->value) }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary text-sm @error('value') border-red-500 @enderror">
                        @error('value')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cart_value" class="block text-sm font-bold text-gray-700 mb-1">Minimal Total Belanja (Rp) *</label>
                        <input type="number" step="0.01" id="cart_value" name="cart_value" value="{{ old('cart_value', $coupon->cart_value) }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary text-sm @error('cart_value') border-red-500 @enderror">
                        @error('cart_value')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Expiry Date -->
                <div>
                    <label for="expiry_date" class="block text-sm font-bold text-gray-700 mb-1">Tanggal Berakhir (Expiry Date) *</label>
                    <input type="date" id="expiry_date" name="expiry_date" value="{{ old('expiry_date', $coupon->expiry_date) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary text-sm @error('expiry_date') border-red-500 @enderror">
                    @error('expiry_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Checkbox -->
                <div class="pt-2">
                    <label class="inline-flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="status" value="1" {{ old('status', $coupon->status) ? 'checked' : '' }}
                               class="w-5 h-5 rounded text-primary focus:ring-primary border-gray-300">
                        <span class="text-sm font-bold text-gray-700">Aktifkan Kupon Ini (Dapat Digunakan Pembeli)</span>
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.coupons') }}" class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 transition">
                        Batal
                    </a>
                    <button type="submit" class="bg-primary hover:bg-secondary text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md transition flex items-center gap-2">
                        <i class="fa-solid fa-check"></i> Perbarui Kupon
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
