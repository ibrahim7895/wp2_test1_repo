<!doctype html>
<html lang="en" dir="ltr" data-theme="B">
<head>
<<<<<<< HEAD
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Aurum Time | Luxury Inventory Management')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root[data-theme="A"] {
            --bg1:#f8fafc; --bg2:#f1f5f9; --accent1:#1e293b; --accent2:#334155;
            --card-bg: #ffffff; --card-border: #e2e8f0;
            --shadow: rgba(0,0,0,.05); --nav-bg: #ffffff;
            --brand: #1e293b; --brand-accent: #d4af37; --btn-text: #ffffff;
            --sidebar-text: #1e293b;
        }

        :root[data-theme="B"] {
            --bg1:#020617; --bg2:#0f172a; --accent1:#d4af37; --accent2:#f5d77a;
            --card-bg: #1e293b; --card-border: rgba(212,175,55,.2);
            --shadow: rgba(0,0,0,.6); --nav-bg: rgba(15, 23, 42, 0.9);
            --brand: #f8fafc; --brand-accent: #d4af37; --btn-text: #111111;
            --sidebar-text: #f8fafc;
        }

        body {
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--bg1), var(--bg2));
            color: var(--sidebar-text);
            overflow-x: hidden;
            margin: 0;
        }

        .wrapper { display: flex; min-height: 100vh; }
        
        .sidebar {
            width: 260px;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--card-border);
            transition: all 0.4s ease;
            position: sticky;
            top: 0;
            height: 100vh;
            z-index: 1000;
        }

        .main-content { 
            flex: 1; 
            padding: 30px;
            background: transparent;
        }

        .navbar {
            background: var(--nav-bg) !important;
            backdrop-filter: blur(15px);
            border: 1px solid var(--card-border);
            margin-bottom: 30px;
            border-radius: 12px;
            padding: 15px 25px;
        }

        .nav-link-custom {
            color: var(--sidebar-text);
            text-decoration: none;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: 0.3s ease;
            border-radius: 8px;
            margin: 5px 15px;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-link-custom:hover, .nav-link-custom.active {
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.1), transparent);
            color: var(--accent1);
            border-left: 3px solid var(--accent1);
        }

        .nav-link-custom i { 
            width: 20px; 
            text-align: center; 
            color: var(--brand-accent);
        }

        .brand-section {
            padding: 40px 20px;
            text-align: center;
        }

        .brand-logo { 
            height: 50px; 
            filter: drop-shadow(0 0 8px rgba(212, 175, 55, 0.4));
        }

        .text-gold { color: var(--accent1) !important; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: var(--accent1); border-radius: 10px; }
    </style>
</head>

<body>
    <div class="wrapper">
        <aside class="sidebar">
            <div class="brand-section">
                <a href="{{ route('dashboard') }}" class="text-decoration-none">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-logo mb-2">
                    <h5 class="text-gold fw-bold m-0" style="letter-spacing: 3px;">AURUM TIME</h5>
                </a>
            </div>

            <nav class="mt-2">
                <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
                
                <a href="{{ route('products.index') }}" class="nav-link-custom {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <i class="fas fa-clock"></i> Inventory
                </a>

                <a href="{{ route('warehouses.index') }}" class="nav-link-custom {{ request()->routeIs('warehouses.*') ? 'active' : '' }}">
                    <i class="fas fa-warehouse"></i> Warehouses
                </a>

                <div class="mt-5 px-4 small text-uppercase opacity-50 fw-bold" style="font-size: 0.7rem; color: var(--accent1); letter-spacing: 1px;">Account</div>
                
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <button type="submit" class="nav-link-custom text-danger border-0 bg-transparent w-100 text-start">
                        <i class="fas fa-power-off"></i> Logout
                    </button>
                </form>
            </nav>
        </aside>

        <div class="main-content">
            <nav class="navbar shadow-sm">
                <div class="container-fluid">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-crown text-gold me-2"></i>
                        <span class="text-gold fw-bold text-uppercase small" style="letter-spacing: 1px;">Premium Access</span>
                    </div>
                    
                    <div class="d-flex align-items-center gap-3">
                        <div class="text-end d-none d-md-block me-2">
                            <div class="small fw-bold">{{ auth()->user()->full_name ?? 'User' }}</div>
                            <div class="text-muted" style="font-size: 0.7rem;">Role: {{ ucfirst(auth()->user()->role ?? 'Guest') }}</div>
                        </div>
                        <button id="themeToggle" class="btn btn-sm rounded-circle" style="border: 1px solid var(--accent1); color: var(--accent1);">
                            <i class="fas fa-moon"></i>
                        </button>
                    </div>
                </div>
            </nav>

            <main>
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const btn = document.getElementById("themeToggle");
        const icon = btn.querySelector("i");
        const html = document.documentElement;

        function updateIcon(theme) {
            icon.className = theme === "A" ? "fas fa-sun" : "fas fa-moon";
        }

        const savedTheme = localStorage.getItem("theme") || "B";
        html.setAttribute("data-theme", savedTheme);
        updateIcon(savedTheme);

        btn.addEventListener("click", () => {
            const current = html.getAttribute("data-theme");
            const newTheme = current === "A" ? "B" : "A";
            html.setAttribute("data-theme", newTheme);
            localStorage.setItem("theme", newTheme);
            updateIcon(newTheme);
        });
    </script>
</body>
</html>
