<div class="sidebar d-flex flex-column h-100">
    <!-- Header Section -->
    <div class="sidebar-header">
        <div class="mt-3 px-3 d-flex align-items-center">
            <i class="fas fa-user-circle mr-2"></i>
            <h5 class="mb-0">KELOMPOK 6</h5>
        </div>
        <hr>
    </div>

    <!-- Sidebar Menu -->
    <nav class="sidebar-menu flex-grow-1">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
            <!-- Beranda -->
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Beranda</p>
                </a>
            </li>
            <!-- Profile -->
            <li class="nav-item">
                <a href="{{ url('/profile') }}" class="nav-link {{ request()->is('profile') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Profile</p>
                </a>
            </li>
            <!-- Kelola jenis Pengguna -->
            <li class="nav-item">
                <a href="{{ url('/jenisPengguna') }}" class="nav-link {{ request()->is('jenisPengguna') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users-cog"></i>
                    <p>Kelola Jenis Pengguna</p>
                </a>
            </li>
            <!-- Kelola Pengguna -->
            <li class="nav-item">
                <a href="{{ url('/pengguna') }}" class="nav-link {{ request()->is('pengguna') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-cog"></i>
                    <p>Kelola Pengguna</p>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Logout Button -->
    <div class="sidebar-footer p-3">
        <a href="{{ url('logout') }}" class="btn btn-danger btn-block"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
        <form id="logout-form" action="{{ url('logout') }}" method="GET" style="display: none;">
            @csrf
        </form>
    </div>
</div>