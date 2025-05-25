<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Background with corporate building image */
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Glassmorphism card with blue tint */
        .card {
            background: rgba(59, 130, 246, 0.15);
            backdrop-filter: blur(15px);
            border Korea: Noto Serif CJK KR
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.8s ease-out;
            padding: 3rem;
        }

        @keyframes slideIn {
            0% { transform: translateY(50px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        /* Large welcome heading */
        .welcome-title {
            font-weight: 900;
            font-size: 3.5rem;
            color: #ffffff;
            text-shadow: 0 0 15px rgba(59, 130, 246, 0.9), 0 0 25px rgba(96, 165, 250, 0.7);
            animation: neonGlow 1.2s ease-in-out infinite alternate;
            margin-bottom: 1.5rem;
        }

        /* Secondary title */
        .subtitle {
            font-weight: 600;
            font-size: 1.75rem;
            color: #bfdbfe;
            margin-bottom: 2rem;
        }

        @keyframes neonGlow {
            from { text-shadow: 0 0 15px rgba(59, 130, 246, 0.9), 0 0 25px rgba(96, 165, 250, 0.7); }
            to { text-shadow: 0 0 25px rgba(59, 130, 246, 1), 0 0 35px rgba(96, 165, 250, 0.9); }
        }

        /* Blue-themed buttons */
        .btn-primary, .btn-secondary {
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            padding: 0.75rem 2.5rem;
            font-weight: 600;
            border-radius: 0.75rem;
        }

        .btn-primary {
            background: linear-gradient(45deg, #2563eb, #60a5fa);
            border: none;
        }

        .btn-secondary {
            background: linear-gradient(45deg, #1e40af, #3b82f6);
            border: none;
        }

        .btn-primary:hover, .btn-secondary:hover {
            transform: scale(1.15);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.6);
        }

        /* Button shine effect */
        .btn-primary::before, .btn-secondary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
            transition: 0.4s;
        }

        .btn-primary:hover::before, .btn-secondary:hover::before {
            left: 100%;
        }

        /* Logo with bounce animation */
        .logo {
            max-width: 120px;
            margin-bottom: 2rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        /* Particle canvas */
        #particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
    </style>
</head>
<body>
    <!-- Particle background -->
    <canvas id="particles"></canvas>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card text-center">
                    <!-- Logo placeholder (replace with your logo) -->
                    <h1 class="welcome-title">Welcome to Kaleg PKL</h1>
                    <h2 class="subtitle">Login or Register to View Data</h2>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        particlesJS('particles', {
            particles: {
                number: { value: 60, density: { enable: true, value_area: 1000 } },
                color: { value: ['#3b82f6', '#60a5fa', '#93c5fd'] }, // Blue-themed particles
                shape: { type: 'circle' },
                opacity: { value: 0.4, random: true },
                size: { value: 3, random: true },
                line_linked: { enable: true, distance: 150, color: '#93c5fd', opacity: 0.3, width: 1 },
                move: { enable: true, speed: 2, direction: 'none', random: true, out_mode: 'out' }
            },
            interactivity: {
                detect_on: 'canvas',
                events: { onhover: { enable: true, mode: 'grab' }, onclick: { enable: true, mode: 'push' } },
                modes: { grab: { distance: 140 }, push: { particles_nb: 2 } }
            },
            retina_detect: true
        });
    </script>
</body>
</html>