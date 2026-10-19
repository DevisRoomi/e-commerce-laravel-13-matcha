<x-app-layout>
  <main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-wishlist container">
      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb fs-12 p-2 px-3 rounded-3" style="background-color: #EEF3DF;">
          <li class="breadcrumb-item"><a href="{{ route('home.index') }}" class="text-secondary">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-secondary">Shop</a></li>
          <li class="breadcrumb-item active text-success fw-bold" aria-current="page">Wishlist</li>
        </ol>
      </nav>

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title fw-bold m-0" style="color: var(--bs-primary);">Wishlist Saya (Daftar Keinginan)</h2>
        @if(!$items->isEmpty())
          <form action="{{ route('wishlist.empty') }}" method="POST" onsubmit="return confirm('Kosongkan semua item di wishlist?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger fw-semibold">
              <i class="fa-solid fa-trash me-1"></i> Kosongkan Wishlist
            </button>
          </form>
        @endif
      </div>

      <!-- Alert Notification -->
      @if(Session::has('status'))
        <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 fs-14 mb-4">
          <i class="fa-solid fa-circle-check"></i>
          <span>{{ Session::get('status') }}</span>
        </div>
      @endif

      @if($items->isEmpty())
        <!-- Empty Wishlist State -->
        <div class="p-5 text-center bg-white border rounded-3 shadow-sm my-4">
          <div class="w-20 h-20 mx-auto rounded-circle bg-light d-flex align-items-center justify-center mb-3" style="width: 80px; height: 80px;">
            <i class="fa-regular fa-heart fs-1 text-danger"></i>
          </div>
          <h4 class="fw-bold text-dark mb-2">Wishlist Anda Masih Kosong</h4>
          <p class="text-secondary fs-14 mb-4">Simpan produk matcha favorit Anda di sini agar mudah dibeli nanti.</p>
          <a href="{{ route('shop.index') }}" class="btn btn-primary px-4 py-2.5 fw-bold">
            <i class="fa-solid fa-store me-1"></i> Jelajahi Produk Sekarang
          </a>
        </div>
      @else
        <!-- Wishlist Items Table -->
        <div class="border rounded-3 bg-white shadow-sm overflow-hidden mb-5">
          <div class="table-responsive">
            <table class="table align-middle mb-0">
              <thead class="table-light fs-12 text-uppercase text-secondary">
                <tr>
                  <th class="ps-4 py-3">Produk</th>
                  <th class="py-3">Harga Satuan</th>
                  <th class="py-3 text-center">Pindahkan ke Keranjang</th>
                  <th class="pe-4 py-3 text-center">Hapus</th>
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
                    <td class="py-3 fw-bold text-success fs-15">
                      Rp {{ number_format($item['price'], 0, ',', '.') }}
                    </td>

                    <!-- Move to Cart Action (Video 41) -->
                    <td class="py-3 text-center">
                      <form action="{{ route('wishlist.move.to.cart', ['rowId' => $item['rowId']]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary fw-bold px-3 py-1.5 shadow-sm">
                          <i class="fa-solid fa-cart-shopping me-1"></i> Pindahkan ke Keranjang
                        </button>
                      </form>
                    </td>

                    <!-- Remove Action (Video 40) -->
                    <td class="pe-4 py-3 text-center">
                      <form action="{{ route('wishlist.remove', ['rowId' => $item['rowId']]) }}" method="POST" onsubmit="return confirm('Hapus produk ini dari wishlist?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm text-danger border-0 p-1" title="Hapus dari Wishlist">
                          <i class="fa-solid fa-trash-can fs-6"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @endif
    </section>
  </main>
</x-app-layout>
