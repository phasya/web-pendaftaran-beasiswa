<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Beasiswa')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom mint-blue colors */
        :root {
            --mint-primary: #00c9a7;
            --mint-secondary: #00bcd4;
            --mint-dark: #00a693;
            --mint-light: #4dd0e1;
            --mint-blue: #0891b2;
        }

        /* Sticky Navbar Styles */
        .navbar {
            transition: all 0.3s ease-in-out;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background: linear-gradient(135deg, var(--mint-primary), var(--mint-secondary), var(--mint-blue)) !important;
        }
        
        .navbar.sticky {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            background: rgba(0, 201, 167, 0.95) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        
        /* Body padding to compensate for fixed navbar */
        body.navbar-fixed {
            padding-top: 76px; /* Adjust based on navbar height */
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Enhanced navbar brand animation */
        .navbar-brand {
            transition: transform 0.2s ease;
            font-weight: 600;
            text-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        
        .navbar-brand:hover {
            transform: scale(1.05);
            color: #ffffff !important;
        }
        
        /* Nav links hover effect */
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
            background: linear-gradient(90deg, #fff, var(--mint-light));
            transition: all 0.3s ease;
            transform: translateX(-50%);
            box-shadow: 0 0 8px rgba(255,255,255,0.8);
        }
        
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 80%;
        }

        .navbar-nav .nav-link:hover {
            color: #f8f9fa !important;
            text-shadow: 0 0 10px rgba(255,255,255,0.5);
        }
        
        /* Dropdown menu enhancement */
        .dropdown-menu {
            border: none;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border-radius: 8px;
            margin-top: 8px;
        }
        
        .dropdown-item {
            transition: all 0.2s ease;
            padding: 0.7rem 1.5rem;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(45deg, var(--mint-primary), var(--mint-blue));
            color: white;
            transform: translateX(5px);
        }
        
        /* Navbar toggler for mobile */
        .navbar-toggler {
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 6px;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.25);
        }

        .navbar-toggler-icon {
            filter: brightness(0) invert(1);
        }
        
        /* Mobile navbar improvements */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: rgba(0, 201, 167, 0.96);
                margin-top: 1rem;
                padding: 1rem;
                border-radius: 8px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                border: 1px solid rgba(255,255,255,0.2);
            }
            
            body.navbar-fixed {
                padding-top: 66px;
            }
        }
        
        /* Alert improvements */
        .alert {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
        
        .alert-success {
            background: linear-gradient(45deg, var(--mint-dark), var(--mint-secondary));
            color: white;
        }
        
        .alert-danger {
            background: linear-gradient(45deg, #dc3545, #fd7e14);
            color: white;
        }
        
        /* Footer enhancement */
        footer {
            background: linear-gradient(45deg, #212529, #495057) !important;
        }

        /* Additional mint-blue theme elements */
        .btn-primary {
            background: linear-gradient(45deg, var(--mint-primary), var(--mint-blue));
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, var(--mint-dark), var(--mint-secondary));
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 201, 167, 0.4);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-graduation-cap"></i> Sistem Beasiswa
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('persyaratan') }}">
                            <i class="fas fa-list-check"></i> Persyaratan
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard Admin
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-md-start">
                    <p class="mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>
                        &copy; 2025 Sistem Pendaftaran Beasiswa
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Made with <i class="fas fa-heart text-danger"></i> for Education</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Sticky Navbar Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('mainNavbar');
            const body = document.body;
            let lastScrollTop = 0;
            
            // Function to handle scroll behavior
            function handleScroll() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > 100) {
                    // Add sticky class when scrolled down
                    navbar.classList.add('sticky');
                    body.classList.add('navbar-fixed');
                } else {
                    // Remove sticky class when at top
                    navbar.classList.remove('sticky');
                    body.classList.remove('navbar-fixed');
                }
                
                lastScrollTop = scrollTop;
            }
            
            // Add scroll event listener with throttling for better performance
            let ticking = false;
            function requestTick() {
                if (!ticking) {
                    requestAnimationFrame(handleScroll);
                    ticking = true;
                    setTimeout(() => ticking = false, 16); // ~60fps
                }
            }
            
            window.addEventListener('scroll', requestTick);
            
            // Add active class to current page nav link
            const currentLocation = location.pathname;
            const menuItems = document.querySelectorAll('.navbar-nav .nav-link');
            
            menuItems.forEach(item => {
                if (item.getAttribute('href') === currentLocation) {
                    item.classList.add('active');
                }
            });
            
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        const offsetTop = target.offsetTop - navbar.offsetHeight - 20;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>