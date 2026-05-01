<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurum Time - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { 
            background-color: #0f0f0f; 
            color: #d4af37; 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-theme { 
            background: #1a1a1a; 
            border: 1px solid #d4af37; 
            border-radius: 15px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.7); 
        }
        .form-control { 
            background: #0a0a0a; 
            border: 1px solid #333; 
            color: #fff; 
            padding: 12px; 
        }
        .form-control:focus { 
            background: #0a0a0a; 
            border-color: #d4af37; 
            color: #fff; 
            box-shadow: 0 0 5px rgba(212, 175, 55, 0.5); 
        }
        .btn-gold { 
            background: #d4af37; 
            color: #000; 
            font-weight: bold; 
            border-radius: 5px; 
            transition: 0.4s; 
            width: 100%; 
            padding: 12px; 
            border: none; 
            margin-top: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-gold:hover { 
            background: #fff; 
            color: #000; 
            transform: translateY(-2px);
        }
        .error-msg { 
            background: rgba(255, 77, 77, 0.1);
            border: 1px solid #ff4d4d;
            border-radius: 5px;
            color: #ff4d4d; 
            padding: 10px;
            font-size: 0.85rem; 
            margin-top: 15px; 
            text-align: center; 
        }
        label { color: #aaa; text-transform: uppercase; letter-spacing: 1px; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="text-center mb-4 text-white">
                <h2 class="fw-bold" style="letter-spacing:4px; color: #d4af37;">AURUM TIME</h2>
                <div style="opacity:.7; font-size: 0.9rem; letter-spacing: 1px;">PREMIUM INVENTORY MANAGEMENT</div>
            </div>

            <div class="card card-theme p-4">
                <h4 class="fw-bold text-center mb-1">SIGN IN</h4>
                <p class="text-muted small text-center mb-4">Luxury Watch Distribution Hub</p>

                <form method="POST" action="{{ route('login.process') }}">
                    @csrf 
                    
                    <div class="mb-3">
                        <label class="small mb-1">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Admin / Staff ID" required autofocus value="{{ old('username') }}">
                    </div>

                    <div class="mb-3">
                        <label class="small mb-1">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn-gold">Authorize Access</button>

                    @if ($errors->any())
                        <div class="error-msg">
                            {{ $errors->first() }}
                        </div>
                    @endif
                </form>
            </div>
            
            <div class="text-center mt-4 small" style="color: #444;">
                &copy; {{ date('Y') }} Aurum Time System. All Rights Reserved.
            </div>
        </div>
    </div>
</div>

</body>
</html>