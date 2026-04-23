<!doctype html>
<html lang="en" dir="ltr" data-theme="B">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','DB_STORE')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root[data-theme="A"]{
      --bg1:#0B1220;
      --bg2:#0F1B33;
      --accent1:#2563EB;
      --accent2:#1D4ED8;
      --card-bg: rgba(255,255,255,.92);
      --card-border: rgba(255,255,255,.55);
      --shadow: rgba(2,6,23,.35);
      --nav-bg: rgba(255,255,255,.72);
      --brand: #0B1220;
      --brand-accent: var(--accent1);
      --btn-text: #ffffff;
    }

    :root[data-theme="B"]{
      --bg1:#020617;
      --bg2:#0B1220;
      --accent1:#D4AF37;
      --accent2:#F5D77A;
      --card-bg: rgba(255,255,255,.94);
      --card-border: rgba(212,175,55,.25);
      --shadow: rgba(0,0,0,.55);
      --nav-bg: rgba(2,6,23,.70);
      --brand: #F8FAFC;
      --brand-accent: #D4AF37;
      --btn-text: #111111;
    }

    body{
      min-height:100vh;
      font-family: Arial, Helvetica, sans-serif;
      background:
        radial-gradient(circle at 20% 20%, rgba(212,175,55,.12), transparent 42%),
        radial-gradient(circle at 80% 25%, rgba(245,215,122,.10), transparent 42%),
        radial-gradient(circle at 50% 85%, rgba(212,175,55,.08), transparent 55%),
        linear-gradient(180deg, var(--bg1), var(--bg2));
    }

    .navbar{
      background: var(--nav-bg) !important;
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(255,255,255,.08);
    }

    .navbar-brand{
      color: var(--brand) !important;
      letter-spacing: 2px;
    }

    .navbar-brand .accent{
      color: var(--brand-accent);
    }

    .card-theme{
      border-radius:18px;
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      box-shadow: 0 30px 80px var(--shadow);
    }

    .form-control{
      border-radius:12px;
      padding: .75rem .9rem;
    }

    .btn-gold{
      background: linear-gradient(135deg, var(--accent1), var(--accent2));
      border: 0;
      border-radius: 12px;
      padding: .75rem 1rem;
      font-weight: 800;
      letter-spacing: .9px;
      color: var(--btn-text);
      box-shadow: 0 10px 20px rgba(212,175,55,.22);
    }

    .link-gold {
      color: rgba(198,167,94,0.85);
    }

    .link-gold:hover {
      color: #e5d18a;
      text-decoration: underline;
    }

    /* زر الثيم */
    .theme-btn{
      border-radius: 10px;
      font-size: 14px;
      padding: 6px 12px;
    }

.navbar-brand{
  font-size: 20px;
}

.brand-logo{
  height:82px;
  width:auto;
  filter: drop-shadow(0 3px 6px rgba(0,0,0,.45));
}

.brand-text{
  font-size:22px;
  letter-spacing:1px;
}
  </style>
</head>

<body>
  <nav class="navbar shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">

       <a class="navbar-brand fw-bold d-flex align-items-center gap-3" href="#">
  <img src="{{ asset('images/logo.png') }}" alt="Aurum Time" class="brand-logo">
  <span class="brand-text">
    <span class="accent">Aurum</span> Time
  </span>
</a>

      <!-- زر تغيير الثيم -->
      <button id="themeToggle" class="btn btn-outline-light theme-btn">
        🌙 / ☀️
      </button>

    </div>
  </nav>

  <main class="container py-4">
    @yield('content')
  </main>

  <!-- Script تغيير الثيم -->
  <script>
    const btn = document.getElementById("themeToggle");
    const html = document.documentElement;

    // استرجاع الثيم المحفوظ
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme) {
      html.setAttribute("data-theme", savedTheme);
    }

    btn.addEventListener("click", () => {
      const current = html.getAttribute("data-theme");
      const newTheme = current === "A" ? "B" : "A";
      html.setAttribute("data-theme", newTheme);
      localStorage.setItem("theme", newTheme);
    });
  </script>

</body>
</html>
