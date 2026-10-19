<x-app-layout>
<div class="page-wrapper pt-90 pb-5">
  <div class="container pt-4">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb fs-14">
        <li class="breadcrumb-item"><a href="{{ route('home.index') }}" class="text-secondary text-decoration-none">Beranda</a></li>
        <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Tentang Kami</li>
      </ol>
    </nav>

    <!-- Header Section -->
    <div class="text-center max-w-2xl mx-auto mb-5">
      <span class="badge px-3 py-1.5 rounded-pill fs-12 fw-bold text-uppercase tracking-wider mb-2" style="background-color: #EEF3DF; color: #31522C;">
        Cerita & Filosofi
      </span>
      <h1 class="display-6 fw-extrabold text-dark mb-3" style="font-family: 'Playfair Display', serif;">
        Tentang <span style="color: #31522C;">Matcha Atelier</span>
      </h1>
      <p class="text-secondary fs-16 lead">
        Menghadirkan ketenangan ritual teh hijau murni Kyoto berpadu dengan keanggunan busana muslimah berpalet warna alam yang teduh.
      </p>
    </div>

    <!-- Story Showcase -->
    <div class="row align-items-center g-4 g-lg-5 mb-5 pb-lg-4">
      <div class="col-lg-6">
        <div class="position-relative rounded-4 overflow-hidden shadow-lg border border-2 border-emerald-100">
          <img src="{{ asset('uploads/products/product-ceremonial.jpg') }}" alt="Matcha Harvest" class="w-100 h-100 object-fit-cover" style="min-height: 380px;">
          <div class="position-absolute bottom-0 start-0 w-100 p-4 text-white" style="background: linear-gradient(to top, rgba(49, 82, 44, 0.9), transparent);">
            <h5 class="fw-bold mb-1">Tradisi Uji & Shizuoka</h5>
            <small class="text-white-50">Dipetik tangan pada panen pertama di pegunungan Kyoto.</small>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <h3 class="fw-bold text-dark mb-3">Harmoni Ketenangan Pikiran & Kesantunan Berbusana</h3>
        <p class="text-secondary lh-lg mb-4">
          Matcha Atelier lahir dari kecintaan kami terhadap dua esensi keindahan: ketenangan ritual minum matcha khas Jepang yang menyejukkan jiwa, serta nilai kesantunan busana muslimah yang bersahaja dan bermartabat.
        </p>
        <p class="text-secondary lh-lg mb-4">
          Setiap gram bubuk matcha kami digiling secara lambat menggunakan batu granit tradisional demi menjaga kadar antioksidan EGCG, L-theanine, dan profil umami alaminya. Sementara lini busana kami dirancang dengan potongan longgar (loose-fit), bahan linen dingin, dan palet warna hijau matcha yang meneduhkan pandangan.
        </p>
        <div class="d-flex align-items-center gap-3 pt-2">
          <a href="{{ route('shop.index') }}" class="btn btn-primary px-4 py-2.5 fw-bold rounded-pill">
            <i class="fa-solid fa-bag-shopping me-2"></i> Jelajahi Koleksi
          </a>
          <a href="{{ route('home.contact') }}" class="btn btn-outline-secondary px-4 py-2.5 fw-semibold rounded-pill">
            Hubungi Kami
          </a>
        </div>
      </div>
    </div>

    <!-- 3 Core Pillars -->
    <div class="row g-4 text-center my-4">
      <div class="col-md-4">
        <div class="p-4 rounded-4 bg-white border border-emerald-100 shadow-sm h-100">
          <div class="w-16 h-16 rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px; background-color: #EEF3DF; color: #31522C;">
            <i class="fa-solid fa-leaf fs-3"></i>
          </div>
          <h5 class="fw-bold text-dark mb-2">100% Organik & Murni</h5>
          <p class="text-secondary fs-14 mb-0">
            Tanpa perasa sintetis, pengawet, maupun gula tambahan. Diseduh murni dari daun teh Tencha pilihan berkadar klorofil tinggi.
          </p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 rounded-4 bg-white border border-emerald-100 shadow-sm h-100">
          <div class="w-16 h-16 rounded-circle mx-auto d-flex align-items-center justify-center mb-3" style="width: 64px; height: 64px; background-color: #EEF3DF; color: #31522C;">
            <i class="fa-solid fa-vest-patches fs-3"></i>
          </div>
          <h5 class="fw-bold text-dark mb-2">Modest Muslimah Fashion</h5>
          <p class="text-secondary fs-14 mb-0">
            Pashmina silk dan gamis abaya berpotongan syari yang sejuk, flowy, tidak menerawang, dan nyaman untuk aktivitas harian.
          </p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 rounded-4 bg-white border border-emerald-100 shadow-sm h-100">
          <div class="w-16 h-16 rounded-circle mx-auto d-flex align-items-center justify-center mb-3" style="width: 64px; height: 64px; background-color: #EEF3DF; color: #31522C;">
            <i class="fa-solid fa-hand-holding-heart fs-3"></i>
          </div>
          <h5 class="fw-bold text-dark mb-2">Kualitas & Keberlanjutan</h5>
          <p class="text-secondary fs-14 mb-0">
            Bermitra langsung dengan petani teh lokal Jepang dan penjahit muslimah terampil dengan standar etika kerja yang adil.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
</x-app-layout>
