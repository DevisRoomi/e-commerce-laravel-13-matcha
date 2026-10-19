<x-app-layout>
  <main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="product-single container">
      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb fs-12 p-2 px-3 rounded-3" style="background-color: #EEF3DF;">
          <li class="breadcrumb-item"><a href="{{ route('home.index') }}" class="text-secondary">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-secondary">Shop</a></li>
          <li class="breadcrumb-item active text-success fw-bold" aria-current="page">{{ $product->name }}</li>
        </ol>
      </nav>

      <!-- Main Product Details Grid -->
      <div class="row g-4 g-lg-5 mb-5">
        <!-- Product Images Gallery -->
        <div class="col-lg-6">
          <div class="product-gallery">
            <!-- Large Main Image -->
            <div class="main-image-container border rounded-3 p-3 bg-white shadow-sm mb-3 text-center overflow-hidden" style="max-height: 480px;">
              @if($product->image)
                <img id="main-product-img" src="{{ asset('uploads/products/' . $product->image) }}"
                     alt="{{ $product->name }}" class="w-100 h-auto object-fit-contain" style="max-height: 440px;">
              @else
                <img id="main-product-img" src="{{ asset('assets/images/home/demo3/product-4.jpg') }}"
                     alt="{{ $product->name }}" class="w-100 h-auto object-fit-contain" style="max-height: 440px;">
              @endif
            </div>

            <!-- Thumbnail Strip -->
            @php
              $gallery = $product->images ? explode(',', $product->images) : [];
            @endphp
            @if(count($gallery) > 0 || $product->image)
              <div class="d-flex flex-wrap gap-2">
                @if($product->image)
                  <div class="thumb-box border-2 rounded-2 p-1 cursor-pointer bg-white" style="width: 70px; height: 70px;"
                       onclick="document.getElementById('main-product-img').src = '{{ asset('uploads/products/' . $product->image) }}'">
                    <img src="{{ asset('uploads/products/thumbnails/' . $product->image) }}" class="w-100 h-100 object-fit-contain">
                  </div>
                @endif
                @foreach($gallery as $g_img)
                  <div class="thumb-box border rounded-2 p-1 cursor-pointer bg-white" style="width: 70px; height: 70px;"
                       onclick="document.getElementById('main-product-img').src = '{{ asset('uploads/products/' . $g_img) }}'">
                    <img src="{{ asset('uploads/products/thumbnails/' . $g_img) }}" class="w-100 h-100 object-fit-contain">
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        </div>

        <!-- Product Info & Purchasing -->
        <div class="col-lg-6">
          <div class="product-single__info d-flex flex-column gap-3">
            <div class="d-flex align-items-center gap-2">
              <span class="badge bg-success-subtle text-success fs-12 px-2.5 py-1 rounded-pill">
                {{ $product->category?->name ?? 'Matcha Series' }}
              </span>
              @if($product->brand)
                <span class="badge bg-light text-secondary fs-12 px-2.5 py-1 rounded-pill border">
                  {{ $product->brand->name }}
                </span>
              @endif
            </div>

            <h1 class="product-single__title fs-2 fw-bold text-dark m-0">{{ $product->name }}</h1>

            <!-- Pricing -->
            <div class="product-single__price d-flex align-items-baseline gap-3 my-1">
              @if($product->sale_price)
                <span class="fs-2 fw-bold text-success">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                <span class="fs-5 text-muted text-decoration-line-through">Rp {{ number_format($product->regular_price, 0, ',', '.') }}</span>
                <span class="badge bg-danger text-white fs-12">Hemat Rp {{ number_format($product->regular_price - $product->sale_price, 0, ',', '.') }}</span>
              @else
                <span class="fs-2 fw-bold text-dark">Rp {{ number_format($product->regular_price, 0, ',', '.') }}</span>
              @endif
            </div>

            <!-- Short Description -->
            @if($product->short_description)
              <p class="text-secondary fs-14 leading-relaxed mb-1">{{ $product->short_description }}</p>
            @endif

            <hr class="my-2 border-secondary-subtle">

            <!-- Meta: SKU & Stock -->
            <div class="row g-2 fs-13 text-secondary">
              <div class="col-6">
                <strong>SKU:</strong> <span class="font-monospace text-dark">{{ $product->SKU }}</span>
              </div>
              <div class="col-6">
                <strong>Status Stok:</strong>
                @if($product->stock_status === 'instock')
                  <span class="text-success fw-bold"><i class="fa-solid fa-circle-check"></i> Tersedia ({{ $product->quantity }})</span>
                @else
                  <span class="text-danger fw-bold"><i class="fa-solid fa-circle-xmark"></i> Stok Habis</span>
                @endif
              </div>
            </div>

            <!-- Purchasing Form (Video 34: Add to Cart) -->
            <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
              @csrf
              <input type="hidden" name="id" value="{{ $product->id }}">
              <input type="hidden" name="name" value="{{ $product->name }}">
              <input type="hidden" name="price" value="{{ $product->sale_price ?: $product->regular_price }}">

              <div class="d-flex flex-wrap gap-3 align-items-center mb-3">
                <!-- Quantity Selector -->
                <div class="input-group" style="width: 130px;">
                  <button type="button" class="btn btn-outline-secondary" onclick="const q = document.getElementById('qty-input'); if(q.value > 1) q.value--;">-</button>
                  <input type="number" id="qty-input" name="quantity" value="1" min="1" max="{{ $product->quantity }}" class="form-control text-center fw-bold">
                  <button type="button" class="btn btn-outline-secondary" onclick="const q = document.getElementById('qty-input'); q.value++;">+</button>
                </div>

                <!-- Add to Cart Button -->
                <button type="submit" class="btn btn-primary px-4 py-2.5 fw-bold d-flex align-items-center gap-2 shadow-sm flex-1"
                        {{ $product->stock_status === 'outofstock' ? 'disabled' : '' }}>
                  <i class="fa-solid fa-cart-shopping"></i> + Masukkan Keranjang
                </button>
              </div>
            </form>

            <!-- Wishlist Action (Video 38) -->
            <form action="{{ route('wishlist.add') }}" method="POST">
              @csrf
              <input type="hidden" name="id" value="{{ $product->id }}">
              <input type="hidden" name="name" value="{{ $product->name }}">
              <input type="hidden" name="quantity" value="1">
              <input type="hidden" name="price" value="{{ $product->sale_price ?: $product->regular_price }}">
              <button type="submit" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2">
                <i class="fa-regular fa-heart text-danger"></i> Tambah ke Wishlist Saya
              </button>
            </form>

            <!-- Store Guarantee Badge -->
            <div class="p-3 rounded-3 mt-2" style="background-color: #F6F9EF; border: 1px dashed var(--bs-secondary);">
              <div class="d-flex align-items-center gap-2 text-dark fs-13 fw-semibold">
                <i class="fa-solid fa-leaf text-success fs-5"></i>
                Jaminan Kualitas 100% Organik & Halal
              </div>
              <small class="text-secondary d-block mt-1">Dikemas higienis dengan standarisasi kesegaran daun teh matcha alami.</small>
            </div>
          </div>
        </div>
      </div>

      <!-- Description & Information Tabs -->
      <div class="product-single__details-tab mb-5">
        <ul class="nav nav-tabs border-bottom mb-4" id="productTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold text-dark px-4 py-3" id="description-tab" data-bs-toggle="tab"
                    data-bs-target="#description-tab-pane" type="button" role="tab">Deskripsi Produk</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold text-dark px-4 py-3" id="info-tab" data-bs-toggle="tab"
                    data-bs-target="#info-tab-pane" type="button" role="tab">Panduan & Spesifikasi</button>
          </li>
        </ul>
        <div class="tab-content p-4 bg-white border rounded-3 shadow-sm" id="productTabContent">
          <div class="tab-pane fade show active leading-relaxed text-secondary fs-15" id="description-tab-pane" role="tabpanel">
            {!! nl2br(e($product->description ?: 'Belum ada deskripsi lengkap untuk produk ini.')) !!}
          </div>
          <div class="tab-pane fade leading-relaxed text-secondary fs-15" id="info-tab-pane" role="tabpanel">
            <p><strong>Penyimpanan:</strong> Simpan di tempat sejuk dan kering, hindari paparan sinar matahari langsung.</p>
            <p><strong>Kadaluarsa:</strong> 12 bulan sejak tanggal produksi.</p>
            <p><strong>Pengiriman:</strong> Dilengkapi bubble wrap tebal dan box kardus khusus pengiriman barang pecah belah/organik.</p>
          </div>
        </div>
      </div>

      <!-- Related Products Carousel (Video 27) -->
      @if(count($related_products) > 0)
        <div class="related-products my-5">
          <h3 class="fw-bold mb-4" style="color: var(--bs-primary);">Produk Terkait Lainnya</h3>
          <div class="row row-cols-2 row-cols-md-4 g-3 g-md-4">
            @foreach($related_products as $r_prod)
              <div class="col">
                <div class="product-card h-100 p-2 rounded-3 border bg-white shadow-sm d-flex flex-column justify-content-between">
                  <div>
                    <a href="{{ route('shop.product.details', ['slug' => $r_prod->slug]) }}">
                      <img src="{{ asset('uploads/products/thumbnails/' . $r_prod->image) }}"
                           alt="{{ $r_prod->name }}" class="w-100 rounded-2 mb-2 object-fit-cover" style="aspect-ratio: 1/1;">
                    </a>
                    <h6 class="fs-13 fw-bold mb-1">
                      <a href="{{ route('shop.product.details', ['slug' => $r_prod->slug]) }}" class="text-dark text-decoration-none">
                        {{ $r_prod->name }}
                      </a>
                    </h6>
                  </div>
                  <div>
                    <span class="fw-bold fs-14 text-success d-block mb-2">
                      Rp {{ number_format($r_prod->sale_price ?: $r_prod->regular_price, 0, ',', '.') }}
                    </span>
                    <a href="{{ route('shop.product.details', ['slug' => $r_prod->slug]) }}" class="btn btn-outline-success btn-sm w-100 fw-bold">
                      Lihat Detail
                    </a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </section>
  </main>
</x-app-layout>
