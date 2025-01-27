<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
 

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
 

        <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- Place this tag where you want the button to render. -->
        
        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a
            class="nav-link dropdown-toggle hide-arrow p-0"
            href="javascript:void(0);"
            data-bs-toggle="dropdown">
            <div class="avatar avatar-online">
                <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
            </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="#">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                    <div class="avatar avatar-online">
                        <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                    </div>
                    <div class="flex-grow-1">
                    <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                    <small class="text-muted">{{ auth()->user()->role }}</small>
                    </div>
                </div>
                </a>
            </li>
            <li>
                <div class="dropdown-divider my-1"></div>
            </li>
            
            
            
            <li>
                <div class="dropdown-divider my-1"></div>
            </li>
            <li>
                <a class="dropdown-item" href="{{route('logout')}}">
                <i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span>
                </a>
            </li>
            </ul>
        </li>
        <!--/ User -->
        </ul>
    </div>
</nav>