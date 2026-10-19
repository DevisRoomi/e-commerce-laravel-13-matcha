<div class="my-account__navigation mb-4 mb-lg-0">
  <div class="p-3 bg-white border rounded-3 shadow-sm mb-3 text-center">
    <div class="w-16 h-16 mx-auto rounded-full bg-success text-white d-flex align-items-center justify-content-center fw-bold fs-4 mb-2 shadow-sm" style="background-color: var(--bs-primary) !important;">
      {{ substr(Auth::user()->name, 0, 1) }}
    </div>
    <h6 class="mb-0 fw-bold text-dark">{{ Auth::user()->name }}</h6>
    <small class="text-secondary">{{ Auth::user()->email }}</small>
  </div>

  <ul class="account-nav list-unstyled p-0 m-0 border rounded-3 bg-white shadow-sm overflow-hidden">
    <li>
      <a href="{{ route('user.index') }}" class="menu-link menu-link_us-s d-flex align-items-center gap-2 p-3 border-bottom {{ request()->routeIs('user.index') ? 'menu-link_active fw-bold' : '' }}" style="{{ request()->routeIs('user.index') ? 'background-color: #EEF3DF; color: var(--bs-primary);' : '' }}">
        <i class="fa-solid fa-gauge w-5"></i> Dashboard
      </a>
    </li>
    <li>
      <a href="#" class="menu-link menu-link_us-s d-flex align-items-center gap-2 p-3 border-bottom text-secondary">
        <i class="fa-solid fa-bag-shopping w-5"></i> Pesanan Saya
      </a>
    </li>
    <li>
      <a href="#" class="menu-link menu-link_us-s d-flex align-items-center gap-2 p-3 border-bottom text-secondary">
        <i class="fa-solid fa-location-dot w-5"></i> Alamat Pengiriman
      </a>
    </li>
    <li>
      <a href="#" class="menu-link menu-link_us-s d-flex align-items-center gap-2 p-3 border-bottom text-secondary">
        <i class="fa-solid fa-user-pen w-5"></i> Detail Akun
      </a>
    </li>
    <li>
      <a href="#" class="menu-link menu-link_us-s d-flex align-items-center gap-2 p-3 border-bottom text-secondary">
        <i class="fa-solid fa-heart w-5"></i> Wishlist
      </a>
    </li>
    <li>
      <form id="user-sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
      <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('user-sidebar-logout-form').submit();"
         class="menu-link menu-link_us-s d-flex align-items-center gap-2 p-3 text-danger fw-semibold">
        <i class="fa-solid fa-right-from-bracket w-5"></i> Keluar (Logout)
      </a>
    </li>
  </ul>
</div>
