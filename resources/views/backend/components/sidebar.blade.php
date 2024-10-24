  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
          <img src=" {{ asset('backend') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
              class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">SoftNestBd</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">


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
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item menu-open">
                      <a href="{{ route('home') }}" class="nav-link active">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>

                  {{-- Devider  --}}
                  <li class="nav-header">DASHBOARDS</li>

                  {{-- New Widgets Sigle with Alert Badge --}}
                  {{-- <li class="nav-item">
                      <a href="pages/widgets.html" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Widgets
                              <span class="right badge badge-danger">New</span>
                          </p>
                      </a>
                  </li> --}}


                  {{-- Muliple with bagde  --}}
                  {{-- <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-copy"></i>
                          <p>
                              Layout Options
                              <i class="fas fa-angle-left right"></i>
                              <span class="badge badge-info right">6</span>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="pages/layout/top-nav.html" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Top Navigation</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Top Navigation + Sidebar</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="pages/layout/boxed.html" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Boxed</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="pages/layout/fixed-sidebar.html" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Fixed Sidebar</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="pages/layout/fixed-sidebar-custom.html" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Fixed Sidebar <small>+ Custom Area</small></p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="pages/layout/fixed-topnav.html" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Fixed Navbar</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="pages/layout/fixed-footer.html" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Fixed Footer</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="pages/layout/collapsed-sidebar.html" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Collapsed Sidebar</p>
                              </a>
                          </li>
                      </ul>
                  </li> --}}

                  {{-- Devider  --}}
                  {{-- <li class="nav-header">EXAMPLES</li> --}}

                  {{-- Single with primary badge --}}
                  {{-- <li class="nav-item">
                      <a href="pages/calendar.html" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>
                              Calendar
                              <span class="badge badge-info right">2</span>
                          </p>
                      </a>
                  </li> --}}

                  {{-- Role & Permission  --}}
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon far fa-envelope"></i>
                          <p>
                              Role & Permission
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('permission.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Permission</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('role.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Role</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('user.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>User</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  {{-- <li class="nav-item">
                      <a href="pages/gallery.html" class="nav-link">
                          <i class="nav-icon fas fa-phone-alt"></i>
                          <p>
                              Gallery
                          </p>
                      </a>
                  </li> --}}
                

              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
