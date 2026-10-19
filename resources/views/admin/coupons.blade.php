<x-admin-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Kupon & Kode Promo</h1>
                <p class="text-sm text-gray-500">Kelola voucher diskon potongan belanja dan promosi toko</p>
            </div>
            <a href="{{ route('admin.coupon.add') }}" class="bg-primary hover:bg-secondary text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-plus"></i> Tambah Kupon Baru
            </a>
        </div>

        <!-- Alert Notification -->
        @if(Session::has('status'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ Session::get('status') }}</span>
            </div>
        @endif

        <!-- Coupons Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-matchaLight/50 text-gray-700 text-xs uppercase font-bold border-b border-emerald-100">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Kode Kupon</th>
                            <th class="px-6 py-4">Tipe</th>
                            <th class="px-6 py-4">Nilai Diskon</th>
                            <th class="px-6 py-4">Minimal Belanja</th>
                            <th class="px-6 py-4">Berlaku Hingga</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($coupons as $coupon)
                            <tr class="hover:bg-matchaCream/50 transition">
                                <td class="px-6 py-4 font-bold text-gray-700">#{{ $coupon->id }}</td>
                                <td class="px-6 py-4">
                                    <span class="font-mono font-bold text-emerald-900 bg-emerald-100/70 px-3 py-1 rounded-lg border border-emerald-200">
                                        {{ $coupon->code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($coupon->type === 'percent')
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-purple-700 bg-purple-50 px-2.5 py-1 rounded-full">
                                            <i class="fa-solid fa-percent text-[10px]"></i> Persentase
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full">
                                            <i class="fa-solid fa-money-bill text-[10px]"></i> Potongan Tetap
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    @if($coupon->type === 'percent')
                                        {{ $coupon->value }}%
                                    @else
                                        Rp {{ number_format($coupon->value, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    Rp {{ number_format($coupon->cart_value, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-medium {{ \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($coupon->expiry_date)) ? 'text-red-500 font-bold' : 'text-gray-600' }}">
                                        {{ \Carbon\Carbon::parse($coupon->expiry_date)->format('d M Y') }}
                                        @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($coupon->expiry_date)))
                                            <span class="text-[10px] bg-red-50 px-1.5 py-0.5 rounded text-red-600 ms-1">Kadaluarsa</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($coupon->status)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.coupon.edit', ['id' => $coupon->id]) }}" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-800 hover:bg-emerald-100 flex items-center justify-center transition" title="Edit">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.coupon.delete', ['id' => $coupon->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kupon {{ $coupon->code }}?');">
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
                                <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fa-solid fa-ticket text-3xl mb-2 text-gray-300"></i>
                                    <p class="font-medium">Belum ada kupon promo yang dibuat.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($coupons->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $coupons->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
