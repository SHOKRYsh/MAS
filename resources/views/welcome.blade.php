@extends('layouts.app')

@section('content')
<div class="welcome-container">
    <div class="row justify-content-center align-items-center min-vh-80">
        <div class="col-lg-8 col-md-10">
            <div class="welcome-card shadow-lg">
                <div class="card-header text-center py-4">
                    <h1 class="display-5 fw-bold text-primary">{{ __('Welcome to Our Learning Platform') }}</h1>
                    <p class="lead text-muted mt-2">{{ __('Empowering education through technology and language') }}</p>
                </div>

                <div class="card-body px-5 pb-5">
                    <div class="text-center mb-5">
                        <p class="welcome-intro">{{ __('Discover our comprehensive learning programs designed to help you excel in both technology and language skills.') }}</p>
                    </div>
                    
                    <div class="row g-4">
                        <!-- Technology Card -->
                        <div class="col-lg-6">
                            <div class="subject-card h-100 shadow-sm">
                                <div class="card-header bg-tech text-white d-flex align-items-center">
                                    <i class="fas fa-laptop-code me-3 fs-4"></i>
                                    <h3 class="mb-0">{{ __('Technology') }}</h3>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{ __('Technology is constantly evolving, shaping the future of humanity. From advancements in artificial intelligence to the growth of the internet of things (IoT), technology plays a vital role in every aspect of our lives.') }}</p>
                                    <div class="tech-features mt-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Hands-on coding exercises</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Latest tech stack training</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Real-world project experience</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0 text-end">
                                    <a href="#" class="btn btn-outline-primary">{{ __('Explore') }} <i class="fas fa-arrow-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- English Card -->
                        <div class="col-lg-6">
                            <div class="subject-card h-100 shadow-sm">
                                <div class="card-header bg-english text-white d-flex align-items-center">
                                    <i class="fas fa-book-open me-3 fs-4"></i>
                                    <h3 class="mb-0">{{ __('English') }}</h3>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{ __('English is one of the most widely spoken languages in the world. As a global lingua franca, it connects people from different cultures and backgrounds, opening doors to communication, education, and business.') }}</p>
                                    <div class="english-features mt-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Comprehensive language courses</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Interactive speaking practice</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Cultural immersion activities</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0 text-end">
                                    <a href="#" class="btn btn-outline-primary">{{ __('Explore') }} <i class="fas fa-arrow-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-5">
                        <p class="text-muted">{{ __('Ready to get started?') }}</p>
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 me-3">
                                <i class="fas fa-sign-in-alt me-2"></i> {{ __('Login') }}
                            </a>
                        @endif
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-4">
                                <i class="fas fa-user-plus me-2"></i> {{ __('Register') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .welcome-container {
        padding: 3rem 1rem;
        background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
        min-height: calc(100vh - 56px);
    }
    
    .welcome-card {
        border-radius: 1rem;
        border: none;
        overflow: hidden;
    }
    
    .subject-card {
        border-radius: 0.75rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }
    
    .subject-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .bg-tech {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    
    .bg-english {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
    }
    
    .welcome-intro {
        font-size: 1.1rem;
        color: #5a5c69;
        max-width: 700px;
        margin: 0 auto;
    }
    
    .card-header {
        padding: 1.25rem 1.5rem;
    }
    
    @media (max-width: 768px) {
        .welcome-container {
            padding: 2rem 0.5rem;
        }
        
        .welcome-card {
            border-radius: 0.5rem;
        }
        
        .display-5 {
            font-size: 2rem;
        }
    }
</style>
@endsection