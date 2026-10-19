<x-app-layout>
  <main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb fs-12 p-2 px-3 rounded-3" style="background-color: #EEF3DF;">
          <li class="breadcrumb-item"><a href="{{ route('home.index') }}" class="text-secondary">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-secondary">Shop</a></li>
          <li class="breadcrumb-item active text-success fw-bold" aria-current="page">Keranjang Belanja</li>
        </ol>
      </nav>

      <h2 class="page-title fw-bold mb-4" style="color: var(--bs-primary);">Keranjang Belanja Anda</h2>

      <!-- Alert Notification -->
      @if(Session::has('status'))
        <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 fs-14 mb-4">
          <i class="fa-solid fa-circle-check"></i>
          <span>{{ Session::get('status') }}</span>
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger rounded-3 fs-14 mb-4">
          <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if($items->isEmpty())
        <!-- Empty Cart State -->
        <div class="p-5 text-center bg-white border rounded-3 shadow-sm my-4">
          <div class="w-20 h-20 mx-auto rounded-circle bg-light d-flex align-items-center justify-center mb-3" style="width: 80px; height: 80px;">
            <i class="fa-solid fa-cart-arrow-down fs-1 text-secondary"></i>
          </div>
          <h4 class="fw-bold text-dark mb-2">Keranjang Belanja Anda Masih Kosong</h4>
          <p class="text-secondary fs-14 mb-4">Belum ada varian matcha lezat yang Anda tambahkan ke keranjang.</p>
          <a href="{{ route('shop.index') }}" class="btn btn-primary px-4 py-2.5 fw-bold">
            <i class="fa-solid fa-store me-1"></i> Mulai Belanja Sekarang
          </a>
        </div>
      @else
        <!-- Cart Items Table & Summary -->
        <div class="row g-4 g-lg-5">
          <!-- Items List Column -->
          <div class="col-lg-8">
            <div class="border rounded-3 bg-white shadow-sm overflow-hidden mb-4">
              <div class="table-responsive">
                <table class="table align-middle mb-0">
                  <thead class="table-light fs-12 text-uppercase text-secondary">
                    <tr>
                      <th class="ps-4 py-3">Produk</th>
                      <th class="py-3">Harga</th>
                      <th class="py-3 text-center">Jumlah</th>
                      <th class="py-3 text-end">Subtotal</th>
                      <th class="pe-4 py-3 text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y fs-14">
                    @foreach($items as $item)
                      <tr>
                        <!-- Product Info -->
                        <td class="ps-4 py-3">
                          <div class="d-flex align-items-center gap-3">
                            <div class="w-16 h-16 rounded-2 border bg-light p-1 shrink-0" style="width: 60px; height: 60px;">
                              @if(!empty($item['options']['image']))
                                <img src="{{ asset('uploads/products/thumbnails/' . $item['options']['image']) }}" class="w-100 h-100 object-fit-contain">
                              @else
                                <img src="{{ asset('assets/images/home/demo3/product-4.jpg') }}" class="w-100 h-100 object-fit-contain">
                              @endif
                            </div>
                            <div>
                              <h6 class="fw-bold mb-0">
                                @if(!empty($item['options']['slug']))
                                  <a href="{{ route('shop.product.details', ['slug' => $item['options']['slug']]) }}" class="text-dark text-decoration-none hover:text-success">
                                    {{ $item['name'] }}
                                  </a>
                                @else
                                  <span class="text-dark">{{ $item['name'] }}</span>
                                @endif
                              </h6>
                            </div>
                          </div>
                        </td>

                        <!-- Price -->
                        <td class="py-3 fw-semibold text-secondary">
                          Rp {{ number_format($item['price'], 0, ',', '.') }}
                        </td>

                        <!-- Quantity Selector (Video 36) -->
                        <td class="py-3 text-center">
                          <div class="d-inline-flex align-items-center border rounded-2 bg-light">
                            <form action="{{ route('cart.qty.decrease', ['rowId' => $item['rowId']]) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="btn btn-sm px-2 text-dark border-0 fw-bold">-</button>
                            </form>
                            <span class="px-2 fw-bold fs-13">{{ $item['qty'] }}</span>
                            <form action="{{ route('cart.qty.increase', ['rowId' => $item['rowId']]) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="btn btn-sm px-2 text-dark border-0 fw-bold">+</button>
                            </form>
                          </div>
                        </td>

                        <!-- Subtotal -->
                        <td class="py-3 text-end fw-bold fs-15" style="color: #31522C !important;">
                          Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </td>

                        <!-- Remove Action (Video 37) -->
                        <td class="pe-4 py-3 text-center">
                          <form action="{{ route('cart.remove', ['rowId' => $item['rowId']]) }}" method="POST" onsubmit="return confirm('Hapus produk ini dari keranjang?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm px-2.5 py-1.5 rounded-2 shadow-sm font-bold" style="background-color: #fee2e2; color: #dc2626 !important; border: 1px solid #fca5a5 !important;" title="Hapus Item">
                              <i class="fa-solid fa-trash-can"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <!-- Cart Table Bottom Actions -->
              <div class="p-3 bg-light border-top d-flex flex-wrap justify-content-between align-items-center gap-3">
                <a href="{{ route('shop.index') }}" class="btn btn-sm btn-outline-secondary fw-semibold">
                  <i class="fa-solid fa-arrow-left me-1"></i> Lanjut Belanja
                </a>
                <form action="{{ route('cart.empty') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan seluruh keranjang belanja?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm px-3 py-1.5 rounded-2 fw-bold shadow-sm" style="background-color: #fee2e2; color: #dc2626 !important; border: 1px solid #fca5a5 !important;">
                    <i class="fa-solid fa-trash me-1"></i> Kosongkan Keranjang
                  </button>
                </form>
              </div>
            </div>
          </div>

          <!-- Order Summary Column -->
          <div class="col-lg-4">
            <div class="border rounded-3 bg-white p-4 shadow-sm">
              <h5 class="fw-bold mb-3 pb-2 border-bottom" style="color: var(--bs-primary);">Ringkasan Belanja</h5>

              <!-- Promo Coupon Box (Video 42 - 45) -->
              <div class="mb-4">
                <label class="fs-12 fw-bold text-secondary mb-1">Punya Kupon Promo?</label>
                @if($coupon)
                  <div class="p-3 rounded-3 d-flex justify-content-between align-items-center bg-white border border-2 shadow-sm" style="border-color: var(--bs-primary) !important;">
                    <div class="d-flex align-items-center gap-2">
                      <span class="badge font-monospace fs-12 px-2 py-1 text-white" style="background-color: var(--bs-primary) !important;">{{ $coupon['code'] }}</span>
                      <span class="fs-12 fw-bold text-dark">
                        -{{ $coupon['type'] === 'percent' ? (float)$coupon['value'] . '%' : 'Rp ' . number_format($coupon['value'], 0, ',', '.') }}
                      </span>
                    </div>
                    <form action="{{ route('cart.coupon.remove') }}" method="POST" class="m-0">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger py-0.5 px-2 text-danger fw-bold fs-11" title="Hapus Kupon">
                        <i class="fa-solid fa-xmark"></i> Batal
                      </button>
                    </form>
                  </div>
                @else
                  <form action="{{ route('cart.coupon.apply') }}" method="POST" class="input-group">
                    @csrf
                    <input type="text" name="coupon_code" placeholder="KODE PROMO" required class="form-control form-control-sm text-uppercase font-monospace">
                    <button type="submit" class="btn btn-sm btn-success fw-bold">Gunakan</button>
                  </form>
                @endif
              </div>

              <!-- Cost Breakdown -->
              <div class="d-flex flex-column gap-2.5 fs-14 border-bottom pb-3 mb-3 text-secondary">
                <div class="d-flex justify-content-between">
                  <span>Subtotal Produk</span>
                  <span class="fw-semibold text-dark">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>

                @if($discount > 0)
                  <div class="d-flex justify-content-between fw-bold" style="color: #b91c1c !important;">
                    <span>Diskon Kupon ({{ $coupon['code'] }})</span>
                    <span>- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                  </div>
                @endif

                <div class="d-flex justify-content-between">
                  <span>Pajak PPN (11%)</span>
                  <span class="fw-semibold text-dark">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                </div>

                <div class="d-flex justify-content-between">
                  <span>Biaya Pengiriman</span>
                  @if($shipping === 0)
                    <span class="text-success fw-bold">GRATIS ONGKIR</span>
                  @else
                    <span class="fw-semibold text-dark">Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                  @endif
                </div>
                @if($subtotal < 300000)
                  <small class="text-muted fs-11">Tambah belanja Rp {{ number_format(300000 - $subtotal, 0, ',', '.') }} lagi untuk Gratis Ongkir!</small>
                @endif
              </div>

              <!-- Grand Total -->
              <div class="d-flex justify-content-between align-items-baseline mb-4 py-2 border-top border-2 border-emerald-700">
                <span class="fw-bold text-dark fs-5">Total Tagihan</span>
                <span class="fw-extrabold fs-3" style="color: #31522C !important;">Rp {{ number_format($total, 0, ',', '.') }}</span>
              </div>

              <!-- Checkout Button -->
              <button type="button" class="btn btn-primary w-100 py-3 fw-bold text-uppercase shadow-sm d-flex align-items-center justify-content-center gap-2"
                      onclick="alert('Pesanan keranjang Anda tercatat siap diproses! Total tagihan: Rp {{ number_format($total, 0, ',', '.') }}');">
                <i class="fa-solid fa-lock"></i> Lanjut ke Checkout
              </button>

              <div class="text-center mt-3">
                <small class="text-muted fs-11">
                  <i class="fa-solid fa-shield-halved text-success"></i> Transaksi Aman & Terenkripsi
                </small>
              </div>
            </div>
          </div>
        </div>
      @endif
    </section>
  </main>
</x-app-layout>
