<div class="sidebar">
    <div class="mt-3 px-3">
        <h5>KELOMPOK 6</h5>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
            <!-- Beranda -->
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ $activeMenu == 'beranda' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Beranda</p>
                </a>
            </li>
            <!-- Profile -->
            <li class="nav-item">
                <a href="{{ url('/profile') }}" class="nav-link {{ $activeMenu == 'beranda' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users-cog"></i>
                    <p>Profile</p>
                </a>
            </li>
            <!-- Kelola jenis Pengguna -->
            <li class="nav-item">
                <a href="{{ url('/jenisPengguna') }}" class="nav-link {{ $activeMenu == 'jenisPengguna' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users-cog"></i>
                    <p>Kelola jenis Pengguna</p>
                </a>
            </li>

            <!-- Kelola Pengguna -->
            <li class="nav-item">
                <a href="{{ url('/pengguna') }}" class="nav-link {{ $activeMenu == 'pengguna' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Kelola Pengguna</p>
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- Logout Button -->
    <div class="mt-auto p-3">
        <a href="{{ url('logout') }}" class="btn btn-danger btn-block" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
        <form id="logout-form" action="{{ url('logout') }}" method="GET" style="display: none;">
        </form>
    </div>
</div>