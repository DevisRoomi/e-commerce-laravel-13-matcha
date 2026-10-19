<x-app-layout>
<div class="page-wrapper pt-90 pb-5">
  <div class="container pt-4">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb fs-14">
        <li class="breadcrumb-item"><a href="{{ route('home.index') }}" class="text-secondary text-decoration-none">Beranda</a></li>
        <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Kontak Kami</li>
      </ol>
    </nav>

    <!-- Header Section -->
    <div class="text-center max-w-2xl mx-auto mb-5">
      <span class="badge px-3 py-1.5 rounded-pill fs-12 fw-bold text-uppercase tracking-wider mb-2" style="background-color: #EEF3DF; color: #31522C;">
        Layanan Pelanggan
      </span>
      <h1 class="display-6 fw-extrabold text-dark mb-3" style="font-family: 'Playfair Display', serif;">
        Hubungi <span style="color: #31522C;">Matcha Atelier</span>
      </h1>
      <p class="text-secondary fs-16 lead">
        Punya pertanyaan seputar produk matcha, pesanan busana, atau kemitraan café? Tim kami siap membantu dengan senang hati.
      </p>
    </div>

    @if(Session::has('status'))
      <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 fs-15 mb-4 max-w-3xl mx-auto shadow-sm" style="background-color: #EEF3DF; border-color: #526531; color: #31522C;">
        <i class="fa-solid fa-circle-check fs-5"></i>
        <span>{{ Session::get('status') }}</span>
      </div>
    @endif

    <div class="row g-4 g-lg-5">
      <!-- Contact Info Cards -->
      <div class="col-lg-5">
        <div class="p-4 p-md-5 rounded-4 bg-white border border-emerald-100 shadow-sm h-100">
          <h4 class="fw-bold text-dark mb-4">Informasi Kontak</h4>

          <div class="d-flex align-items-start gap-3 mb-4">
            <div class="w-12 h-12 rounded-circle d-flex align-items-center justify-content-center shrink-0" style="width: 44px; height: 44px; background-color: #EEF3DF; color: #31522C;">
              <i class="fa-solid fa-location-dot fs-5"></i>
            </div>
            <div>
              <h6 class="fw-bold text-dark mb-1">Atelier & Studio</h6>
              <p class="text-secondary fs-14 mb-0">Jl. Kaliurang KM 5.5 No. 42, Sleman, D.I. Yogyakarta 55281</p>
            </div>
          </div>

          <div class="d-flex align-items-start gap-3 mb-4">
            <div class="w-12 h-12 rounded-circle d-flex align-items-center justify-content-center shrink-0" style="width: 44px; height: 44px; background-color: #EEF3DF; color: #31522C;">
              <i class="fa-solid fa-envelope fs-5"></i>
            </div>
            <div>
              <h6 class="fw-bold text-dark mb-1">Email Resmi</h6>
              <p class="text-secondary fs-14 mb-0">
                <a href="mailto:hello@matcha.com" class="text-decoration-none text-secondary">hello@matcha.com</a>
              </p>
            </div>
          </div>

          <div class="d-flex align-items-start gap-3 mb-4">
            <div class="w-12 h-12 rounded-circle d-flex align-items-center justify-content-center shrink-0" style="width: 44px; height: 44px; background-color: #EEF3DF; color: #31522C;">
              <i class="fa-brands fa-whatsapp fs-5"></i>
            </div>
            <div>
              <h6 class="fw-bold text-dark mb-1">WhatsApp & Telepon</h6>
              <p class="text-secondary fs-14 mb-0">+62 812-3456-7890</p>
            </div>
          </div>

          <div class="d-flex align-items-start gap-3">
            <div class="w-12 h-12 rounded-circle d-flex align-items-center justify-content-center shrink-0" style="width: 44px; height: 44px; background-color: #EEF3DF; color: #31522C;">
              <i class="fa-solid fa-clock fs-5"></i>
            </div>
            <div>
              <h6 class="fw-bold text-dark mb-1">Jam Operasional</h6>
              <p class="text-secondary fs-14 mb-0">Senin – Sabtu, 08:00 – 17:00 WIB (Minggu Libur)</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="col-lg-7">
        <div class="p-4 p-md-5 rounded-4 bg-white border border-emerald-100 shadow-sm">
          <h4 class="fw-bold text-dark mb-2">Kirim Pesan</h4>
          <p class="text-secondary fs-14 mb-4">Isi formulir di bawah ini dan kami akan membalas via email atau WhatsApp secepat mungkin.</p>

          <form action="{{ route('home.contact.store') }}" method="POST">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fs-13 fw-semibold text-secondary">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Devis Roomi" required>
                @error('name')
                  <div class="invalid-feedback fs-12">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6">
                <label class="form-label fs-13 fw-semibold text-secondary">Alamat Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="devis@example.com" required>
                @error('email')
                  <div class="invalid-feedback fs-12">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-12">
                <label class="form-label fs-13 fw-semibold text-secondary">Nomor Telepon / WhatsApp (Opsional)</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="081234567890">
                @error('phone')
                  <div class="invalid-feedback fs-12">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-12">
                <label class="form-label fs-13 fw-semibold text-secondary">Pesan atau Pertanyaan Anda <span class="text-danger">*</span></label>
                <textarea name="comment" rows="5" class="form-control @error('comment') is-invalid @enderror" placeholder="Tuliskan pesan Anda di sini..." required>{{ old('comment') }}</textarea>
                @error('comment')
                  <div class="invalid-feedback fs-12">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-12 pt-3 pb-2">
                <button type="submit" class="btn btn-primary px-4 py-2.5 fw-bold rounded-pill shadow-sm">
                  <i class="fa-solid fa-paper-plane me-2"></i> Kirim Pesan Sekarang
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</x-app-layout>
