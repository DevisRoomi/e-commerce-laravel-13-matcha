<x-app-layout>
  <main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
      <h2 class="page-title mb-4">Akun Saya</h2>
      <div class="row">
        <div class="col-lg-3">
          @include('users.sidebar')
        </div>
        <div class="col-lg-9">
          <div class="page-content my-account__dashboard bg-white p-4 p-md-5 border rounded-3 shadow-sm">
            <div class="p-3 mb-4 rounded-3" style="background-color: #EEF3DF; border-left: 4px solid var(--bs-primary);">
              <p class="mb-0 fs-6">Halo, <strong>{{ Auth::user()->name }}</strong>! (Bukan <strong>{{ Auth::user()->name }}</strong>? <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('user-sidebar-logout-form').submit();" class="text-success fw-bold text-decoration-underline ms-1">Keluar</a>)</p>
            </div>

            <p class="text-secondary fs-6 mb-4">
              Dari dashboard akun Anda, Anda dapat dengan mudah melihat <a href="#" class="text-success fw-semibold text-decoration-underline">pesanan terbaru</a>, mengelola <a href="#" class="text-success fw-semibold text-decoration-underline">alamat pengiriman</a>, dan <a href="#" class="text-success fw-semibold text-decoration-underline">memperbarui kata sandi & detail akun Anda</a>.
            </p>

            <div class="row g-4 mt-2">
              <div class="col-md-4">
                <div class="card h-100 border-0 rounded-3 text-center p-3 shadow-sm" style="background-color: #F6F9EF;">
                  <div class="card-body">
                    <i class="fa-solid fa-box-open fs-2 mb-2 text-success"></i>
                    <h6 class="fw-bold">Pesanan</h6>
                    <p class="text-muted small mb-0">Pantau riwayat belanja Anda</p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card h-100 border-0 rounded-3 text-center p-3 shadow-sm" style="background-color: #F6F9EF;">
                  <div class="card-body">
                    <i class="fa-solid fa-map-location-dot fs-2 mb-2 text-success"></i>
                    <h6 class="fw-bold">Alamat</h6>
                    <p class="text-muted small mb-0">Atur tujuan pengiriman</p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card h-100 border-0 rounded-3 text-center p-3 shadow-sm" style="background-color: #F6F9EF;">
                  <div class="card-body">
                    <i class="fa-solid fa-shield-halved fs-2 mb-2 text-success"></i>
                    <h6 class="fw-bold">Keamanan</h6>
                    <p class="text-muted small mb-0">Ubah password akun</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</x-app-layout>
