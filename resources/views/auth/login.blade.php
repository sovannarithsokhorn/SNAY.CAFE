<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noir Coffee - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&amp;family=Syne:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
    <style>
        /* Your existing CSS from Login.html */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background-color: #0F0F0F;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://images.unsplash.com/photo-1447933601403-0c6688de566e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1956&q=80');
            background-size: cover;
            background-position: center;
            filter: brightness(0.4);
            z-index: -2;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(15, 15, 15, 0.5) 0%, rgba(10, 10, 10, 0.8) 100%);
            z-index: -1;
        }

        .container {
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            background-color: rgba(26, 26, 26, 0.75);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
            transition: opacity 0.3s ease;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, transparent, #D4A95C, transparent);
            opacity: 0.7;
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-text {
            font-family: 'Syne', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: #D4A95C;
            letter-spacing: 2px;
            text-shadow: 0 0 10px rgba(212, 169, 92, 0.5);
            line-height: 1;
        }

        h1 {
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            text-align: center;
            letter-spacing: 1px;
        }

        .subtitle {
            text-align: center;
            color: #ccc;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #ccc;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.8rem 1rem;
            background-color: rgba(15, 15, 15, 0.6);
            border: 1px solid rgba(212, 169, 92, 0.3);
            border-radius: 8px;
            color: white;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #D4A95C;
            box-shadow: 0 0 0 2px rgba(212, 169, 92, 0.2);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }

        .remember {
            display: flex;
            align-items: center;
        }

        .remember input {
            margin-right: 0.5rem;
            appearance: none;
            width: 18px;
            height: 18px;
            border: 1px solid rgba(212, 169, 92, 0.3);
            border-radius: 4px;
            background-color: rgba(15, 15, 15, 0.6);
            cursor: pointer;
            position: relative;
        }

        .remember input:checked::before {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #D4A95C;
            font-size: 12px;
        }

        .forgot-password {
            color: #D4A95C;
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .forgot-password:hover {
            opacity: 0.8;
        }

        button {
            width: 100%;
            padding: 0.9rem;
            background-color: #D4A95C;
            color: #0F0F0F;
            border: none;
            border-radius: 8px;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        button:hover {
            background-color: #c49a52;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 169, 92, 0.3);
        }

        .register-link {
            text-align: center;
            margin-top: 2.5rem;
            font-size: 1rem;
            color: #ccc;
        }

        .register-link a {
            color: #D4A95C;
            text-decoration: none;
            font-weight: 700;
            transition: opacity 0.3s ease;
        }

        .register-link a:hover {
            opacity: 0.8;
        }

        .error-message {
            color: #ef4444; /* Tailwind red-500 */
            font-size: 0.875rem; /* Tailwind text-sm */
            margin-top: 0.25rem; /* Tailwind mt-1 */
        }

        @media (max-width: 480px) {
            .container {
                padding: 2rem 1.5rem;
                margin: 0 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="overlay"></div>

    <div class="container" id="formContainer">
        <div class="logo">
            <div class="logo-text">SNAY.CAFE</div>
        </div>
        <h1 id="formTitle">Welcome Back.</h1>
        <p class="subtitle" id="formSubtitle">Login to your account to continue</p>

        {{-- Laravel form for login --}}
        <form id="loginForm" method="POST" action="{{ url('/login-attempt') }}"> {{-- Changed action to url() --}}
            @csrf {{-- CSRF token for security --}}

            @if (session('status'))
                <div class="bg-green-500 text-white p-3 rounded-md mb-4 text-sm text-center">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-500 text-white p-3 rounded-md mb-4 text-sm text-center">
                    Invalid credentials. Please try again.
                </div>
            @endif

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Your username" value="{{ old('username') }}" required autofocus> {{-- Changed type to text and name to username --}}
                @error('username') {{-- Updated error directive --}}
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="remember-forgot">
                <label class="remember">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
                </label>
                @if (isset($passwordRequestRoute) && $passwordRequestRoute) {{-- Check if route exists --}}
                    <a href="{{ url('/forgot-password') }}" class="forgot-password">Forgot password?</a> {{-- Changed route to url() --}}
                @endif
            </div>
            <button type="submit">Login</button>
        </form>

        {{-- Link to register form --}}
        <div class="register-link">
            Don't have an account? <a href="{{ url('/register') }}">Register here</a> {{-- Changed route to url() --}}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('formContainer');
            container.style.opacity = '1'; // Keep for initial fade-in effect if desired
        });
    </script>
</body>
</html>
