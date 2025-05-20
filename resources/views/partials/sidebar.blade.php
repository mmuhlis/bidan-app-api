<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link text-center">
        <img src="{{ asset('images/logobidan2.png') }}" alt="Smart Bidan Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">Smart Bidan</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-header">MENU UTAMA</li>

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">MANAJEMEN DATA</li>

                <li class="nav-item">
                    <a href="{{ route('rekam-medis.index') }}" class="nav-link {{ request()->is('rekam-medis*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-notes-medical"></i>
                        <p>Rekam Medis</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('data-pasien.index') }}" class="nav-link {{ request()->is('data-pasien*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-injured"></i>
                        <p>Data Pasien</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('data-pengguna.index') }}" class="nav-link {{ request()->is('data-pengguna*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Pengguna</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.skrining.index') }}" class="nav-link {{ request()->is('data-skrining*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>Data Skrining</p>
                    </a>
                </li>

                {{-- <li class="nav-header">PENGATURAN</li>

                <li class="nav-item">
                    <a href="#" class="nav-link text-danger"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li> --}}
            </ul>
        </nav>
    </div>
</aside>
