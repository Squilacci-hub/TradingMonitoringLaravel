<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TradeMaster | @yield('title')</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Roboto+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-image:
                radial-gradient(circle at 10% 20%, rgba(41, 121, 255, 0.1) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(0, 250, 172, 0.05) 0%, transparent 20%);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: rgba(21, 25, 36, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-blue), transparent);
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px 16px;
            color: white;
            font-family: var(--font-ui);
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-input:focus {
            border-color: var(--accent-blue);
            outline: none;
            box-shadow: 0 0 0 3px rgba(41, 121, 255, 0.1);
        }

        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, var(--accent-blue), #1a237e);
            border: none;
            border-radius: 8px;
            padding: 14px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 13px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(41, 121, 255, 0.3);
        }

        .auth-footer {
            margin-top: 24px;
            text-align: center;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .auth-footer a {
            color: var(--accent-blue);
            text-decoration: none;
            font-weight: 500;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
            color: white;
            font-size: 24px;
            font-weight: 700;
            gap: 12px;
        }
    </style>
</head>

<body>
    @yield('content')
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to setup toggle for a specific icon and input
        function setupToggle(icon, input) {
            icon.addEventListener('click', function () {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);

                // Toggle Icon
                if (type === 'text') {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                    icon.style.color = 'var(--accent-blue)';
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                    icon.style.color = 'var(--text-secondary)';
                }
            });
        }

        // Setup for Login Page (ID based)
        const loginToggle = document.getElementById('togglePassword');
        const loginInput = document.getElementById('passwordInput');
        if (loginToggle && loginInput) {
            setupToggle(loginToggle, loginInput);
        }

        // Setup for Register Page (Class based for multiple fields)
        const toggleIcons = document.querySelectorAll('.toggle-password');
        const toggleInputs = document.querySelectorAll('.toggle-input');

        toggleIcons.forEach((icon, index) => {
            if (toggleInputs[index]) {
                setupToggle(icon, toggleInputs[index]);
            }
        });
    });
</script>
</body>

</html>