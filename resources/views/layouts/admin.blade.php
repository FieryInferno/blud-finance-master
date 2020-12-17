<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Dashboard &mdash; {{ config('app.name') }}</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-4.3.1.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/iziToast.min.css') }}">
  @yield('css')
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ asset('img/logo.png') }}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hai, {{ Auth::user()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="" class="dropdown-item has-icon">
                <i class="fa fa-user"></i> Profil Saya
              </a>
              <a href="" class="dropdown-item has-icon">
                <i class="fa fa-cog"></i> Pengaturan Umum
              </a>
              
              @if (Auth::user()->hasRole('admin'))
              <a href="" class="dropdown-item has-icon">
                  <i class="fa fa-users"></i> Pengguna
                </a>
              @endif
              <div class="dropdown-divider"></div>
              <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Keluar Aplikasi
              </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ route('admin.index') }}">{{ config('app.name') }}</a>
            
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.index') }}">BLUD</a>
          </div>
          <ul class="sidebar-menu">
              <li class="nav-item dropdown{{ Request::routeIs('admin.index') == 1 ? ' active' : '' }}">
              <a href="{{ route('admin.index') }}" class="nav-link"><i class="fas fa-home"></i><span>Beranda</span></a>
              </li>
              <li class="nav-item dropdown {{ Request::is('finance/pengaturan/*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                  <i class="fas fa-cog"></i> <span>Pengaturan</span>
                </a>
                <ul class="dropdown-menu" style="display:{{ Request::is('finance/pengaturan/*') ? 'block' : 'none' }}">
                  <li class="{{ Request::routeIs('admin.prefix.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.prefix.index') }}">Prefix Penomoran</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown {{ Request::is('finance/organisasi/*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                  <i class="fas fa-th"></i> <span>BLUD</span>
                </a>
                <ul class="dropdown-menu" style="display:{{ Request::is('finance/organisasi/*') ? 'block' : 'none' }}">
                  <li class="{{ Request::routeIs('admin.urusan.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.urusan.index') }}">Urusan</a></li>
                  <li class="{{ Request::routeIs('admin.fungsi.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.fungsi.index') }}">Fungsi</a></li>
                  <li class="{{ Request::routeIs('admin.bidang.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.bidang.index') }}">Bidang</a></li>
                  <li class="{{ Request::routeIs('admin.program.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.program.index') }}">Program</a></li>
                  <li class="{{ Request::routeIs('admin.kegiatan.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.kegiatan.index') }}">Kegiatan</a></li>
                  <li class="{{ Request::routeIs('admin.unit_kerja.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.unit_kerja.index') }}">Unit Kerja</a></li>
                  <li class="{{ Request::routeIs('admin.opd.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.opd.index') }}">OPD</a></li>
                  <li class="{{ Request::routeIs('admin.pemetaan_akun.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.pemetaan_akun.index') }}">Pemetaan Akun</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown {{ Request::is('finance/data-dasar/*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                  <i class="fas fa-database"></i> <span>Master RBA</span>
                </a>
                <ul class="dropdown-menu" style="display:{{ Request::is('finance/data-dasar/*') ? 'block' : 'none' }}">
                  <li class="{{ Request::routeIs('admin.pejabat.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.pejabat.index') }}">Pejabat Daerah</a></li>
                  <li class="{{ Request::routeIs('admin.sumber_dana.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.sumber_dana.index') }}">Sumber Dana</a></li>
                  <li class="{{ Request::routeIs('admin.ssh.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.ssh.index') }}">Standar Satuan Harga</a></li>
                  <li class="{{ Request::routeIs('admin.map_kegiatan.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.map_kegiatan.index') }}">Pemetaan Kegiatan</a></li>
                  <li class="{{ Request::routeIs('admin.map_akun.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.map_akun.index') }}">Pemetaan Akun</a></li>
                  <li class="{{ Request::routeIs('admin.rekening_bendahara.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.rekening_bendahara.index') }}">Rek. Bendahara BLUD</a></li>
                  <li class="{{ Request::routeIs('admin.pajak.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.pajak.index') }}">Pajak</a></li>
                  <li class=""><a class="nav-link" href="">Pemetaan Rek. Akuntansi</a></li>
                  <li class=""><a class="nav-link" href="">Setting Jurnal Akuntansi</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown {{ Request::is('finance/pendapatan/*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                  <i class="fas fa-money-bill"></i> <span>Pendapatan</span>
                </a>
                <ul class="dropdown-menu" style="display:{{ Request::is('finance/pendapatan/*') ? 'block' : 'none' }}">
                  <li class="{{ Request::routeIs('admin.tbp.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.tbp.index') }}">TBP Pendapatan</a></li>
                  <li class="{{ Request::routeIs('admin.sts.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.sts.index') }}">STS Pendapatan</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown {{ Request::is('finance/belanja/*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                  <i class="fas fa-cart-plus"></i> <span>Belanja</span>
                </a>
                <ul class="dropdown-menu" style="display:none">
                  <li class="{{ Request::routeIs('admin.spd.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.spd.index') }}">SPD Belanja</a></li>
                  <li class="{{ Request::routeIs('admin.pihak_ketiga.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.pihak_ketiga.index') }}">Pihak Ketiga</a></li>
                  <li class="{{ Request::routeIs('admin.bast.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.bast.index') }}">Bukti Transaksi</a></li>
                  <li class="{{ Request::routeIs('admin.spp.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.spp.index') }}">SPP Belanja</a></li>
                  <li class="{{ Request::routeIs('admin.verifikasispp.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.verifikasispp.index') }}">Verifikasi SPP</a></li>
                  <li class="{{ Request::routeIs('admin.sp2d.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.sp2d.index') }}">SP2D Belanja</a></li>
                  <li class="{{ Request::routeIs('admin.setor_pajak.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.setor_pajak.index') }}">Setor Pajak</a></li>
                </ul>
              </li>
               <li class="nav-item dropdown{{ Request::routeIs('admin.kontrapos.*') == 1 ? ' active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                  <i class="fas fa-undo"></i> <span>Pengembalian</span>
                </a>
                <ul class="dropdown-menu" style="display:none">
                  <li class="{{ Request::routeIs('admin.kontrapos.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.kontrapos.index') }}">Kontrapos Belanja</a></li>
                </ul>

               </li>
              <li class="nav-item dropdown{{ Request::routeIs('admin.bku.*') == 1 ? ' active' : '' }}">
                <a href="{{ route('admin.bku.index') }}" class="nav-link"><i class="fas fa-clipboard-list"></i><span>BKU BLUD</span></a>
              </li>
              <li class="nav-item dropdown{{ Request::routeIs('admin.sp3bp.*') == 1 ? ' active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                  <i class="fas fa-money-bill"></i> <span>SP3B - SPTJ</span>
                </a>
                <ul class="dropdown-menu" style="display:none">
                  <li class="{{ Request::routeIs('admin.sp3bp.*') == 1 && Request::routeIs('admin.sp3bp.verificationview') != 1 ? 'active' : '' }}">
                    <a href="{{ route('admin.sp3bp.index') }}" class="nav-link"><i class="fas fa-file-invoice"></i><span>SP3B</span></a>
                  </li>
                  <li class="{{ Request::routeIs('admin.sp3bp.verificationview') == 1 ? 'active' : '' }}">
                    <a href="{{ route('admin.sp3bp.verificationview') }}" class="nav-link"><i class="fas fa-file-invoice"></i><span>Verifikasi SP3B</span></a>
                    </li>
                  
                </ul>
              </li>
              <li class="nav-item dropdown{{ Request::routeIs('admin.laporan.*') == 1 ? ' active' : '' }}">
                <a href="{{ route('admin.laporan.index') }}" class="nav-link"><i class="fas fa-file"></i><span>Laporan</span></a>
              </li>
               <li class="nav-item dropdown {{ Request::is('finance/akuntansi/*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                  <i class="fas fa-money-bill"></i> <span>Akuntansi</span>
                </a>
                <ul class="dropdown-menu" style="display:none">
                  <li class="{{ Request::routeIs('admin.jurnal_penyesuaian.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.jurnal_penyesuaian.index') }}">Jurnal Penyesuaian</a></li>
                  <li class="{{ Request::routeIs('admin.saldo_lo.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.saldo_lo.index') }}">Saldo Awal LO</a></li>
                  <li class="{{ Request::routeIs('admin.saldo_neraca.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.saldo_neraca.index') }}">Saldo Awal Neraca</a></li>
                  <li class="{{ Request::routeIs('admin.jurnal_umum.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.jurnal_umum.index') }}">Jurnal Umum</a></li>
                  <li class="{{ Request::routeIs('admin.setup_jurnal.*') == 1 ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.setup_jurnal.index') }}">Setup Jurnal</a></li>
                </ul>
              </li>
            </ul>

            {{-- <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
              <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
              </a>
            </div> --}}
        </aside>
      </div>

      <!-- Main Content -->
      @yield('content')

      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; {{ date('Y') }} <div class="bullet"></div> {{ config('app.name') }}
        </div>
        <div class="footer-right">
          {{ config('app.version') }}
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('dashboard/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('dashboard/js/popper-1.14.7.min.js') }}"></script>
  <script src="{{ asset('dashboard/js/bootstrap-4.3.1.min.js') }}"></script>
  <script src="{{ asset('dashboard/js/jquery.ninescroll-3.7.6.min.js') }}"></script>
  <script src="{{ asset('dashboard/js/moment-2.24.min.js') }}"></script>
  <script src="{{ asset('dashboard/js/stisla.js') }}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('dashboard/js/iziToast.min.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('dashboard/js/scripts.js') }}"></script>
  <script src="{{ asset('dashboard/js/custom.js') }}"></script>
  <script src="{{ asset('dashboard/js/jquery.maskMoney.min.js') }}"></script>

  <!-- Page Specific JS File -->
  @yield('js')
</body>
</html>
