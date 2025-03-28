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
        --success-color: #28a745; /* Green for success */
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
        max-width: 500px;
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

    /* Password strength */
    .password-strength {
        height: 5px;
        margin-top: 0.5rem;
        border-radius: 5px;
        background-color: var(--border-color);
        position: relative;
        overflow: hidden;
    }

    .password-strength-meter {
        height: 100%;
        width: 0;
        border-radius: 5px;
        transition: width 0.3s ease, background-color 0.3s ease;
    }

    .strength-weak {
        background-color: var(--danger-color);
        width: 25%;
    }

    .strength-medium {
        background-color: #ffc107; /* Yellow/amber */
        width: 50%;
    }

    .strength-good {
        background-color: #17a2b8; /* Teal/info */
        width: 75%;
    }

    .strength-strong {
        background-color: var(--success-color);
        width: 100%;
    }

    .password-info {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 0.5rem;
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

    /* Form row for side-by-side fields */
    .form-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .form-row .form-group {
        flex: 1;
        margin-bottom: 0;
    }

    /* Responsive styles */
    @media (max-width: 576px) {
        .auth-card-body {
            padding: 1.5rem !important;
        }
        
        .auth-title {
            font-size: 1.5rem;
        }
        
        .form-row {
            flex-direction: column;
            gap: 0;
        }
        
        .form-row .form-group {
            margin-bottom: 1.5rem;
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
                <h1 class="auth-title">Create Account</h1>
            </div>
            
            <h2 class="auth-title text-center">Register</h2>
            <p class="auth-subtitle text-center">Fill out the form to create your account</p>
            
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
            
            <form action="/account/save" method="post" id="registerForm">
                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <div class="input-group">
                        <input type="text" name="username" id="username" 
                               class="form-control" 
                               placeholder="Choose a username"
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                               required>
                        <span class="form-icon">
                            <i class="fas fa-user"></i>
                        </span>
                    </div>
                    <small class="form-text text-muted">Username must be 4-20 characters long</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="fullname">Full Name</label>
                    <div class="input-group">
                        <input type="text" name="fullname" id="fullname" 
                               class="form-control" 
                               placeholder="Enter your full name"
                               value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>" 
                               required>
                        <span class="form-icon">
                            <i class="fas fa-id-card"></i>
                        </span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group" style="position: relative;">
                        <input type="password" name="password" id="password" 
                               class="form-control" 
                               placeholder="Create a password" 
                               required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    
                    <div class="password-strength">
                        <div class="password-strength-meter" id="passwordStrength"></div>
                    </div>
                    <div class="password-info" id="passwordInfo">Password strength: Not entered</div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="confirmpassword">Confirm Password</label>
                    <div class="input-group" style="position: relative;">
                        <input type="password" name="confirmpassword" id="confirmpassword" 
                               class="form-control" 
                               placeholder="Confirm your password" 
                               required>
                        <button type="button" class="password-toggle" id="toggleConfirmPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div id="passwordMatch" class="password-info"></div>
                </div>
                
                <button type="submit" class="btn-auth">
                    <i class="fas fa-user-plus mr-2"></i> Create Account
                </button>
            </form>
            
            <div class="auth-footer">
                Already have an account? <a href="/account/login" class="auth-footer-link">Login Instead</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput = document.getElementById('confirmpassword');
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle eye icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }
        
        if (toggleConfirmPassword && confirmPasswordInput) {
            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);
                
                // Toggle eye icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }
        
        // Password strength meter
        const passwordStrength = document.getElementById('passwordStrength');
        const passwordInfo = document.getElementById('passwordInfo');
        
        if (passwordInput && passwordStrength && passwordInfo) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                if (password.length > 0) {
                    // Check password length
                    if (password.length >= 8) strength += 1;
                    
                    // Check for mixed case
                    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;
                    
                    // Check for numbers
                    if (password.match(/\d/)) strength += 1;
                    
                    // Check for special characters
                    if (password.match(/[^a-zA-Z\d]/)) strength += 1;
                    
                    // Update strength meter
                    passwordStrength.className = 'password-strength-meter';
                    
                    if (strength === 0) {
                        passwordStrength.classList.add('strength-weak');
                        passwordInfo.textContent = 'Password strength: Very weak';
                    } else if (strength === 1) {
                        passwordStrength.classList.add('strength-weak');
                        passwordInfo.textContent = 'Password strength: Weak';
                    } else if (strength === 2) {
                        passwordStrength.classList.add('strength-medium');
                        passwordInfo.textContent = 'Password strength: Medium';
                    } else if (strength === 3) {
                        passwordStrength.classList.add('strength-good');
                        passwordInfo.textContent = 'Password strength: Good';
                    } else {
                        passwordStrength.classList.add('strength-strong');
                        passwordInfo.textContent = 'Password strength: Strong';
                    }
                } else {
                    passwordStrength.className = 'password-strength-meter';
                    passwordInfo.textContent = 'Password strength: Not entered';
                }
                
                // Check password confirmation
                checkPasswordMatch();
            });
        }
        
        // Check if passwords match
        const passwordMatch = document.getElementById('passwordMatch');
        
        function checkPasswordMatch() {
            if (passwordInput.value === '' || confirmPasswordInput.value === '') {
                passwordMatch.textContent = '';
                return;
            }
            
            if (passwordInput.value === confirmPasswordInput.value) {
                passwordMatch.textContent = 'Passwords match';
                passwordMatch.style.color = 'var(--success-color)';
            } else {
                passwordMatch.textContent = 'Passwords do not match';
                passwordMatch.style.color = 'var(--danger-color)';
            }
        }
        
        if (confirmPasswordInput && passwordMatch) {
            confirmPasswordInput.addEventListener('input', checkPasswordMatch);
        }
        
        // Form validation
        const registerForm = document.getElementById('registerForm');
        
        if (registerForm) {
            registerForm.addEventListener('submit', function(event) {
                const username = document.getElementById('username').value.trim();
                const fullname = document.getElementById('fullname').value.trim();
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmpassword').value;
                let isValid = true;
                
                // Basic validation
                if (username === '' || username.length < 4 || username.length > 20) {
                    isValid = false;
                    // Add validation feedback
                }
                
                if (fullname === '') {
                    isValid = false;
                    // Add validation feedback
                }
                
                if (password === '' || password.length < 8) {
                    isValid = false;
                    // Add validation feedback
                }
                
                if (password !== confirmPassword) {
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