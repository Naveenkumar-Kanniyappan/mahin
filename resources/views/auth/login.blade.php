@extends('layouts.admin')

@section('content')
<div class="login-container">
    <div class="login-wrapper">
        <div class="login-card">
            <!-- Header Section -->
            <div class="login-header">
                <div class="company-logo">
                    <h1>MAHIN FACILITY</h1>
                    <p>SERVICES</p>
                </div>
                <h2 class="login-title">Admin Login</h2>
                <p class="login-subtitle">Access your dashboard</p>
            </div>
            
            <!-- Login Form -->
            <div class="login-form-container">
                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i>
                            Email Address
                        </label>
                        <input id="email" 
                               type="email" 
                               class="form-input @error('email') is-invalid @enderror" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="email" 
                               autofocus
                               placeholder="Enter your email address">
                        @error('email')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i>
                            Password
                        </label>
                        <div class="password-input-wrapper">
                            <input id="password" 
                                   type="password" 
                                   class="form-input @error('password') is-invalid @enderror" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="Enter your password">
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="passwordToggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="remember-me">
                            <input class="remember-checkbox" 
                                   type="checkbox" 
                                   name="remember" 
                                   id="remember" 
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="remember-label" for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="login-btn">
                            <i class="fas fa-sign-in-alt"></i>
                            Login to Dashboard
                        </button>

                        @if (Route::has('password.request'))
                            <a class="forgot-password" href="{{ route('password.request') }}">
                                <i class="fas fa-question-circle"></i>
                                Forgot Your Password?
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Back to Application Form -->
            <div class="back-to-app">
                <a href="{{ route('application.form') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Back to Application Form
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.login-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.login-wrapper {
    width: 100%;
    max-width: 450px;
}

.login-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    animation: slideInUp 0.6s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.login-header {
    background: linear-gradient(135deg, #2196F3, #1976D2);
    color: white;
    padding: 40px 30px 30px;
    text-align: center;
    position: relative;
}

.login-header::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 15px solid transparent;
    border-right: 15px solid transparent;
    border-top: 10px solid #1976D2;
}

.company-logo h1 {
    font-size: 28px;
    font-weight: bold;
    margin: 0;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.company-logo p {
    font-size: 14px;
    margin: 0;
    opacity: 0.9;
    letter-spacing: 2px;
}

.login-title {
    font-size: 24px;
    margin: 20px 0 5px;
    font-weight: 600;
}

.login-subtitle {
    font-size: 14px;
    opacity: 0.9;
    margin: 0;
}

.credentials-info {
    background: #e3f2fd;
    border-left: 4px solid #2196F3;
    margin: 20px;
    border-radius: 8px;
    overflow: hidden;
}

.info-header {
    background: #2196F3;
    color: white;
    padding: 12px 15px;
    font-weight: 600;
    font-size: 14px;
}

.info-header i {
    margin-right: 8px;
}

.credentials-details {
    padding: 15px;
}

.credential-item {
    margin-bottom: 8px;
    font-size: 14px;
    color: #1976D2;
}

.credential-item:last-child {
    margin-bottom: 0;
}

.login-form-container {
    padding: 0 30px 30px;
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
    font-size: 14px;
}

.form-label i {
    margin-right: 8px;
    color: #2196F3;
    width: 16px;
}

.form-input {
    width: 100%;
    padding: 15px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: #fafafa;
}

.form-input:focus {
    outline: none;
    border-color: #2196F3;
    background: white;
    box-shadow: 0 0 15px rgba(33, 150, 243, 0.2);
    transform: translateY(-1px);
}

.form-input.is-invalid {
    border-color: #f44336;
    background: #ffebee;
}

.password-input-wrapper {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #666;
    cursor: pointer;
    font-size: 16px;
    padding: 5px;
}

.password-toggle:hover {
    color: #2196F3;
}

.error-message {
    color: #f44336;
    font-size: 13px;
    margin-top: 8px;
    display: flex;
    align-items: center;
}

.error-message i {
    margin-right: 5px;
}

.remember-me {
    display: flex;
    align-items: center;
}

.remember-checkbox {
    margin-right: 10px;
    transform: scale(1.2);
}

.remember-label {
    font-size: 14px;
    color: #666;
    cursor: pointer;
}

.form-actions {
    text-align: center;
}

.login-btn {
    width: 100%;
    background: linear-gradient(135deg, #2196F3, #1976D2);
    color: white;
    border: none;
    padding: 15px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 15px;
}

.login-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(33, 150, 243, 0.4);
}

.login-btn i {
    margin-right: 8px;
}

.forgot-password {
    color: #2196F3;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.3s ease;
}

.forgot-password:hover {
    color: #1976D2;
    text-decoration: underline;
}

.forgot-password i {
    margin-right: 5px;
}

.back-to-app {
    background: #f5f5f5;
    padding: 20px;
    text-align: center;
    border-top: 1px solid #e0e0e0;
}

.back-link {
    color: #666;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.3s ease;
}

.back-link:hover {
    color: #2196F3;
}

.back-link i {
    margin-right: 8px;
}

@media (max-width: 768px) {
    .login-container {
        padding: 10px;
    }
    
    .login-card {
        margin: 0;
    }
    
    .login-header {
        padding: 30px 20px 20px;
    }
    
    .login-form-container {
        padding: 0 20px 20px;
    }
    
    .credentials-info {
        margin: 15px;
    }
}
</style>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('passwordToggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

// Auto-fill credentials on page load
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    
    // Pre-fill email if empty
    if (!emailInput.value) {
        emailInput.value = 'admin@mahinfacility.com';
    }
});
</script>
@endsection
