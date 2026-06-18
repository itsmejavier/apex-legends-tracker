<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Apex Legends Tracker</title>
    <style>
        :root {
            --primary-color: #f04b23;
            --background-dark: #1a1f2e;
            --background-card: #293347;
            --text-primary: #f5f5f5;
            --text-secondary: #CCCCCC;
            --border-color: #333333;
            --button-hover: #d0411f;
            --font-size-lg: 3rem;
            --font-size-md: 1.25rem;
            --font-size-sm: 0.875rem;
        }


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }


        body {
            background: linear-gradient(135deg, rgba(41, 51, 71, 0.9) 0%, rgba(26, 31, 46, 0.95) 100%);
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-color: var(--background-dark);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 2rem;
            overflow-x: hidden;
        }


        .logout-btn {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }


        .logout-btn:hover {
            color: var(--primary-color);
        }


        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            width: 100%;
            max-width: 800px;
            text-align: center;
        }


        .title {
            font-size: var(--font-size-lg);
            font-weight: bold;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--primary-color);
            animation: fadeOut 0.8s ease-out;
        }


        .subtitle {
            font-size: var(--font-size-md);
            margin-bottom: 4rem;
            color: var(--text-secondary);
            animation: fadeOut 0.8s ease-out;
            text-transform: uppercase;
        }


        .button-container {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.8s ease-out;
        }


        .action-button {
            background-color: var(--primary-color);
            color: var(--text-primary);
            border: none;
            padding: 1.5rem 2rem;
            font-size: 1.5rem;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 100px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 8px rgba(232, 27, 35, 0.3);
            text-decoration: none;
            display: block;
            text-align: center;
            overflow: hidden;
            position: relative;
        }


        .action-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.3) 100%);
        transform: translateX(-100%);
        transition: 0.3s;
        }


        .action-button:hover::before {
            transform: translateX(0);
        }

        .action-button:hover {
            background-color: var(--button-hover);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(240, 75, 35, 0.3);
        }


        .action-button:active {
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(232, 27, 35, 0.3);
        }


        .action-button:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(240, 75, 35, 0.3);
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

        @keyframes fadeOut {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0px);
        }
        }

        footer {
            margin-top: 4rem;
            color: var(--text-secondary);
            font-size: var(--font-size-sm);
            text-align: center;
        }


        /* Responsive Design */
        @media (max-width: 768px) {
            .title {
                font-size: 2rem;
            }
            
            .subtitle {
                font-size: 1rem;
                margin-bottom: 3rem;
            }
            
            .button-container {
                gap: 1.5rem;
            }
            
            .action-button {
                padding: 1.2rem 1.5rem;
                font-size: 1.3rem;
            }
        }


        @media (max-width: 480px) {
            body {
                padding: 1rem;
            }
            
            .title {
                font-size: 1.8rem;
                letter-spacing: 1px;
            }
            
            .subtitle {
                font-size: 0.9rem;
                margin-bottom: 2.5rem;
            }
            
            .button-container {
                max-width: 100%;
            }
            
            .action-button {
                padding: 1rem 1.2rem;
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>

    <div style="position: absolute; top: 1rem; left: 1rem;">
        <a href="<?php echo e(route('logout')); ?>" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="post" style="display: none;">
            <?php echo csrf_field(); ?>
        </form>
    </div>

    <div class="container">
        <h1 class="title">APEX LEGENDS TRACKER</h1>
        <p class="subtitle">Review your Apex Legends gameplay</p>
        
        <div class="button-container">
            <a href="<?php echo e(route('dashboard')); ?>" class="action-button">DASHBOARD</a>
            <a href="<?php echo e(route('chatbot')); ?>" class="action-button">AI CHATBOT</a>
        </div>
    </div>
    
    <footer>
        © 2026 Apex Legends Tracker
    </footer>
</body>
</html>
<?php /**PATH D:\laravel-projects\apex-legends-tracker-2\resources\views/home.blade.php ENDPATH**/ ?>