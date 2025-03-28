<?php include 'app/views/shares/header.php'; ?>

<style>
    :root {
        --primary-color: #43a047; /* Main green */
        --primary-dark: #2e7d32; /* Dark green */
        --primary-light: #a5d6a7; /* Light green */
        --white: #ffffff;
        --text-dark: #333333;
        --text-muted: #6c757d;
        --border-color: #e9ecef;
        --danger-color: #dc3545; /* Red for errors */
        --light-bg: #f8f9fa;
    }

    /* Page container */
    .auth-container {
        min-height: 100vh;
        background: linear-gradient(135deg, var(--light-bg), var(--border-color));
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    /* Card styles */
    .auth-card {
        background-color: var(--white);
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        border: none;
        overflow: hidden;
        width: 100%;
        max-width: 450px;
        margin: 0 auto;
        position: relative;
    }

    .auth-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(to right, var(--primary-color), var(--primary-light));
    }

    .auth-card-body {
        padding: 2.5rem !important;
    }

    /* Branding and title */
    .auth-logo {
        margin-bottom: 1.5rem;
    }

    .auth-logo img {
        height: 50px;
        width: auto;
    }

    .auth-title {
        color: var(--primary-dark);
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        font-size: 1.75rem;
    }

    .auth-subtitle {
        color: var(--text-muted);
        font-size: 1rem;
        margin-bottom: 2rem;
    }

    /* Form styling */
    .form-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .form-control {
        border-radius: 8px;
        border: 1.5px solid var(--border-color);
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: var(--white);
        color: var(--text-dark);
        width: 100%;
        height: auto;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(67, 160, 71, 0.15);
        outline: none;
    }

    .form-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 1rem;
        color: var(--text-muted);
    }

    .form-label {
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
        display: block;
    }

    /* Button styling */
    .btn-auth {
        background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        color: var(--white);
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 1rem;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .btn-auth::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, var(--primary-dark), var(--primary-color));
        transition: all 0.4s ease;
        z-index: -1;
    }

    .btn-auth:hover::after {
        left: 0;
    }

    .btn-auth:hover {
        box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
        transform: translateY(-2px);
    }

    /* Error messages */
    .error-list {
        list-style: none;
        padding: 0;
        margin-bottom: 1.5rem;
    }

    .error-message {
        color: var(--danger-color);
        background-color: rgba(220, 53, 69, 0.1);
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        font-weight: 500;
        font-size: 0.9rem;
        border-left: 3px solid var(--danger-color);
    }

    .error-message i {
        margin-right: 0.5rem;
    }

    /* Additional links */
    .auth-links {
        display: flex;
        justify-content: space-between;
        margin: 1.5rem 0;
    }

    .auth-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .auth-link:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    .auth-divider {
        text-align: center;
        margin: 1.5rem 0;
        position: relative;
    }

    .auth-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background-color: var(--border-color);
    }

    .auth-divider span {
        position: relative;
        background-color: var(--white);
        padding: 0 1rem;
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .auth-footer {
        margin-top: 1.5rem;
        text-align: center;
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .auth-footer-link {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
    }

    .auth-footer-link:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    /* Show/hide password toggle */
    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
    }

    /* Responsive styles */
    @media (max-width: 576px) {
        .auth-card-body {
            padding: 1.5rem !important;
        }
        
        .auth-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-card-body">
            <!-- Logo or brand name could go here -->
            <div class="auth-logo text-center">
                <!-- <img src="/assets/images/logo.png" alt="Logo"> -->
                <!-- If no logo, you can use text instead -->
                <h1 class="auth-title">Welcome Back</h1>
            </div>
            
            <h2 class="auth-title text-center">Login</h2>
            <p class="auth-subtitle text-center">Please enter your credentials to continue</p>
            
            <?php if (isset($errors) && !empty($errors)) { ?>
                <ul class="error-list">
                    <?php foreach ($errors as $err) { ?>
                        <li class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo $err; ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
            
            <form action="/account/checkLogin" method="post" id="loginForm">
                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <div class="input-group">
                        <input type="text" name="username" id="username" 
                               class="form-control" 
                               placeholder="Enter your username"
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                               required>
                        <span class="form-icon">
                            <i class="fas fa-user"></i>
                        </span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group" style="position: relative;">
                        <input type="password" name="password" id="password" 
                               class="form-control" 
                               placeholder="Enter your password" 
                               required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="auth-links">
                    <div>
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember" style="color: var(--text-muted); font-size: 0.9rem;">Remember me</label>
                    </div>
                    <a href="/account/forgot-password" class="auth-link">Forgot password?</a>
                </div>
                
                <button type="submit" class="btn-auth">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </button>
            </form>
            
            <div class="auth-footer">
                Don't have an account? <a href="/account/register" class="auth-footer-link">Create Account</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle eye icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }
        
        // Form validation
        const loginForm = document.getElementById('loginForm');
        
        if (loginForm) {
            loginForm.addEventListener('submit', function(event) {
                const username = document.getElementById('username').value.trim();
                const password = document.getElementById('password').value.trim();
                let isValid = true;
                
                if (username === '') {
                    isValid = false;
                    // Add validation feedback
                }
                
                if (password === '') {
                    isValid = false;
                    // Add validation feedback
                }
                
                if (!isValid) {
                    event.preventDefault();
                }
            });
        }
    });
</script>

<?php include 'app/views/shares/footer.php'; ?>