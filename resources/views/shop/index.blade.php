<x-app-layout>
  <main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-main container d-flex flex-column gap-4">
      <!-- Breadcrumb & Title Banner -->
      <div class="d-flex justify-content-between align-items-center py-4 px-4 rounded-3 shadow-sm" style="background-color: #EEF3DF; border-left: 5px solid var(--bs-primary);">
        <div>
          <h2 class="page-title fw-bold m-0" style="color: var(--bs-primary);">Katalog Produk Matcha</h2>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 fs-12 mt-1">
              <li class="breadcrumb-item"><a href="{{ route('home.index') }}" class="text-secondary">Home</a></li>
              <li class="breadcrumb-item active text-success fw-bold" aria-current="page">Shop</li>
            </ol>
          </nav>
        </div>
        <div class="text-end text-secondary fs-13 d-none d-sm-block">
          Total Koleksi: <strong>{{ $products->total() }}</strong> Produk
        </div>
      </div>

      <div class="row g-4">
        <!-- Sidebar Filters (Video 29, 30, 31, 32) -->
        <aside class="col-lg-3">
          <form id="shop-filter-form" action="{{ route('shop.index') }}" method="GET" class="d-flex flex-column gap-4">
            <!-- Search Widget (Video 32) -->
            <div class="p-3 bg-white border rounded-3 shadow-sm">
              <h6 class="fw-bold mb-3 text-dark d-flex align-items-center gap-2">
                <i class="fa-solid fa-magnifying-glass text-success"></i> Cari Produk
              </h6>
              <div class="position-relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Ketik nama atau kata kunci..."
                       class="form-control form-control-sm pr-4" style="border-radius: 8px;">
              </div>
            </div>

            <!-- Categories Filter (Video 30) -->
            <div class="p-3 bg-white border rounded-3 shadow-sm">
              <h6 class="fw-bold mb-3 text-dark d-flex align-items-center gap-2">
                <i class="fa-solid fa-layer-group text-success"></i> Kategori
              </h6>
              <div class="d-flex flex-column gap-2.5" style="max-height: 300px; overflow-y: auto;">
                @foreach($categories as $cat)
                  @php
                    $total_cat_count = $cat->products_count + $cat->subcategories->sum('products_count');
                    $is_cat_checked = in_array($cat->id, is_array($f_categories) ? $f_categories : explode(',', $f_categories));
                  @endphp
                  <div>
                    <label class="form-check-label d-flex justify-content-between align-items-center cursor-pointer fs-13 fw-bold text-dark mb-1">
                      <span class="d-flex align-items-center gap-2">
                        <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                               {{ $is_cat_checked ? 'checked' : '' }}
                               class="form-check-input mt-0" onchange="document.getElementById('shop-filter-form').submit();">
                        {{ $cat->name }}
                      </span>
                      <span class="badge bg-light text-dark rounded-pill">{{ $total_cat_count }}</span>
                    </label>

                    @if($cat->subcategories->isNotEmpty())
                      <div class="d-flex flex-column gap-1 ps-3 pt-1 border-start ms-2">
                        @foreach($cat->subcategories as $sub)
                          @php
                            $is_sub_checked = in_array($sub->id, is_array($f_categories) ? $f_categories : explode(',', $f_categories));
                          @endphp
                          <label class="form-check-label d-flex justify-content-between align-items-center cursor-pointer fs-12 text-secondary">
                            <span class="d-flex align-items-center gap-2">
                              <input type="checkbox" name="categories[]" value="{{ $sub->id }}"
                                     {{ $is_sub_checked ? 'checked' : '' }}
                                     class="form-check-input mt-0" onchange="document.getElementById('shop-filter-form').submit();">
                              {{ $sub->name }}
                            </span>
                            <span class="badge bg-light text-secondary rounded-pill fs-11">{{ $sub->products_count }}</span>
                          </label>
                        @endforeach
                      </div>
                    @endif
                  </div>
                @endforeach
              </div>
            </div>

            <!-- Brands Filter (Video 29) -->
            <div class="p-3 bg-white border rounded-3 shadow-sm">
              <h6 class="fw-bold mb-3 text-dark d-flex align-items-center gap-2">
                <i class="fa-solid fa-tag text-success"></i> Merek / Brand
              </h6>
              <div class="d-flex flex-column gap-2" style="max-height: 220px; overflow-y: auto;">
                @foreach($brands as $b)
                  <label class="form-check-label d-flex justify-content-between align-items-center cursor-pointer fs-13">
                    <span class="d-flex align-items-center gap-2">
                      <input type="checkbox" name="brands[]" value="{{ $b->id }}"
                             {{ in_array($b->id, is_array($f_brands) ? $f_brands : explode(',', $f_brands)) ? 'checked' : '' }}
                             class="form-check-input mt-0" onchange="document.getElementById('shop-filter-form').submit();">
                      {{ $b->name }}
                    </span>
                    <span class="badge bg-light text-secondary rounded-pill">{{ $b->products_count }}</span>
                  </label>
                @endforeach
              </div>
            </div>

            <!-- Price Filter (Video 31) -->
            <div class="p-3 bg-white border rounded-3 shadow-sm">
              <h6 class="fw-bold mb-3 text-dark d-flex align-items-center gap-2">
                <i class="fa-solid fa-rupiah-sign text-success"></i> Rentang Harga
              </h6>
              <div class="row g-2 mb-3">
                <div class="col-6">
                  <label class="fs-11 text-muted">Min (Rp)</label>
                  <input type="number" name="min_price" value="{{ $min_price }}" class="form-control form-control-sm">
                </div>
                <div class="col-6">
                  <label class="fs-11 text-muted">Max (Rp)</label>
                  <input type="number" name="max_price" value="{{ $max_price }}" class="form-control form-control-sm">
                </div>
              </div>
              <button type="submit" class="btn btn-sm btn-outline-success w-100 fw-bold">Terapkan Harga</button>
            </div>

            <!-- Hidden inputs to preserve sorting and pagination size -->
            <input type="hidden" name="order" value="{{ $order }}">
            <input type="hidden" name="page_size" value="{{ $page_size }}">

            @if(!empty($search) || !empty($f_brands) || !empty($f_categories) || request()->has('min_price'))
              <a href="{{ route('shop.index') }}" class="btn btn-sm btn-light text-danger border w-100 fw-semibold text-center">
                <i class="fa-solid fa-rotate-left"></i> Reset Semua Filter
              </a>
            @endif
          </form>
        </aside>

        <!-- Product Grid Area (Video 26, 28) -->
        <div class="col-lg-9">
          <!-- Top Sort & Display Controls (Video 28) -->
          <div class="d-flex flex-wrap justify-content-between align-items-center p-3 bg-white border rounded-3 shadow-sm mb-4 gap-3">
            <span class="fs-13 text-secondary">
              Menampilkan <strong>{{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }}</strong> dari {{ $products->total() }} produk
            </span>

            <div class="d-flex align-items-center gap-3">
              <!-- Sort By Dropdown -->
              <div class="d-flex align-items-center gap-2">
                <label class="fs-12 text-secondary m-0 whitespace-nowrap">Urutan:</label>
                <select name="order" class="form-select form-select-sm" style="width: auto;"
                        onchange="const f = document.getElementById('shop-filter-form'); f.order.value = this.value; f.submit();">
                  <option value="-1" {{ $order == -1 ? 'selected' : '' }}>Terbaru (Default)</option>
                  <option value="1" {{ $order == 1 ? 'selected' : '' }}>Tanggal Terbaru</option>
                  <option value="2" {{ $order == 2 ? 'selected' : '' }}>Tanggal Terlama</option>
                  <option value="3" {{ $order == 3 ? 'selected' : '' }}>Harga Terendah</option>
                  <option value="4" {{ $order == 4 ? 'selected' : '' }}>Harga Tertinggi</option>
                </select>
              </div>

              <!-- Page Size Dropdown -->
              <div class="d-flex align-items-center gap-2">
                <label class="fs-12 text-secondary m-0 whitespace-nowrap">Tampil:</label>
                <select name="page_size" class="form-select form-select-sm" style="width: auto;"
                        onchange="const f = document.getElementById('shop-filter-form'); f.page_size.value = this.value; f.submit();">
                  <option value="12" {{ $page_size == 12 ? 'selected' : '' }}>12</option>
                  <option value="24" {{ $page_size == 24 ? 'selected' : '' }}>24</option>
                  <option value="48" {{ $page_size == 48 ? 'selected' : '' }}>48</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Product Card Grid -->
          <div class="row row-cols-2 row-cols-md-3 g-3 g-md-4">
            @forelse($products as $product)
              <div class="col">
                <div class="product-card h-100 position-relative d-flex flex-column justify-content-between p-2 rounded-3 border bg-white shadow-sm transition hover:shadow-md">
                  <div>
                    <!-- Product Image -->
                    <div class="position-relative overflow-hidden rounded-2 mb-2 bg-light text-center" style="aspect-ratio: 1/1;">
                      <a href="{{ route('shop.product.details', ['slug' => $product->slug]) }}">
                        @if($product->image)
                          <img src="{{ asset('uploads/products/thumbnails/' . $product->image) }}"
                               alt="{{ $product->name }}" class="w-100 h-100 object-fit-cover">
                        @else
                          <img src="{{ asset('assets/images/home/demo3/product-4.jpg') }}"
                               alt="{{ $product->name }}" class="w-100 h-100 object-fit-cover">
                        @endif
                      </a>

                      <!-- Discount / Sale Badge -->
                      @if($product->sale_price)
                        <span class="position-absolute top-0 start-0 m-2 badge bg-danger text-white fs-11">
                          SALE
                        </span>
                      @endif

                      <!-- Quick Wishlist Button -->
                      <form action="{{ route('wishlist.add') }}" method="POST" class="position-absolute top-0 end-0 m-2">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <input type="hidden" name="name" value="{{ $product->name }}">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="price" value="{{ $product->sale_price ?: $product->regular_price }}">
                        <button type="submit" class="btn btn-sm btn-light rounded-circle shadow-sm p-1 text-danger border-0" title="Tambah ke Wishlist" style="width: 32px; height: 32px;">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                      </form>
                    </div>

                    <!-- Meta & Title -->
                    <small class="text-muted d-block text-uppercase fs-11 mb-1">{{ $product->category?->name ?? 'Matcha' }}</small>
                    <h6 class="product-title fw-bold fs-14 mb-2">
                      <a href="{{ route('shop.product.details', ['slug' => $product->slug]) }}" class="text-dark hover:text-success text-decoration-none line-clamp-2">
                        {{ $product->name }}
                      </a>
                    </h6>
                  </div>

                  <!-- Price & Add to Cart -->
                  <div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                      @if($product->sale_price)
                        <span class="fw-bold fs-15 text-success">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                        <span class="text-muted text-decoration-line-through fs-12">Rp {{ number_format($product->regular_price, 0, ',', '.') }}</span>
                      @else
                        <span class="fw-bold fs-15 text-dark">Rp {{ number_format($product->regular_price, 0, ',', '.') }}</span>
                      @endif
                    </div>

                    <form action="{{ route('cart.add') }}" method="POST">
                      @csrf
                      <input type="hidden" name="id" value="{{ $product->id }}">
                      <input type="hidden" name="name" value="{{ $product->name }}">
                      <input type="hidden" name="quantity" value="1">
                      <input type="hidden" name="price" value="{{ $product->sale_price ?: $product->regular_price }}">
                      <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold d-flex align-items-center justify-content-center gap-1.5 py-2">
                        <i class="fa-solid fa-cart-plus"></i> + Keranjang
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12 py-5 text-center text-muted">
                <i class="fa-solid fa-box-open fs-1 text-secondary mb-3 d-block"></i>
                <h5 class="fw-bold">Tidak ada produk yang cocok</h5>
                <p class="fs-14">Coba sesuaikan kata kunci pencarian atau reset filter untuk melihat katalog lengkap.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-sm btn-outline-success fw-bold mt-2">Lihat Semua Produk</a>
              </div>
            @endforelse
          </div>

          <!-- Pagination Links -->
          @if($products->hasPages())
            <div class="mt-5 d-flex justify-content-center">
              {{ $products->links() }}
            </div>
          @endif
        </div>
      </div>
    </section>
  </main>
</x-app-layout>
