@extends('layouts.app')

@section('title','DB_STORE Login')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height:80vh;">
  <div class="col-md-5 col-lg-4">

    <!-- Brand -->
     <div class="text-center mb-5 text-white">
  <h2 class="fw-bold" style="letter-spacing:2px;">WELCOME BACK</h2>
  <div style="opacity:.85">Premium Watch Inventory System</div>
</div>
    <!-- Card -->
    <div class="card card-theme p-4">

      <h4 class="fw-bold text-uppercase mb-2" style="letter-spacing:1px;">
        Welcome Back
      </h4>

      <div class="text-muted small mb-3">
        Access your luxury timepiece inventory
      </div>

      {{--  فورم واحد فقط --}}
      <form method="POST" action="{{ route('login.process') }}">
        @csrf

        <div class="mb-3">
          <label class="form-label">Username</label>
          <input name="username" class="form-control" placeholder="Enter username" required>
        </div>

        <div class="mb-2">
          <label class="form-label">Password</label>
          <input name="password" type="password" class="form-control" placeholder="Enter password" required>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input name="remember" class="form-check-input" type="checkbox" value="1" required>
            <label class="form-check-label small">Remember me</label>
          </div>
          <a href="#" class="link-gold">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-gold w-100 py-2">
            SIGN IN
        </button>

        <div class="text-center text-muted small mt-3">
          © {{ date('Y') }} Aurum Time
        </div>

      </form>

    </div>
  </div>
</div>
@endsection
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif