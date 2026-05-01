<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurum Time | Excellence in Watch Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: radial-gradient(circle at center, #1a1a1a 0%, #000 100%);
            color: #fff;
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            font-family: 'Inter', sans-serif;
        }

        .hero-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
        }

        .gold-text {
            color: #d4af37;
            letter-spacing: 5px;
            text-transform: uppercase;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 10px;
            text-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
        }

        .hero-subtitle {
            font-size: 1.2rem;
            opacity: 0.7;
            max-width: 600px;
            margin: 0 auto 30px;
            letter-spacing: 1px;
        }

        .btn-aurum {
            background: transparent;
            color: #d4af37;
            border: 2px solid #d4af37;
            padding: 15px 40px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.4s;
            text-decoration: none;
            border-radius: 0;
        }

        .btn-aurum:hover {
            background: #d4af37;
            color: #000;
            box-shadow: 0 0 30px rgba(212, 175, 55, 0.4);
        }

        .footer-minimal {
            padding: 30px;
            font-size: 0.8rem;
            opacity: 0.4;
            text-align: center;
            letter-spacing: 2px;
        }

        /* زينة خلفية */
        .bg-icon {
            position: absolute;
            z-index: -1;
            font-size: 25rem;
            color: rgba(212, 175, 55, 0.03);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>

    <i class="fas fa-history bg-icon"></i>

    <div class="hero-section">
        <div>
            <h5 class="gold-text mb-3">Timeless Precision</h5>
            <h1 class="hero-title">AURUM TIME</h1>
            <p class="hero-subtitle">
                The most sophisticated inventory management system for high-end luxury timepieces. 
                Manage your global warehouses with absolute control.
            </p>
            
            <div class="mt-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-aurum">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-aurum">Enter System</a>
                    @endauth
                @endif
            </div>
        </div>
    </div>

    <footer class="footer-minimal">
        ESTABLISHED 2026 &bull; AURUM TIME INVENTORY SOLUTIONS
    </footer>

</body>
</html>