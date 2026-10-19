<x-app-layout>
  <main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="login-register container">
      <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link nav-link_underscore active" id="register-tab" data-bs-toggle="tab"
            href="#tab-item-register" role="tab" aria-controls="tab-item-register"
            aria-selected="true">Daftar Akun Baru / Register</a>
        </li>
      </ul>
      <div class="tab-content pt-2" id="login_register_tab_content">
        <div class="tab-pane fade show active" id="tab-item-register" role="tabpanel"
          aria-labelledby="register-tab">
          <div class="register-form">
            <form method="POST" action="{{ route('register') }}" name="register-form" class="needs-validation"
              novalidate="">
              @csrf

              <div class="form-floating mb-3">
                <input class="form-control form-control_gray @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required
                  autocomplete="name" autofocus id="name" type="text" placeholder="Nama Lengkap">
                <label for="name">Nama Lengkap *</label>
                @error('name')
                  <span class="text-danger fs-12 mt-1 d-block" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="pb-3"></div>

              <div class="form-floating mb-3">
                <input id="email" type="email" class="form-control form-control_gray @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                  required autocomplete="email" placeholder="nama@email.com">
                <label for="email">Alamat Email *</label>
                @error('email')
                  <span class="text-danger fs-12 mt-1 d-block" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="pb-3"></div>

              <div class="form-floating mb-3">
                <input id="mobile" type="text" class="form-control form-control_gray @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}"
                  required autocomplete="mobile" placeholder="Nomor Handphone">
                <label for="mobile">Nomor HP / WhatsApp *</label>
                @error('mobile')
                  <span class="text-danger fs-12 mt-1 d-block" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="pb-3"></div>

              <div class="form-floating mb-3">
                <input id="password" type="password" class="form-control form-control_gray @error('password') is-invalid @enderror" name="password" required
                  autocomplete="new-password" placeholder="Kata Sandi">
                <label for="password">Kata Sandi *</label>
                @error('password')
                  <span class="text-danger fs-12 mt-1 d-block" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="pb-3"></div>

              <div class="form-floating mb-3">
                <input id="password-confirm" type="password" class="form-control form-control_gray"
                  name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi Kata Sandi">
                <label for="password-confirm">Konfirmasi Kata Sandi *</label>
              </div>

              <div class="d-flex align-items-center mb-3 pb-2">
                <p class="m-0 text-secondary fs-12">Data pribadi Anda akan digunakan untuk mendukung pengalaman belanja Anda di website ini dan mengelola akses ke akun Anda.</p>
              </div>

              <button class="btn btn-primary w-100 text-uppercase py-3 fw-bold" type="submit">Daftar Sekarang</button>

              <div class="customer-option mt-4 text-center">
                <span class="text-secondary">Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="btn-text fw-bold text-success ms-1">Masuk ke Akun Anda</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>
</x-app-layout>
