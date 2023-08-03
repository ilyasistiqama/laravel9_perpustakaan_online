<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('/assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Perpustakaan</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('/assets/dist/img/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->nama }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-header">Menu</li>
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{$menu == 'dashboard' ? 'active': ''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @hasrole('admin')
          <li class="nav-item {{$menu == 'admin-master-kategori-buku' || $menu == 'admin-master-buku' ? 'menu-open': ''}}">
            <a href="#" class="nav-link {{$menu == 'admin-master-kategori-buku' || $menu == 'admin-master-buku' ? 'active': ''}}">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.master-kategori-buku') }}" class="nav-link {{$menu == 'admin-master-kategori-buku' ? 'active': ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori Buku</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.master-buku') }}" class="nav-link {{$menu == 'admin-master-buku' ? 'active': ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buku</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{$menu == 'admin-master-buku' ? 'active': ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buku</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{$menu == 'admin-peminjaman-buku' || $menu == 'admin-denda' ? 'menu-open': ''}}">
            <a href="#" class="nav-link {{$menu == 'admin-peminjaman-buku' || $menu == 'admin-denda' ? 'active': ''}}">
              <i class="nav-icon fas fa-check-double"></i>
              <p>
                Approval
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.peminjaman-buku') }}" class="nav-link {{$menu == 'admin-peminjaman-buku' ? 'active': ''}}">
                <i class="far fa-circle nav-icon"></i>
                  <p>
                    Peminjaman Buku
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.dendam') }}" class="nav-link {{$menu == 'admin-denda' ? 'active': ''}}">
                <i class="far fa-circle nav-icon"></i>
                  <p>
                    Denda
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.member') }}" class="nav-link {{$menu == 'admin-member' ? 'active': ''}}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Member
              </p>
            </a>
          </li> 


          @endhasrole

          @hasrole('member')
          <li class="nav-item">
            <a href="{{ route('member.list-buku') }}" class="nav-link {{$menu == 'list-buku' ? 'active': ''}}">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Buku
              </p>
            </a>
          </li>
          @endhasrole
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>