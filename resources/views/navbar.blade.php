<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            <i class="fas fa-graduation-cap me-2"></i>MAS
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item px-2">
                    <a class="nav-link d-flex align-items-center" href="{{ url('/') }}">
                        <i class="fas fa-home me-2"></i> 
                        <span class="d-lg-none d-inline">Home</span>
                    </a>
                </li>

                @auth()
                <li class="nav-item px-2">
                    <a class="nav-link d-flex align-items-center" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        <span class="d-lg-none d-inline">Dashboard</span>
                    </a>
                </li>
                @endauth

                @guest()
                <li class="nav-item px-2">
                    <a class="nav-link d-flex align-items-center" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        <span class="d-lg-none d-inline">Login</span>
                    </a>
                </li>
                @else
                <li class="nav-item dropdown px-2">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="me-2 d-flex align-items-center">
                            <span class="d-none d-lg-inline">{{ Auth::guard('admin')->user()->name }}</span>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger d-flex align-items-center"
                                        style="border: none; background: none;">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Navbar styling */
    .navbar {
        padding: 0.5rem 1rem;
        min-height: 60px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .navbar-brand {
        font-size: 1.25rem;
    }
    
    .nav-link {
        font-weight: 500;
        padding: 0.5rem 0.75rem;
        transition: all 0.2s ease;
    }
    
    .nav-link:hover {
        transform: translateY(-2px);
    }
    
    .dropdown-menu {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-radius: 0.5rem;
    }
    
    .dropdown-item {
        padding: 0.5rem 1.5rem;
        transition: all 0.2s ease;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }
    body {
        padding-top: 60px;
    }
    
    @media (max-width: 991.98px) {
        .navbar-collapse {
            padding: 1rem 0;
        }
        .nav-item {
            margin: 0.25rem 0;
        }
    }
</style>