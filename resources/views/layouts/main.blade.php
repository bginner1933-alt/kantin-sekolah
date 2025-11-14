<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') | CrudLaravel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <style>
    body {
      background: linear-gradient(135deg, #E0F7FA 0%, #FFF9C4 100%);
      min-height: 100vh;
    }
    .sidebar {
      width: 250px;
      position: fixed;
      height: 100%;
      background: linear-gradient(180deg, #58b9b9 0%, #9ab8c5 100%);
      color: white;
      box-shadow: 2px 0 10px rgba(190, 121, 121, 0.1);
    }
    .sidebar h4 { color: #d4d3c4; }
    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 12px 20px;
      border-bottom: 1px solid rgba(255,255,255,0.1);
      transition: all 0.3s ease;
    }
    .sidebar a:hover {
      background-color: #858481;
      color: #b2d1f0;
    }
    .content {
      margin-left: 250px;
      padding: 20px;
      background-color: #FAFAFA;
      min-height: 100vh;
    }
    .navbar {
      background: linear-gradient(90deg, #a4d8f0 0%, #e0d98c 50%, #6d92b8 100%);
      border: none;
    }
    .navbar-brand {
      color: #242f3a !important;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h4 class="text-center mt-3">CRUD App</h4>
    <hr>
    <a href="{{ route('produk.index') }}"><i class="bi bi-box"></i> Produk</a>
    <a href="{{ route('pelanggan.index') }}"><i class="bi bi-tags"></i> Kategori</a>
    <a href="{{ route('transaksi.index') }}"><i class="bi bi-cart-check"></i> Transaksi</a>
    <a href="{{ route('produk.index') }}"><i class="bi bi-credit-card"></i> Pembayaran</a>
    <a href="{{ route('transaksi.index') }}"><i class="bi bi-receipt"></i> Detail Transaksi</a>
    <a href="{{ route('transaksi.index') }}"><i class="bi bi-clock-history"></i> History Transaksi</a>
    <hr>
  </div>

  <div class="content">
    <nav class="navbar navbar-light bg-white shadow-sm mb-4 p-3 rounded d-flex justify-content-between align-items-center">
      <span class="navbar-brand mb-0 h1">@yield('title')</span>
      <div>
        @auth
          <span class="me-3">Halo, {{ auth()->user()->name }}!</span>
          <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">
              <i class="bi bi-box-arrow-right"></i> Logout
            </button>
          </form>
        @else
          <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm me-2">
            <i class="bi bi-box-arrow-in-right"></i> Login
          </a>
          <a href="{{ route('register') }}" class="btn btn-outline-success btn-sm">
            <i class="bi bi-person-plus"></i> Register
          </a>
        @endauth
      </div>
    </nav>

    {{-- Content section --}}
    @yield('content')
  </div>
</body>
</html>
