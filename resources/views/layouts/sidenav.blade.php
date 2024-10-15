<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html" target="_blank">
      <img src="{{ asset('public/img/headerlogo.png')}}" class="navbar-brand-img h-100 rounded-circle" alt="main_logo">
      <span class="ms-1 font-weight-bold">Admin Dashboard </span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    @can('Manage Roles')
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#manage-roles-perm" aria-expanded="false" aria-controls="manage-roles-perm">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-badge text-warning text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Roles And Permissions </span>
        </a>
        <ul class="navbar-nav flex-column collapse @if(request()->is('roles') || request()->is('permissions')) show @endif" id="manage-roles-perm">
          <li class="nav-item">
            <a class="nav-link @if(request()->is('roles')) active @endif" href="{{url('roles')}}">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-circle-08 text-primary text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Roles </span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if(request()->is('permissions')) active @endif" href="{{url('permissions')}}">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-key-25 text-warning text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Permissions</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
    @endcan
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#manage-users" aria-expanded="false" aria-controls="manage-users">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-single-02 text-success text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1"> Manage Users </span>
        </a>
        <ul class="navbar-nav flex-column collapse @if(request()->is('users') || request()->is('')) show @endif" id="manage-users">
          <li class="nav-item">
            <a class="nav-link @if(request()->is('users')) active @endif" href="{{url('users')}}">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-user-run text-primary text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1"> All Users </span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
  <script>
    $(document).ready(function() {
      $('.collapse').on('show.bs.collapse', function() {
        // Close other collapsible menus
        $('.collapse.show').not($(this)).collapse('hide');

        // Toggle icon direction
        $(this).next().find('i').removeClass('fa-angle-right').addClass('fa-angle-down');
      });

      $('.collapse').on('hide.bs.collapse', function() {
        // Toggle icon direction
        $(this).next().find('i').removeClass('fa-angle-down').addClass('fa-angle-right');
      });
    });
  </script>

</aside>