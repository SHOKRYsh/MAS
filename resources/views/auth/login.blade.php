@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card login-card shadow-lg">
                <div class="card-body p-5">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf

                        <!-- Phone Input -->
                        <div class="mb-4">
                            <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-phone text-muted"></i>
                                </span>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}" 
                                       placeholder="Enter your phone number" required autofocus>
                            </div>
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-decoration-none small">
                                        {{ __('Forgot Password?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Enter your password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="mb-4 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                {{ __('Login') }}
                            </button>
                        </div>

                        <!-- Social Login (Optional) -->
                        <div class="text-center mb-4">
                            <p class="text-muted mb-3">— Or sign in with —</p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#" class="btn btn-outline-primary social-btn">
                                    <i class="fab fa-google"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary social-btn">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary social-btn">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Registration Link -->
                        @if (Route::has('register'))
                            <div class="text-center">
                                <p class="mb-0">{{ __("Don't have an account?") }}
                                    <a href="{{ route('register') }}" class="text-decoration-none">
                                        {{ __('Create one') }}
                                    </a>
                                </p>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePassword = document.querySelector('.toggle-password');
        const password = document.querySelector('#password');
        
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye-slash');
            this.querySelector('i').classList.toggle('fa-eye');
        });

        // Add floating label effect
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('.input-group-text').style.backgroundColor = '#e9ecef';
            });
            input.addEventListener('blur', function() {
                this.parentElement.querySelector('.input-group-text').style.backgroundColor = '';
            });
        });
    });
</script>
@endsection

<style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #f8f9fc;
    }

    body {
        background-color: var(--secondary-color);
        background-image: linear-gradient(180deg, var(--secondary-color) 10%, #dbe2ef 100%);
        background-size: cover;
    }

    .login-container {
        padding: 2rem;
    }

    .login-card {
        border-radius: 1rem;
        border: none;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .login-logo {
        max-height: 80px;
        width: auto;
    }

    .login-title {
        font-weight: 600;
        color: var(--primary-color);
    }

    .login-form .form-control {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
    }

    .login-form .input-group-text {
        border-radius: 0.5rem 0 0 0.5rem !important;
        transition: background-color 0.3s ease;
    }

    .toggle-password {
        border-radius: 0 0.5rem 0.5rem 0 !important;
        cursor: pointer;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        padding: 0.75rem;
        border-radius: 0.5rem;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #3a5ccc;
        border-color: #3a5ccc;
    }

    .social-btn {
        width: 40px;
        height: 40px;
        border-radius: 50% !important;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .alert {
        border-radius: 0.5rem;
    }

    @media (max-width: 768px) {
        .login-container {
            padding: 1rem;
        }
        
        .login-card {
            border-radius: 0.75rem;
        }
    }
</style>
@endsection