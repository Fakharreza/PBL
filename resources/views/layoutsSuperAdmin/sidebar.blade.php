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

            <!-- Sidebar for superadmin -->
            @if (session('role') == "SuperAdmin")
            <!-- Kelola Jenis Pengguna -->
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
            @endif

            <!-- Sidebar for admin -->
            @if (session('role') == "Admin")
            <!-- Statistik Sertifikasi -->
            <li class="nav-item">
                <a href="{{ url('/statistikSertifikasi') }}" class="nav-link {{ request()->is('statistikSertifikasi') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <p>Statistik Sertifikasi</p>
                </a>
            </li>
            <!-- Daftar Pelatihan Sertifikasi -->
            <li class="nav-item">
                <a href="{{ url('/daftarPelatihanSertifikasi') }}" class="nav-link {{ request()->is('daftarPelatihanSertifikasi') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-list"></i>
                    <p>Daftar Pelatihan Sertifikasi</p>
                </a>
            </li>
            <!-- Draft Surat Tugas -->
            <li class="nav-item">
                <a href="{{ url('/draftSuratTugas') }}" class="nav-link {{ request()->is('draftSuratTugas') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Draft Surat Tugas</p>
                </a>
            </li>
            <!-- Menu Kelola -->
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                        Kelola
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/jenisPelatihan') }}" class="nav-link {{ request()->is('jenisPelatihan') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Kelola Jenis Pelatihan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/pelatihanSertifikasi') }}" class="nav-link {{ request()->is('pelatihanSertifikasi') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-certificate"></i>
                            <p>Kelola Pelatihan Sertifikasi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/mataKuliah') }}" class="nav-link {{ request()->is('mataKuliah') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Kelola Mata Kuliah</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/bidangMinat') }}" class="nav-link {{ request()->is('bidangMinat') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-lightbulb"></i>
                            <p>Kelola Bidang Minat</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/periode') }}" class="nav-link {{ request()->is('periode') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar"></i>
                            <p>Kelola Periode</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/vendorPelatihan') }}" class="nav-link {{ request()->is('vendor') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Kelola Vendor Pelatihan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/vendorSertif') }}" class="nav-link {{ request()->is('vendor') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Kelola Vendor Sertifikasi</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            <!-- Sidebar for Dosen -->
            @if (session('role') == "Dosen")
            <!-- Daftar Pelatihan Sertifikasi -->
            <li class="nav-item">
                <a href="{{ url('/daftarPelatihanSertifikasi') }}" class="nav-link {{ request()->is('daftarPelatihanSertifikasi') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-list"></i>
                    <p>Daftar Pelatihan Sertifikasi</p>
                </a>
            </li>
            <!-- Data Sertifikasi Pelatihan -->
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-database"></i>
                    <p>
                        Data Dosen
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/dataPelatihan') }}" class="nav-link {{ request()->is('dataPelatihan') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>Data Pelatihan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/dataSertifikasi') }}" class="nav-link {{ request()->is('dataSertifikasi') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-certificate"></i>
                            <p>Data Sertifikasi</p>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- surat tugas -->
            <li class="nav-item">
                <a href="{{ url('/draftSuratTugas') }}" class="nav-link {{ request()->is('draftSuratTugas') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Draft Surat Tugas</p>
                </a>
            </li>
            @endif
            
            <!-- Sidebar for Pimpinan -->
            @if (session('role') == "Pimpinan")
            <!-- statistik sertifikasi -->
            <li class="nav-item">
                <a href="{{ url('/statistikSertifikasi') }}" class="nav-link {{ request()->is('statistikSertifikasi') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-chart-line"></i>
                    <p>Statistik Sertifikasi</p>
                </a>
            </li>
            <!-- Daftar Pelatihan Sertifikasi -->
            <li class="nav-item">
                <a href="{{ url('/daftarPelatihanSertifikasi') }}" class="nav-link {{ request()->is('daftarPelatihanSertifikasi') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-list"></i>
                    <p>Daftar Pelatihan Sertifikasi</p>
                </a>
            </li>
            <!-- surat tugas -->
            <li class="nav-item">
                <a href="{{ url('/draftSuratTugas') }}" class="nav-link {{ request()->is('draftSuratTugas') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Draft Surat Tugas</p>
                </a>
            </li>
            <!-- Acc peserta -->
            <li class="nav-item">
                <a href="{{ url('/accPeserta') }}" class="nav-link {{ request()->is('accPeserta') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-check-circle"></i>
                    <p>Acc Peserta</p>
                </a>
            </li>
            @endif

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

<!-- Script for Dropdown -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const dropdownToggles = document.querySelectorAll(".has-treeview > a");

    dropdownToggles.forEach(toggle => {
        toggle.addEventListener("click", function (e) {
            e.preventDefault();
            const parent = this.parentElement;
            parent.classList.toggle("menu-open");
        });
    });
});
</script>

<!-- Style for Dropdown -->
<style>
.nav-treeview {
    display: none;
    padding-left: 20px;
}

.nav-item.menu-open > .nav-treeview {
    display: block;
}

.nav-item.menu-open > a .fas.fa-angle-left {
    transform: rotate(90deg);
    transition: transform 0.3s ease;
}
</style>