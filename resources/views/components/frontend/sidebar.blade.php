    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
            <a href="index.html" class="app-brand-link">
                <span class="app-brand-logo demo">
                </span>
                <span class="app-brand-text demo menu-text fw-bold ms-2">Cloud</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
            </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">
         <!-- Dashboards -->
        
            <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{route('dashboard')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-smile"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>

            <!-- Users -->
            <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                <a href="{{route('users.index')}}" class="menu-link">
                    <i class="menu-icon icon-base bx bx-chat"></i>
                    <div data-i18n="Users">Users</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                <a href="{{route('orders.index')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-collection"></i>
                    <div data-i18n="Orders">Orders</div>
                </a>
            </li> 
     
        </ul>
    
    </aside>