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
        /* Latar belakang dengan gambar gedung perusahaan */
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

        /* Kartu glassmorphism dengan nuansa biru */
        .card {
            background: rgba(59, 130, 246, 0.15);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(147, 197, 253, 0.3);
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.8s ease-out;
            padding: 2.5rem;
        }

        @keyframes slideIn {
            0% { transform: translateY(50px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        /* Judul besar Welcome */
        .welcome-title {
            font-weight: 900;
            font-size: 3rem;
            color: #ffffff;
            text-shadow: 0 0 15px rgba(59, 130, 246, 0.9), 0 0 25px rgba(96, 165, 250, 0.7);
            animation: neonGlow 1.2s ease-in-out infinite alternate;
            margin-bottom: 1.5rem;
        }

        /* Judul card */
        .card-header {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #bfdbfe;
            text-align: center;
            font-weight: 600;
        }

        /* Form input */
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(147, 197, 253, 0.5);
            color: #ffffff;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: #3b82f6;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }

        .form-label {
            color: #bfdbfe;
        }

        .invalid-feedback {
            color: #f87171;
        }

        /* Efek neon */
        @keyframes neonGlow {
            from { text-shadow: 0 0 15px rgba(59, 130, 246, 0.9), 0 0 25px rgba(96, 165, 250, 0.7); }
            to { text-shadow: 0 0 25px rgba(59, 130, 246, 1), 0 0 35px rgba(96, 165, 250, 0.9); }
        }

        /* Tombol biru dengan efek */
        .btn-primary {
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: linear-gradient(45deg, #2563eb, #60a5fa);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 0.75rem;
        }

        .btn-primary:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.6);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
            transition: 0.4s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        /* Logo dengan animasi */
        .logo {
            max-width: 120px;
            margin-bottom: 1.5rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        /* Partikel */
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
    <!-- Partikel latar belakang -->
    <canvas id="particles"></canvas>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card text-center">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
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
                color: { value: ['#3b82f6', '#60a5fa', '#93c5fd'] },
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