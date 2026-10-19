<x-app-layout>
  <main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="login-register container">
      <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link nav-link_underscore active" id="login-tab" data-bs-toggle="tab" href="#tab-item-login"
            role="tab" aria-controls="tab-item-login" aria-selected="true">Masuk / Login</a>
        </li>
      </ul>
      <div class="tab-content pt-2" id="login_register_tab_content">
        <div class="tab-pane fade show active" id="tab-item-login" role="tabpanel" aria-labelledby="login-tab">
          <div class="login-form">
            <form method="POST" action="{{ route('login') }}" name="login-form" class="needs-validation" novalidate="">
              @csrf

              <!-- Session Status -->
              <x-auth-session-status class="mb-4" :status="session('status')" />

              <div class="form-floating mb-3">
                <input class="form-control form-control_gray @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"
                  autofocus id="email" type="email" placeholder="nama@email.com">
                <label for="email">Alamat Email *</label>
                @error('email')
                  <span class="text-danger fs-12 mt-1 d-block" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="pb-3"></div>

              <div class="form-floating mb-3">
                <input id="password" type="password" class="form-control form-control_gray @error('password') is-invalid @enderror" name="password" required
                  autocomplete="current-password" placeholder="Password">
                <label for="password">Kata Sandi *</label>
                @error('password')
                  <span class="text-danger fs-12 mt-1 d-block" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="d-flex align-items-center mb-3 pb-2">
                <div class="form-check mb-0">
                  <input name="remember" class="form-check-input form-check-input_fill" type="checkbox" id="remember_me">
                  <label class="form-check-label text-secondary" for="remember_me">Ingat saya</label>
                </div>
                @if (Route::has('password.request'))
                  <a href="{{ route('password.request') }}" class="btn-text ms-auto text-secondary">Lupa kata sandi?</a>
                @endif
              </div>

              <button class="btn btn-primary w-100 text-uppercase py-3 fw-bold" type="submit">Masuk</button>

              <div class="customer-option mt-4 text-center">
                <span class="text-secondary">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="btn-text fw-bold text-success ms-1">Daftar Akun Baru</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>
</x-app-layout>
