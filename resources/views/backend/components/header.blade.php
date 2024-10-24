  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="index3.html" class="nav-link">Home</a>
          </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-bell"></i>
                  <span class="badge badge-warning navbar-badge">15</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <span class="dropdown-item dropdown-header">15 Notifications</span>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <i class="fas fa-envelope mr-2"></i> 4 new messages
                      <span class="float-right text-muted text-sm">3 mins</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <i class="fas fa-users mr-2"></i> 8 friend requests
                      <span class="float-right text-muted text-sm">12 hours</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <i class="fas fa-file mr-2"></i> 3 new reports
                      <span class="float-right text-muted text-sm">2 days</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
              </div>
          </li>
          {{-- Expandable button  --}}
          <li class="nav-item">
              <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                  <i class="fas fa-expand-arrows-alt"></i>
              </a>
          </li>

          <!-- Messages Dropdown Menu -->
          <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-user"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <!-- User Info Start -->
                  <div class="media p-3">
                      <img src="{{ asset('backend') }}/dist/img/user1-128x128.jpg" alt="User Avatar"
                          class="img-size-50 mr-3 img-circle">
                      <div class="media-body">
                          <h3 class="dropdown-item-title">
                              Welcome
                          </h3>
                          <p class="text-sm">Username</p>
                      </div>
                  </div>
                  <!-- User Info End -->

                  <div class="dropdown-divider"></div>

                  <!-- User Actions -->
                  <a href="#" class="dropdown-item">
                      <i class="fas fa-user mr-2"></i> Profile
                  </a>
                  <a href="#" class="dropdown-item">
                      <i class="fas fa-cog mr-2"></i> Settings
                  </a>
                  {{-- <a href="#" class="dropdown-item">
                      <i class="fas fa-sign-out-alt mr-2"></i> Logout
                  </a> --}}
                  <a class="dropdown-item" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="fas fa-sign-out-alt mr-2"></i>
                      {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
              </div>
          </li>

      </ul>
  </nav>
