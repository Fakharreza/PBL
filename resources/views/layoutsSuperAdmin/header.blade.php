<nav class="main-header navbar navbar-expand-md navbar-dark" style="background-color: #1B3767;">
  <div class="container-fluid">
    <!-- Sidebar Toggle (Jika diperlukan) -->
    <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>



    <!-- Notifikasi (Dipindahkan ke kanan) -->
    <div class="dropdown ms-auto">
      <button class="btn btn-link text-white dropdown-toggle" type="button" id="dropdownMenuButton"
        data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-bell"></i>
        @if(auth()->check() && isset($unreadNotifications) && $unreadNotifications > 0)
      <span class="badge bg-danger">{{ $unreadNotifications }}</span>
    @endif
      </button>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
        @if(auth()->check() && isset($notifikasi) && !$notifikasi->isEmpty())
      @foreach($notifikasi->take(5) as $notif)
      <li>
      <span class="dropdown-item {{ $notif->is_read ? 'text-muted' : '' }}">
      {{ $notif->pesan }}
      <small class="text-muted float-end">{{ $notif->created_at->diffForHumans() }}</small>

      </span>
      </li>
    @endforeach
      <!-- <li><span class="dropdown-item text-center" href="{{ route('notifikasi.index') }}">Lihat Semua</span></li> -->
    @else
    <li><a class="dropdown-item text-center">Tidak ada notifikasi</a></li>
  @endif
      </ul>
    </div>
    <!-- User Role (Di sebelah kiri jika perlu) -->
    <span class="navbar-text text-white font-weight-bold ms-auto">
      {{ Auth::user()->jenisPengguna->nama_jenis_pengguna ?? 'Guest' }}
    </span>
  </div>
</nav>

<!-- Dropdown Script -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const dropdownToggles = document.querySelectorAll(".dropdown-toggle");

    dropdownToggles.forEach(toggle => {
      toggle.addEventListener("click", function () {
        const dropdownMenu = this.nextElementSibling;

        if (dropdownMenu.classList.contains("show")) {
          dropdownMenu.classList.remove("show");
        } else {
          // Close other open dropdowns
          document.querySelectorAll(".dropdown-menu.show").forEach(menu => {
            menu.classList.remove("show");
          });

          dropdownMenu.classList.add("show");
        }
      });
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function (e) {
      if (!e.target.closest(".dropdown")) {
        document.querySelectorAll(".dropdown-menu.show").forEach(menu => {
          menu.classList.remove("show");
        });
      }
    });
  });
</script>