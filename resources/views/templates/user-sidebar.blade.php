<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
      <img src="{{ URL::asset('/') }}LTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ URL::asset('/') }}LTE/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          @php
              $link = null;
              $idLevel = session::get('idLevel');
              $fitur = DB::table('fitur')->get();
              $usersLevel = DB::table('akses_detail as a')
                            ->where('a.id_akses', $idLevel)
                            ->leftJoin('fitur as b', 'b.id', '=', 'a.id_fitur')
                            ->select(
                                      'a.*', 
                                      'b.nama as fitur', 'b.route', 'b.icon', 'b.parent_id'
                                      )
                            ->get();

              $dt = [];
              foreach ($usersLevel as $k => $v) {
                if (is_null($v->parent_id)) {
                  $dt [] = [
                            'fitur' => $v->fitur,
                            'route' => $v->route,
                            'icon' => $v->icon,
                            'child' => null,
                        ];
                }else {
                  $getParent = collect($fitur)
                                ->where('id', $v->parent_id)->first();
                  $getChild = collect($usersLevel)
                                ->where('parent_id', $v->parent_id)
                                ->map(function ($v) {
                                  return (object)[
                                    'fitur' => $v->fitur,
                                    'route' => $v->route,
                                    'icon' => $v->icon,
                                    'child' => null
                                  ];
                                })->toArray();
                  $dt [] = [
                            '_' => $getParent,
                            'fitur' => $getParent->nama,
                            'route' => $getParent->route,
                            'icon' => $getParent->icon,
                            'child' => $getChild,
                        ];
                }
              }

              // dd($dt);
              // dd($usersLevel);
          @endphp

          @foreach ($dt as $item)
            @php
                if ( !is_null($item['child']) ) {
                  $link = '#';
                }else {
                  $link = route($item['route']);
                }
            @endphp
            <li class="nav-item">
              <a href="{{ $link }}" class="nav-link">
                <i class="nav-icon {{ $item['icon'] }}"></i>
                <p>{{ $item['fitur'] }}</p>
                @if(is_null($item['route'])) <i class="right fas fa-angle-left"></i> @endif
              </a>
              @if (is_null($item['route']))
              <ul class="nav nav-treeview">
                @foreach ($item['child'] as $item)
                <li class="nav-item">
                  <a href="{{ route($item->route) }}" class="nav-link">
                    <i class="far {{ $item->icon }}"></i>
                    <p>{{ $item->fitur }}</p>
                  </a>
                </li>    
                @endforeach
              </ul>
              @endif
            </li>
          @endforeach
          {{-- <li class="nav-item">
            <a href="{{ route('login') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Login</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Dashboard</p>
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
            <a href="{{ route('perusahaan') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Perusahaan</p>
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
          <li class="nav-item">
            <a href="{{ route('user-roles-form') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Form User Roles</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Setting Hak Akses</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{ route('kebun') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Kebun</p>
            </a>
          </li> --}}
        </ul>
      </nav>
    </div>
  </aside>