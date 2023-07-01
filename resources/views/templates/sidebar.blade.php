<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ URL::asset('/') }}LTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">XmartNode</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <i class="fas fa-user"></i>
          {{-- <img src="{{ URL::asset('/') }}LTE/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> --}}
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Session::get('namaPerusahaan') }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          {{-- <li class="nav-item">
            <a href="{{ route('login') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Login</p>
            </a>
          </li> --}}
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('perusahaan') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Perusahaan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('kebun') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Kebun</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('node') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Node</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('fitur') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Fitur</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('akses') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Akses</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{ route('users') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>User</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('user-roles') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>User Roles</p>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a href="{{ route('user-roles-form') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Form User Roles</p>
            </a>
          </li> --}}
          {{-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Setting Hak Akses</p>
            </a>
          </li> --}}
          
          {{-- <li class="nav-item">
            <a href="{{ route('kebun') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Kebun</p>
            </a>
          </li> --}}
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>