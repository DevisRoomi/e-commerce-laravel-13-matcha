<x-app-layout>
<main>

    <section class="swiper-container js-swiper-slider swiper-number-pagination slideshow" data-settings='{
        "autoplay": {
          "delay": 5000
        },
        "slidesPerView": 1,
        "effect": "fade",
        "loop": true
      }'>
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="overflow-hidden position-relative h-100">
            <div class="slideshow-character position-absolute bottom-0 pos_right-center">
              <img loading="lazy" src="{{ asset('assets/images/slideshow-character1.png') }}" width="542" height="733"
                alt="Matcha Chawan & Chasen"
                class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
              <div class="character_markup type2">
                <p
                  class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
                  Ceremonial</p>
              </div>
            </div>
            <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
              <h6 class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                Koleksi Spesial</h6>
              <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Pure & Organic</h2>
              <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5">Kyoto Matcha</h2>
              <a href="{{ route('shop.index') }}"
                class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Belanja Sekarang</a>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="overflow-hidden position-relative h-100">
            <div class="slideshow-character position-absolute bottom-0 pos_right-center">
              <img loading="lazy" src="{{ asset('assets/images/slideshow-character2.png') }}" width="400" height="733"
                alt="Segar Iced Matcha Latte"
                class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
              <div class="character_markup">
                <p class="text-uppercase font-sofia fw-bold animate animate_fade animate_rtl animate_delay-10">Matcha
                </p>
              </div>
            </div>
            <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
              <h6 class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                Peralatan Tradisional</h6>
              <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Chasen Bambu</h2>
              <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5">& Chawan Keramik</h2>
              <a href="{{ route('shop.index') }}"
                class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Lihat Koleksi</a>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="overflow-hidden position-relative h-100">
            <div class="slideshow-character position-absolute bottom-0 pos_right-center">
              <img loading="lazy" src="{{ asset('assets/images/slideshow-character1.png') }}" width="400" height="690"
                alt="Upacara Matcha Tradisional"
                class="slideshow-character__img animate animate_fade animate_rtl animate_delay-10 w-auto h-auto" />
            </div>
            <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
              <h6 class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                Panen Pertama (First Harvest)</h6>
              <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Authentic Taste</h2>
              <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5">Umami Rich</h2>
              <a href="{{ route('shop.index') }}"
                class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Pesan Sekarang</a>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        <div
          class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5">
        </div>
      </div>
    </section>
    <div class="container mw-1620 bg-white border-radius-10">
      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
      <section class="category-carousel container">
        <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">You Might Like</h2>

        <div class="position-relative">
          <div class="swiper-container js-swiper-slider" data-settings='{
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": 8,
              "slidesPerGroup": 1,
              "effect": "none",
              "loop": true,
              "navigation": {
                "nextEl": ".products-carousel__next-1",
                "prevEl": ".products-carousel__prev-1"
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "slidesPerGroup": 2,
                  "spaceBetween": 15
                },
                "768": {
                  "slidesPerView": 4,
                  "slidesPerGroup": 4,
                  "spaceBetween": 30
                },
                "992": {
                  "slidesPerView": 6,
                  "slidesPerGroup": 1,
                  "spaceBetween": 45,
                  "pagination": false
                },
                "1200": {
                  "slidesPerView": 8,
                  "slidesPerGroup": 1,
                  "spaceBetween": 60,
                  "pagination": false
                }
              }
            }'>
            <div class="swiper-wrapper">
              @foreach($categories as $cat)
                <div class="swiper-slide">
                  @if($cat->image)
                    <img loading="lazy" class="w-100 h-auto mb-3 rounded-circle border p-1" src="{{ asset('uploads/categories/thumbnails/' . $cat->image) }}" width="124" height="124" alt="{{ $cat->name }}" />
                  @else
                    <img loading="lazy" class="w-100 h-auto mb-3 rounded-circle border p-1" src="{{ asset('assets/images/home/demo3/category_1.png') }}" width="124" height="124" alt="{{ $cat->name }}" />
                  @endif
                  <div class="text-center">
                    <a href="{{ route('shop.index', ['categories' => $cat->id]) }}" class="menu-link fw-medium text-dark hover:text-success">{{ $cat->name }}</a>
                  </div>
                </div>
              @endforeach
            </div><!-- /.swiper-wrapper -->
          </div><!-- /.swiper-container js-swiper-slider -->

          <div
            class="products-carousel__prev products-carousel__prev-1 position-absolute top-50 d-flex align-items-center justify-content-center">
            <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_prev_md" />
            </svg>
          </div><!-- /.products-carousel__prev -->
          <div
            class="products-carousel__next products-carousel__next-1 position-absolute top-50 d-flex align-items-center justify-content-center">
            <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_next_md" />
            </svg>
          </div><!-- /.products-carousel__next -->
        </div><!-- /.position-relative -->
      </section>

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

      <section class="hot-deals container">
        <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Hot Deals</h2>
        <div class="row">
          <div
            class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
            <h2>Summer Sale</h2>
            <h2 class="fw-bold">Up to 60% Off</h2>

            <div class="position-relative d-flex align-items-center text-center pt-xxl-4 js-countdown mb-3"
              data-date="18-3-2024" data-time="06:50">
              <div class="day countdown-unit">
                <span class="countdown-num d-block"></span>
                <span class="countdown-word text-uppercase text-secondary">Days</span>
              </div>

              <div class="hour countdown-unit">
                <span class="countdown-num d-block"></span>
                <span class="countdown-word text-uppercase text-secondary">Hours</span>
              </div>

              <div class="min countdown-unit">
                <span class="countdown-num d-block"></span>
                <span class="countdown-word text-uppercase text-secondary">Mins</span>
              </div>

              <div class="sec countdown-unit">
                <span class="countdown-num d-block"></span>
                <span class="countdown-word text-uppercase text-secondary">Sec</span>
              </div>
            </div>

            <a href="#" class="btn-link default-underline text-uppercase fw-medium mt-3">View All</a>
          </div>
          <div class="col-md-6 col-lg-8 col-xl-80per">
            <div class="position-relative">
              <div class="swiper-container js-swiper-slider" data-settings='{
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": 4,
                  "slidesPerGroup": 4,
                  "effect": "none",
                  "loop": false,
                  "breakpoints": {
                    "320": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 2,
                      "spaceBetween": 14
                    },
                    "768": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 3,
                      "spaceBetween": 24
                    },
                    "992": {
                      "slidesPerView": 3,
                      "slidesPerGroup": 1,
                      "spaceBetween": 30,
                      "pagination": false
                    },
                    "1200": {
                      "slidesPerView": 4,
                      "slidesPerGroup": 1,
                      "spaceBetween": 30,
                      "pagination": false
                    }
                  }
                }'>
                <div class="swiper-wrapper">
                  @foreach($featured_products as $fprod)
                    <div class="swiper-slide product-card product-card_style3">
                      <div class="pc__img-wrapper">
                        <a href="{{ route('shop.product.details', ['slug' => $fprod->slug]) }}">
                          @if($fprod->image)
                            <img loading="lazy" src="{{ asset('uploads/products/thumbnails/' . $fprod->image) }}" width="258" height="313" alt="{{ $fprod->name }}" class="pc__img">
                          @else
                            <img loading="lazy" src="{{ asset('assets/images/home/demo3/product-4.jpg') }}" width="258" height="313" alt="{{ $fprod->name }}" class="pc__img">
                          @endif
                        </a>
                      </div>

                      <div class="pc__info position-relative">
                        <h6 class="pc__title"><a href="{{ route('shop.product.details', ['slug' => $fprod->slug]) }}" class="text-truncate d-block">{{ $fprod->name }}</a></h6>
                        <div class="product-card__price d-flex align-items-center gap-2">
                          @if($fprod->sale_price)
                            <span class="money price text-success fw-bold">Rp {{ number_format($fprod->sale_price, 0, ',', '.') }}</span>
                            <span class="money price-old text-muted text-decoration-line-through fs-12">Rp {{ number_format($fprod->regular_price, 0, ',', '.') }}</span>
                          @else
                            <span class="money price text-dark fw-bold">Rp {{ number_format($fprod->regular_price, 0, ',', '.') }}</span>
                          @endif
                        </div>

                        <div class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body gap-2 p-2">
                          <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $fprod->id }}">
                            <input type="hidden" name="name" value="{{ $fprod->name }}">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="price" value="{{ $fprod->sale_price ?: $fprod->regular_price }}">
                            <button type="submit" class="btn btn-sm btn-primary fw-bold px-2 py-1 fs-12">+ Keranjang</button>
                          </form>
                          <form action="{{ route('wishlist.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $fprod->id }}">
                            <input type="hidden" name="name" value="{{ $fprod->name }}">
                            <input type="hidden" name="price" value="{{ $fprod->sale_price ?: $fprod->regular_price }}">
                            <button type="submit" class="pc__btn-wl bg-transparent border-0 text-danger" title="Wishlist">
                              <i class="fa-regular fa-heart"></i>
                            </button>
                          </form>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div><!-- /.swiper-wrapper -->
              </div><!-- /.swiper-container js-swiper-slider -->
            </div><!-- /.position-relative -->
          </div>
        </div>
      </section>

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
      <section class="category-banner container">
        <div class="row">
          <div class="col-md-6">
            <div class="category-banner__item border-radius-10 mb-5">
              <img loading="lazy" class="h-auto" src="{{ asset('assets/images/home/demo3/category_9.jpg') }}" width="690" height="665" alt="Saringan Stainless Furui" />
              <div class="category-banner__item-mark">
                Aksesoris Seduh
              </div>
              <div class="category-banner__item-content">
                <h3 class="mb-0">Saringan & Sendok Takar</h3>
                <a href="{{ route('shop.index', ['categories' => 3]) }}" class="btn-link default-underline text-uppercase fw-medium">Lihat Koleksi</a>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="category-banner__item border-radius-10 mb-5">
              <img loading="lazy" class="h-auto" src="{{ asset('assets/images/home/demo3/category_10.jpg') }}" width="690" height="665" alt="Chawan & Cangkir Keramik" />
              <div class="category-banner__item-mark">
                Ceramics Craft
              </div>
              <div class="category-banner__item-content">
                <h3 class="mb-0">Chawan & Cangkir Keramik</h3>
                <a href="{{ route('shop.index', ['categories' => 2]) }}" class="btn-link default-underline text-uppercase fw-medium">Beli Sekarang</a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

      <section class="products-grid container">
        <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4" style="color: var(--bs-primary);">Katalog Pilihan Matcha</h2>

        <div class="row row-cols-2 row-cols-md-4 g-4">
          @foreach($sale_products as $sprod)
            <div class="col">
              <div class="product-card product-card_style3 h-100 p-2 rounded-3 border bg-white shadow-sm d-flex flex-column justify-content-between">
                <div>
                  <div class="pc__img-wrapper position-relative overflow-hidden rounded-2 mb-2 bg-light text-center" style="aspect-ratio: 1/1;">
                    <a href="{{ route('shop.product.details', ['slug' => $sprod->slug]) }}">
                      @if($sprod->image)
                        <img loading="lazy" src="{{ asset('uploads/products/thumbnails/' . $sprod->image) }}" width="330" height="400"
                          alt="{{ $sprod->name }}" class="w-100 h-100 object-fit-cover pc__img">
                      @else
                        <img loading="lazy" src="{{ asset('assets/images/home/demo3/product-4.jpg') }}" width="330" height="400"
                          alt="{{ $sprod->name }}" class="w-100 h-100 object-fit-cover pc__img">
                      @endif
                    </a>
                  </div>

                  <div class="pc__info position-relative">
                    <small class="text-muted fs-11 text-uppercase">{{ $sprod->category?->name ?? 'Matcha' }}</small>
                    <h6 class="pc__title mt-1 mb-2">
                      <a href="{{ route('shop.product.details', ['slug' => $sprod->slug]) }}" class="text-dark fw-bold text-decoration-none">
                        {{ $sprod->name }}
                      </a>
                    </h6>
                    <div class="product-card__price d-flex align-items-center gap-2 mb-3">
                      @if($sprod->sale_price)
                        <span class="money price text-success fw-bold">Rp {{ number_format($sprod->sale_price, 0, ',', '.') }}</span>
                        <span class="money price-old text-muted text-decoration-line-through fs-12">Rp {{ number_format($sprod->regular_price, 0, ',', '.') }}</span>
                      @else
                        <span class="money price text-dark fw-bold">Rp {{ number_format($sprod->regular_price, 0, ',', '.') }}</span>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                  <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="id" value="{{ $sprod->id }}">
                    <input type="hidden" name="name" value="{{ $sprod->name }}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="price" value="{{ $sprod->sale_price ?: $sprod->regular_price }}">
                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold py-1.5 fs-12">
                      <i class="fa-solid fa-cart-shopping me-1"></i> + Keranjang
                    </button>
                  </form>
                  <form action="{{ route('wishlist.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $sprod->id }}">
                    <input type="hidden" name="name" value="{{ $sprod->name }}">
                    <input type="hidden" name="price" value="{{ $sprod->sale_price ?: $sprod->regular_price }}">
                    <button type="submit" class="btn btn-outline-danger btn-sm p-1.5" title="Wishlist">
                      <i class="fa-regular fa-heart"></i>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
        </div><!-- /.row -->

        <div class="text-center mt-5">
          <a class="btn btn-outline-success px-5 py-2.5 rounded-pill fw-bold" href="{{ route('shop.index') }}">
            Lihat Semua Produk di Shop <i class="fa-solid fa-arrow-right ms-1"></i>
          </a>
        </div>
      </section>
    </div>

    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

  </main>
    </x-app-layout>
