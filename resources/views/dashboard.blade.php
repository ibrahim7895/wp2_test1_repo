@extends('layouts.app')

@section('title', 'Dashboard | Aurum Time')

@section('content')
<div class="container">
    <div class="row mb-5 animate__animated animate__fadeInDown">
        <div class="col-md-12">
            <h2 class="fw-bold" style="color: var(--accent1); letter-spacing: 1px;">
                Welcome back, {{ auth()->user()->full_name }}
            </h2>
            <p class="text-muted">
                System Overview: Monitoring your premium watch distribution network.
                <span class="badge bg-gold ms-2">
                    {{ auth()->user()->role == 'manager' ? 'System Administrator' : 'Warehouse Staff' }}
                </span>
            </p>
        </div>
    </div>

    <div class="row justify-content-start g-4">
        {{-- Total Timepieces Card --}}
        <div class="col-md-6 col-lg-4">
            <div class="card card-stats h-100 shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="icon-circle mb-4">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <h5 class="text-uppercase small fw-bold opacity-75">Total Timepieces</h5>
                    <h1 class="display-4 fw-bold text-gold my-3">{{ $productCount }}</h1>
                    <p class="small text-muted mb-4">Luxury units in active inventory</p>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-gold px-4">
                        View Collection <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Warehouses Card --}}
        <div class="col-md-6 col-lg-4">
            <div class="card card-stats h-100 shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="icon-circle mb-4">
                        <i class="fas fa-warehouse fa-2x"></i>
                    </div>
                    <h5 class="text-uppercase small fw-bold opacity-75">Active Warehouses</h5>
                    <h1 class="display-4 fw-bold text-gold my-3">{{ $warehouseCount }}</h1>
                    <p class="small text-muted mb-4">Distribution hubs under your scope</p>
                    <a href="{{ route('warehouses.index') }}" class="btn btn-outline-gold px-4">
                        Manage Hubs <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Gold Styling */
    .text-gold { color: var(--accent1) !important; }
    .bg-gold { background-color: var(--accent1) !important; color: #000 !important; font-weight: bold; }
    
    .btn-outline-gold {
        border: 1px solid var(--accent1);
        color: var(--accent1);
        border-radius: 8px;
        transition: 0.3s;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
    }
    
    .btn-outline-gold:hover {
        background-color: var(--accent1);
        color: #111;
        transform: translateY(-2px);
    }

    /* Card Design */
    .card-stats {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    
    .card-stats:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.4) !important;
        border-color: var(--accent1);
    }

    .icon-circle {
        width: 70px;
        height: 70px;
        background: rgba(212, 175, 55, 0.1);
        color: var(--accent1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .badge {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 1px;
    }
</style>
@endsection