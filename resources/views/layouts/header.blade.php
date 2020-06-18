<header class="header">
    <nav class="navbar navbar-expand-lg">

        <div class="container-fluid d-flex align-items-center justify-content-between">

            <div class="navbar-header">
                <!-- Navbar Header-->
                <a href="/" class="navbar-brand">
                    <div class="brand-text brand-big visible text-uppercase">
                        <strong class="text-primary">Code</strong><strong>Solutions</strong>
                    </div>

                    <div class="brand-text brand-sm">
                        <strong class="text-primary">C</strong><strong>S</strong>
                    </div>
                </a>
                <!-- Sidebar Toggle Btn-->
                <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
            </div>

            <div class="right-menu list-inline no-margin-bottom">
                <div class="list-inline-item dropdown">
                    <a id="navbarDropdownMenuLink1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link messages-toggle">
                        <i class="icon-email"></i>
                        <span class="badge dashbg-1">0</span>
                    </a>

                <div aria-labelledby="navbarDropdownMenuLink1" class="dropdown-menu messages">
                    {{-- Notificaciones --}}
                    {{-- <a href="#" class="dropdown-item message d-flex align-items-center">
                        <div class="profile">
                            <img src="/assets/vendor/darkTheme/img/avatar-3.jpg" alt="..." class="img-fluid">
                            <div class="status online"></div>
                        </div>
                        <div class="content">
                            <strong class="d-block">Nadia Halsey</strong>
                            <span class="d-block">lorem ipsum dolor sit amit</span>
                            <small class="date d-block">9:30am</small>
                        </div>
                    </a>

                    <a href="#" class="dropdown-item message d-flex align-items-center">
                        <div class="profile">
                            <img src="/assets/vendor/darkTheme/img/avatar-2.jpg" alt="..." class="img-fluid">
                            <div class="status away"></div>
                        </div>
                        <div class="content">
                            <strong class="d-block">Peter Ramsy</strong>
                            <span class="d-block">lorem ipsum dolor sit amit</span>
                            <small class="date d-block">7:40am</small>
                        </div>
                    </a> --}}
                </div>
            </div>

            <!-- Log out-->
            <div class="list-inline-item logout">
                <form id="logout" action="/logout" method="post">
                    @csrf
                    <a href="javascript:$('#logout').submit();" class="nav-link">
                        <span class="d-none d-sm-inline">Cerrar sesión</span>
                        <i class="icon-logout"></i>
                    </a>
                </form>
            </div>
      </div>
    </nav>
</header>
