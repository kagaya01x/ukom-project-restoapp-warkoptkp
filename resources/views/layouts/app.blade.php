<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') — RestoApp</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link
      rel="icon"
      href="{{ asset('favicon.ico') }}"
      type="image/x-icon"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0&icon_names=arrow_outward"
    />
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @stack('styles')
  </head>
  <body>
    <div class="header-main-wrapper">
      <!-- SIDEBAR NAVIGASI -->
      <nav class="sidebar">
        <div class="sidebar-content">
          <div class="sidebar-title">
            <h2 class="mb-0">WarkopTKP</h2>
          </div>
          <button onclick="sidebar()" class="sidebar-btn" type="button" aria-label="Toggle Sidebar">
            <div class="close-icon">
              <div class="line"></div>
            </div>
          </button>
        </div>

        <div class="ul-profile-wrapper">
          <!-- DAFTAR MENU INTI RESTOAPP -->
          <ul id="ul-sidebar" class="list-unstyled mb-0">
            <!-- 1. Dashboard -->
            <a class="text-white text-decoration-none {{ request()->routeIs('dashboard') && !request()->has('start_date') ? 'active' : '' }}" 
               href="{{ route('dashboard') }}">
              <li class="{{ request()->routeIs('dashboard') && !request()->has('start_date') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
              </li>
            </a>

            <!-- 2. Kasir / Pemesanan -->
            <a class="text-white text-decoration-none {{ request()->routeIs('orders.create') ? 'active' : '' }}" 
               href="{{ route('orders.create') }}">
              <li class="{{ request()->routeIs('orders.create') ? 'active' : '' }}">
                <i class="bi bi-cart-plus me-2"></i>Kasir / Pemesanan
              </li>
            </a>

            <!-- 3. List Kategori (Menu & Kategori) -->
            <a class="text-white text-decoration-none {{ request()->routeIs('orders.index') ? 'active' : '' }}" 
               href="{{ route('orders.index') }}">
              <li class="{{ request()->routeIs('orders.index') ? 'active' : '' }}">
                <i class="bi bi-bag me-2"></i>List Pesanan
              </li>
            </a>

            <!-- 4. Menu Restoran -->
            <a class="text-white text-decoration-none {{ request()->routeIs('menu-items.*') ? 'active' : '' }}" 
               href="{{ route('menu-items.index') }}">
              <li class="{{ request()->routeIs('menu-items.*') ? 'active' : '' }}">
                <i class="bi bi-menu-button-wide me-2"></i>Menu Restoran
              </li>
            </a>

            <!-- 5. List Kategori (Menu & Kategori) -->
            <a class="text-white text-decoration-none {{ request()->routeIs('categories.*') ? 'active' : '' }}" 
               href="{{ route('categories.index') }}">
              <li class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags me-2"></i>List Kategori
              </li>
            </a>

            {{-- <!-- 5. Rekapitulasi Penghasilan -->
            <a class="text-white text-decoration-none {{ request()->routeIs('dashboard') && request()->has('start_date') ? 'active' : '' }}" 
               href="{{ route('dashboard') }}#rekapitulasi">
              <li class="{{ request()->routeIs('dashboard') && request()->has('start_date') ? 'active' : '' }}">
                <i class="bi bi-graph-up-arrow me-2"></i>Rekapitulasi
              </li>
            </a> --}}
          </ul>
          
          <!-- BAGIAN PROFIL & DROPDOWN (Menggunakan Dropup Bootstrap) -->
          <div class="dropdown dropup px-2">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle p-2 rounded bg-black bg-opacity-25" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
              <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 36px; height: 36px;">
                <i class="bi bi-person-fill text-white fs-5"></i>
              </div>
              <div class="overflow-hidden">
                <strong class="d-block text-truncate" style="max-width: 140px;">
                  @if ($employee)
                    {{ $employee->name }}
                  @endif
                </strong>
                <small class="text-muted d-block text-truncate" style="max-width: 140px;">
                  Staff Resto
                </small>
              </div>
            </a>
            
            <!-- Menu Dropdown (dropup karena posisinya di bawah sidebar) -->
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow w-100" aria-labelledby="dropdownUser1">
              <li>
                <span class="dropdown-item-text  small text-white">
                  @if ($employee)
                    Username: <strong>{{ $employee->work_id}}</strong>
                    <br>
                    Jabatan: <strong>{{ $employee->position }}</strong>
                  @endif
                </span>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger" id="logoutBtn">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <!-- KONTEN UTAMA DINAMIS -->
      <main>
        <!-- Overlay untuk Mobile (klik untuk menutup sidebar) -->
        <div class="overlay" onclick="sidebar()"></div>

        <!-- Container Konten Dinamis -->
        <div class="w-100 p-3 p-md-4 grow">
          {{-- Notifikasi Flash Session --}}
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
              <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
              <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          {{-- Tempat Konten Child View Dirender --}}
          @yield('content')
        </div>
      </main>
    </div>

    <!-- FOOTER APLIKASI -->
    <footer>
      <div class="footer-content">
        <div class="footer-about">
          <h3>WarkopTKP — RestoApp</h3>
          <p>Sistem Point of Sales & Manajemen Warung Makan & Warkop</p>
        </div>

        {{-- <div class="footer-social">
          <h4>Navigasi Cepat</h4>
          <a href="{{ route('dashboard') }}">Dashboard</a> 
          <a href="{{ route('orders.create') }}">Kasir</a>
          <a href="{{ route('menu-items.index') }}">Daftar Menu</a>
        </div> --}}
      </div>
      <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} RestoApp. All Rights Reserved.</p>
      </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script Sidebar Responsif -->
    <script>
      const sidebarContainer = document.querySelector(".sidebar");
      const sidebarUl = document.querySelector(".ul-profile-wrapper");
      const sidebarBtn = document.querySelector(".sidebar-btn");
      const sidebarHam = document.querySelector(".close-icon");
      const line = document.querySelector(".line");
      const overlay = document.querySelector(".overlay");

      let resizeTimer;
      window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
          if (window.innerWidth > 980) {
            sidebarContainer.style.setProperty('left', '0');
            sidebarUl.style.setProperty('display', 'flex');
            sidebarContainer.style.setProperty('background-color', 'var(--black)');
            overlay.style.setProperty('display', 'none');
          } else {
            isOpened = true;
            sidebar();
          }
        }, 200);
      });

      

      // Toggle Sidebar
      let isOpened = false;
      function sidebar() { 
        if (!isOpened) {
          isOpened = true;
          sidebarUl.style.setProperty('display', 'flex');
          sidebarContainer.style.setProperty('left', '0');
          sidebarContainer.style.setProperty('background-color', 'var(--black)');
          sidebarBtn.style.setProperty("left", "0");
          sidebarHam.style.setProperty("--rotate-before", "rotate(45deg)");
          sidebarHam.style.setProperty("--rotate-after", "rotate(-45deg)");
          sidebarHam.style.setProperty("--line-color", "white");
          sidebarHam.style.setProperty("--bottom", "0");
          sidebarHam.style.setProperty("--top", "0");
          line.style.setProperty("opacity", "0");
          overlay.style.setProperty('background-color', 'rgba(0, 0, 0, 0.328)');
          overlay.style.setProperty('display', 'block');
        } else { 
          isOpened = false;
          sidebarContainer.style.setProperty('left', '-15rem');
          sidebarContainer.style.setProperty('background-color', 'rgba(0, 0, 0, 0)');
          sidebarBtn.style.setProperty("left", "5rem");
          sidebarHam.style.setProperty("--rotate-before", "rotate(0deg)");
          sidebarHam.style.setProperty("--rotate-after", "rotate(0deg)");
          sidebarHam.style.setProperty("--line-color", "black");
          sidebarHam.style.setProperty("--bottom", "1rem");
          sidebarHam.style.setProperty("--top", "1rem");
          line.style.setProperty("opacity", "1");
          overlay.style.setProperty('background-color', 'rgba(0, 0, 0, 0)');
          setTimeout(() => {
            sidebarUl.style.setProperty('display', 'none');
            overlay.style.setProperty('display', 'none');
          }, 100);
        }
      }

      // Handler Submit Logout Form
      const logoutForm = document.getElementById('logoutForm');
      if (logoutForm) {
        logoutForm.addEventListener('submit', function() {
          const button = document.getElementById('logoutBtn');

        });
      }
    </script>

    @stack('scripts')
  </body>
</html>
