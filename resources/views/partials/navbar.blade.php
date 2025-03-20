@php
    use Illuminate\Support\Facades\Auth;
@endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Profile Dropdown -->
        @if(Auth::check()) 
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle"></i> {{ Auth::user()->nama_lengkap ?? 'Admin' }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('admin.profile.show') }}">
                    <i class="fas fa-user-cog"></i> Profil Saya
                </a>
                <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="#" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
        @endif
    </ul>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</nav>

<!-- Pastikan jQuery & Bootstrap sudah dimuat -->
<script>
    $(document).ready(function () {
        $('.dropdown-toggle').dropdown();
    });
</script>
