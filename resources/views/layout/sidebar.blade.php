@php
  $route= Route::current()->getName();
@endphp

<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <div class="navbar-brand m-0 d-flex align-items-center">
        <img src="{{ asset('/img/UNISEC.png') }}" class="navbar-brand-img h-100" alt="main_logo">
        <span style="font-size: 30px" class="ms-3 font-weight-bold">UNISEC</span>
    </div>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link {{$route=='dashboard' ? 'active' : ''}}" href="{{ route('dashboard') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Menu</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{$route=='Anggota'||$route=='createAnggota'||$route=='updateAnggota'||$route=='detailAnggota' ? 'active' : ''}}" href="{{ route('Anggota') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-users text-sm" style="color: #ff0000;"></i>
          </div>
          <span class="nav-link-text ms-1">Anggota</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{$route=='PJ'||$route=='createPJ'||$route=='updatePJ'||$route=='detailPJ' ? 'active' : ''}}" href="{{ route('PJ') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-user-tie text-sm" style="color: #709900;"></i>
          </div>
          <span class="nav-link-text ms-1">PJ</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{$route=='Pengurus'||$route=='createPengurus'||$route=='updatePengurus'||$route=='detailPengurus' ? 'active' : ''}}" href="{{ route('Pengurus') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-user-secret text-sm" style="color: #019391;"></i>
          </div>
          <span class="nav-link-text ms-1">Pengurus</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{$route=='prodi'||$route=='createProdi'||$route=='updateProdi' ? 'active' : ''}}" href="{{ route('prodi') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-building-columns text-sm" style="color: #0054e6;"></i>
          </div>
          <span class="nav-link-text ms-1">Program Studi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{$route=='TA'||$route=='createTA'||$route=='updateTA' ? 'active' : ''}}" href="{{ route('TA') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-regular fa-calendar text-sm" style="color: #9500a8;"></i>
          </div>
          <span class="nav-link-text ms-1">Tahun Akademik</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{$route=='games'||$route=='createGames'||$route=='updateGames' ? 'active' : ''}}" href="{{ route('games') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-gamepad text-sm" style="color: #ff0000;"></i>
          </div>
          <span class="nav-link-text ms-1">Games</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{$route=='User'||$route=='createUser'||$route=='updateUser'||$route=='detailUser' ? 'active' : ''}}" href="{{ route('User') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">User</span>
        </a>
      </li>
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Absensi</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{$route=='Kehadiran'||$route=='createKehadiran'||$route=='updateKehadiran' ? 'active' : ''}}" href="{{ route('Kehadiran') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-clipboard-list text-sm opacity-10" style="color: #a000a3;"></i>
          </div>
          <span class="nav-link-text ms-1">Daftar Kehadiran</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{$route=='Pertemuan'||$route=='createPertemuan'||$route=='updatePertemuan' ? 'active' : ''}}" href="{{ route('Pertemuan') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-handshake fa-xl text-sm" style="color: #00ad0c;"></i>
          </div>
          <span class="nav-link-text ms-1">Pertemuan</span>
        </a>
      </li>
    </ul>
  </div>
</aside>