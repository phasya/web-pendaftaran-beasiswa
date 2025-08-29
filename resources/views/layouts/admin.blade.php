    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Admin Dashboard')</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    :root {
        --yellow-primary: #facc15;
        /* Kuning utama */
        --yellow-secondary: #f59e0b;
        /* Orange-kuning */
        --yellow-dark: #d97706;
        /* Orange gelap */
        --yellow-light: #fef08a;
        /* Kuning pastel */
        --yellow-soft: #fde047;
        /* Soft gold */
        --yellow-hover: #eab308;
        /* Hover */
    }

    .navbar {
        transition: all 0.3s ease-in-out;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background: linear-gradient(135deg, var(--yellow-primary), var(--yellow-secondary), var(--yellow-dark)) !important;
    }

    .navbar.sticky {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1030;
        background: rgba(250, 204, 21, 0.95) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    body.navbar-fixed {
        padding-top: 76px;
    }

    html {
        scroll-behavior: smooth;
    }

    .navbar-brand {
        transition: transform 0.2s ease;
        font-weight: 600;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    .navbar-brand:hover {
        transform: scale(1.05);
        color: #ffffff !important;
    }

    .navbar-nav .nav-link {
        position: relative;
        transition: color 0.3s ease;
        font-weight: 500;
        color: #ffffff !important;
    }

    .navbar-nav .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 50%;
        background: linear-gradient(90deg, #fff, var(--yellow-light));
        transition: all 0.3s ease;
        transform: translateX(-50%);
        box-shadow: 0 0 8px rgba(255, 255, 255, 0.8);
    }

    .navbar-nav .nav-link:hover::after {
        width: 80%;
    }

    .navbar-nav .nav-link:hover {
        color: #f8f9fa !important;
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
        margin-top: 8px;
    }

    .dropdown-item:hover {
        background: linear-gradient(45deg, var(--yellow-primary), var(--yellow-dark));
        color: white;
        transform: translateX(5px);
    }

    .sidebar {
        background: linear-gradient(180deg, #fffde7 0%, #fff9c4 100%) !important;
        box-shadow: 2px 0 4px rgba(0, 0, 0, 0.1);
        min-height: calc(100vh - 56px);
        padding-top: 1rem;
    }

    .sidebar .nav-link {
        color: #495057;
        padding: 0.75rem 1rem;
        margin: 0.2rem 0.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
        position: relative;
    }

    .sidebar .nav-link:hover {
        background: linear-gradient(45deg, var(--yellow-primary), var(--yellow-secondary));
        color: white;
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(250, 204, 21, 0.3);
    }

    .sidebar .nav-link.active {
        background: linear-gradient(45deg, var(--yellow-primary), var(--yellow-dark));
        color: white;
        box-shadow: 0 4px 15px rgba(250, 204, 21, 0.4);
    }

    .sidebar .nav-link.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 100%;
        background: white;
        border-radius: 0 4px 4px 0;
    }

    .sidebar .nav-link i {
        width: 20px;
        margin-right: 10px;
    }

    main {
        background: #fefefe;
        min-height: calc(100vh - 56px);
        padding: 1.5rem;
    }

    .alert-success {
        background: linear-gradient(45deg, var(--yellow-dark), var(--yellow-secondary));
        color: white;
    }

    .alert-danger {
        background: linear-gradient(45deg, #dc3545, #fd7e14);
        color: white;
    }

    .btn-primary {
        background: linear-gradient(45deg, var(--yellow-primary), var(--yellow-dark));
        border: none;
        transition: all 0.3s ease;
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, var(--yellow-hover), var(--yellow-secondary));
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(250, 204, 21, 0.4);
    }

    .card-header {
        background: linear-gradient(45deg, #fffde7, #fff9c4);
        border-bottom: 1px solid rgba(250, 204, 21, 0.2);
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, var(--yellow-primary), var(--yellow-dark));
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, var(--yellow-hover), var(--yellow-secondary));
    }
</style>

    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark" id="mainNavbar">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-user-shield"></i> Admin Panel
                </a>
                
                <!-- Mobile toggle button -->
                <button class="navbar-toggler d-md-none" type="button" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="navbar-nav ms-auto">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('home') }}">
                                <i class="fas fa-home"></i> Lihat Website
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-3 col-lg-2 d-md-block sidebar" id="sidebar">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                                href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.beasiswa.*') ? 'active' : '' }}" 
                                href="{{ route('admin.beasiswa.index') }}">
                                    <i class="fas fa-graduation-cap"></i> Kelola Beasiswa
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.pendaftar.*') ? 'active' : '' }}" 
                                href="{{ route('admin.pendaftar.index') }}">
                                    <i class="fas fa-users"></i> Kelola Pendaftar
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Main content -->
                <main class="col-md-9 ms-sm-auto col-lg-10">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>

        <div class="sidebar-overlay d-md-none" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const navbar = document.getElementById('mainNavbar');
                const body = document.body;
                let lastScrollTop = 0;
                
                function handleScroll() {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    
                    if (scrollTop > 100) {
                        navbar.classList.add('sticky');
                        body.classList.add('navbar-fixed');
                    } else {
                        navbar.classList.remove('sticky');
                        body.classList.remove('navbar-fixed');
                    }
                    
                    lastScrollTop = scrollTop;
                }
                
                let ticking = false;
                function requestTick() {
                    if (!ticking) {
                        requestAnimationFrame(handleScroll);
                        ticking = true;
                        setTimeout(() => ticking = false, 16);
                    }
                }
                
                window.addEventListener('scroll', requestTick);
            });

            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                
                if (sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    overlay.style.display = 'none';
                } else {
                    sidebar.classList.add('show');
                    overlay.style.display = 'block';
                }
            }

            document.addEventListener('click', function(e) {
                const sidebar = document.getElementById('sidebar');
                const toggleBtn = document.querySelector('.navbar-toggler');
                
                if (window.innerWidth < 768 && 
                    !sidebar.contains(e.target) && 
                    !toggleBtn.contains(e.target) &&
                    sidebar.classList.contains('show')) {
                    toggleSidebar();
                }
            });
        </script>
        
        <style>

        </style>
        
        @yield('scripts')
    </body>
    </html>