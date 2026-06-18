<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Apex Legends Tracker</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <style>
    :root {
      /* Colors */
      --primary-color: #f04b23; /* Apex Legends Red */
      --secondary-color: #293347; /* Apex Legends Dark Blue */
      --accent-color: #ffce00; /* Apex Legends Yellow */
      --dark-color: #1a1f2e;
      --light-color: #f5f5f5;
      --text-color: #333333;
      --border-color: #ddd;
      --error-color: #e74c3c;
      --success-color: #2ecc71;
      
      /* Typography */
      --font-family: 'Roboto', sans-serif;
      --font-size-xs: 0.75rem;
      --font-size-sm: 0.875rem;
      --font-size-md: 1rem;
      --font-size-lg: 1.25rem;
      --font-size-xl: 1.5rem;
      --font-size-xxl: 2rem;
      
      /* Spacing */
      --spacing-xs: 0.25rem;
      --spacing-sm: 0.5rem;
      --spacing-md: 1rem;
      --spacing-lg: 1.5rem;
      --spacing-xl: 2rem;
      
      /* Border radius */
      --border-radius-sm: 30px;
      --border-radius-md: 60px;
      --border-radius-lg: 90px;
      
      /* Shadows */
      --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
      --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
      --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
      
      /* Transitions */
      --transition-fast: 0.2s;
      --transition-normal: 0.3s;
      --transition-slow: 0.5s;
    }


    /* Reset and base styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }


    body {
      font-family: var(--font-family);
      font-size: var(--font-size-md);
      color: var(--text-color);
      background-color: var(--dark-color);
      line-height: 1.6;
      overflow-x: hidden;
    }

    
    .login-container {
      position: relative;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }


    .login-background {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      z-index: 0;
    }


    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(41, 51, 71, 0.9) 0%, rgba(26, 31, 46, 0.95) 100%);
      z-index: 1;
    }

    .login-form-container {
      position: relative;
      background-color: #293347;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: var(--border-radius-sm);
      box-shadow: var(--shadow-lg);
      width: 100%;
      max-width: 400px;
      padding: var(--spacing-xl);
      z-index: 2;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .login-header {
      text-align: center;
      margin-bottom: var(--spacing-xl);
    }


    .logo {
      margin-bottom: var(--spacing-md);
    }


    .logo img {
      width: 80px;
      height: auto;
    }


    .login-header h1 {
      font-size: var(--font-size-xxl);
      font-weight: 700;
      color: var(--light-color);
      margin-bottom: var(--spacing-sm);
      text-transform: uppercase;
      letter-spacing: 1px;
    }


    .login-header p {
      font-size: var(--font-size-sm);
      color: rgba(255, 255, 255, 0.7);
      margin-bottom: 0;
    }

    .login-form {
      display: flex;
      flex-direction: column;
      gap: var(--spacing-md);
    }


    .form-group {
      position: relative;
      margin-bottom: var(--spacing-md);
    }


    .form-group label {
      display: block;
      font-size: var(--font-size-sm);
      color: rgba(255, 255, 255, 0.8);
      margin-bottom: var(--spacing-xs);
      font-weight: 500;
    }


    .form-group input {
      width: 100%;
      padding: var(--spacing-md);
      padding-right: 50px;
      background-color: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 15px;
      color: var(--light-color);
      font-size: var(--font-size-md);
      transition: all var(--transition-normal);
    }


    .form-group input:focus {
      outline: none;
      border-color: var(--primary-color);
      background-color: rgba(255, 255, 255, 0.15);
      box-shadow: 0 0 0 3px rgba(240, 75, 35, 0.2);
    }


    .form-group input::placeholder {
      color: rgba(255, 255, 255, 0.5);
    }


    .input-icon {
      position: absolute;
      right: 15px;
      top: 38px;
      color: rgba(255, 255, 255, 0.5);
      font-size: var(--font-size-lg);
      pointer-events: none;
    }

    .login-button {
      width: 100%;
      padding: var(--spacing-md);
      background-color: var(--primary-color);
      color: white;
      border: none;
      border-radius: var(--border-radius-md);
      font-size: var(--font-size-lg);
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      cursor: pointer;
      transition: all var(--transition-normal);
      position: relative;
      overflow: hidden;
      margin-top: var(--spacing-md);
    }


    .login-button span {
      position: relative;
      z-index: 1;
    }


    .login-button::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.3) 100%);
      transform: translateX(-100%);
      transition: transform var(--transition-normal);
    }


    .login-button:hover::before {
      transform: translateX(0);
    }


    .login-button:hover {
      background-color: #d0411f;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(240, 75, 35, 0.3);
    }


    .login-button:active {
      transform: translateY(0);
    }


    .login-button:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(240, 75, 35, 0.3);
    }

    .form-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: var(--spacing-md) 0;
    }


    .remember-me {
      display: flex;
      align-items: center;
      font-size: var(--font-size-sm);
      color: rgba(255, 255, 255, 0.8);
    }


    .remember-me input {
      margin-right: var(--spacing-xs);
      cursor: pointer;
    }


    .remember-me label {
      cursor: pointer;
      margin-bottom: 0;
    }


    .forgot-password {
      font-size: var(--font-size-sm);
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      transition: color var(--transition-normal);
    }


    .forgot-password:hover {
      color: var(--primary-color);
      text-decoration: underline;
    }

    .register-link {
      text-align: center;
      margin-top: var(--spacing-lg);
      padding-top: var(--spacing-md);
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }


    .register-link p {
      font-size: var(--font-size-sm);
      color: rgba(255, 255, 255, 0.7);
      margin-bottom: 0;
    }


    .register-link a {
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 500;
      transition: color var(--transition-normal);
    }


    .register-link a:hover {
      color: var(--accent-color);
      text-decoration: underline;
    }

    /* Loading overlay */
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(26, 31, 46, 0.95);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transition: all var(--transition-normal);
    }


    .loading-overlay.active {
      opacity: 1;
      visibility: visible;
    }


    .spinner {
      width: 50px;
      height: 50px;
      border: 4px solid rgba(255, 255, 255, 0.1);
      border-top-color: var(--primary-color);
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin-bottom: var(--spacing-md);
    }


    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }


    .loading-overlay p {
      color: var(--light-color);
      font-size: var(--font-size-lg);
      font-weight: 500;
    }


    /* Animasi fade in untuk container */
    .login-form-container {
      animation: fadeIn 0.8s ease-out;
    }


    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }


    /* Animasi untuk form group */
    .form-group {
      animation: slideUp 0.5s ease-out forwards;
      opacity: 0;
    }


    .form-group:nth-child(1) {
      animation-delay: 0.1s;
    }


    .form-group:nth-child(2) {
      animation-delay: 0.2s;
    }


    .form-group:nth-child(3) {
      animation-delay: 0.3s;
    }


    .form-group:nth-child(4) {
      animation-delay: 0.4s;
    }


    @keyframes slideUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>

</head>
<body>
    <div class="login-container">
        <div class="login-background">
            <div class="overlay"></div>
        </div>
        
        <div class="login-form-container">
            <div class="login-header">
                <h1>Apex Legends Tracker</h1>
                <p>Login to review your Apex Legends gameplay!</p>
            </div>
            
            <form class="login-form" id="loginForm" action="<?php echo e(route('login')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                </div>
                
                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>
                
                <button type="submit" class="login-button">
                    <span>Login</span>
                </button>
                
                <?php if(session('error')): ?>
                  <div style="color: var(--accent-color); var(--font-size-base); margin-top: 10px; text-align: center;">
                    <?php echo e(session('error')); ?>

                  </div>
                <?php endif; ?>

                <div class="register-link">
                    <p>Don't have an account? <a href="#">Register now</a></p>
                </div>
            </form>
        </div>
    </div>
    
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
        <p>Memuat...</p>
    </div>
    
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>
<?php /**PATH D:\laravel-projects\apex-legends-tracker-2\resources\views/login.blade.php ENDPATH**/ ?>