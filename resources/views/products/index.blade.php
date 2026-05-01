@extends('layouts.app')

@section('title', 'Luxury Inventory | Aurum Time')

@section('content')
<div class="container">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-5 animate__animated animate__fadeIn">
        <div>
            <h2 class="fw-bold mb-0 text-gold" style="letter-spacing: 2px;">TIMEPIECE COLLECTION</h2>
            <p class="text-muted small text-uppercase">Central inventory tracking & asset management</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-gold px-4 shadow-sm">
            <i class="fas fa-plus-circle me-2"></i> REGISTER NEW WATCH
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-aurum border-0 text-center mb-5 shadow-sm animate__animated animate__zoomIn">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Products Grid --}}
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp">
            <div class="card h-100 shadow-lg bg-dark text-white border-gold overflow-hidden product-card">
                
                {{-- Image Container with Warehouse Badge --}}
                <div class="position-relative" style="height: 280px; background: #000;">
                    @if($product->upload_file)
                        <img src="{{ asset('uploads/products/' . $product->upload_file) }}" 
                             class="card-img-top w-100 h-100" 
                             style="object-fit: cover; opacity: 0.9;" 
                             alt="{{ $product->product_name }}">
                    @else
                        <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center opacity-25">
                            <i class="fas fa-clock fa-4x text-gold mb-2"></i>
                            <span class="small">NO IMAGE AVAILABLE</span>
                        </div>
                    @endif
                    
                    {{-- Warehouse Badge (Top Right in LTR) --}}
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-gold text-dark px-3 py-2 shadow">
                            <i class="fas fa-warehouse me-1"></i> {{ $product->warehouse_name ?? 'Unassigned' }}
                        </span>
                    </div>
                </div>
                
                {{-- Card Content --}}
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold text-gold mb-3">{{ $product->product_name }}</h5>
                    
                    <p class="card-text text-muted small mb-4" style="height: 45px; overflow: hidden; line-height: 1.5;">
                        {{ Str::limit($product->description, 90) }}
                    </p>
                    
                    <div class="d-flex justify-content-between align-items-center bg-black bg-opacity-50 p-3 rounded-3 border border-secondary border-opacity-25">
                        <div class="price-tag">
                            <span class="text-gold small fw-bold">$</span>
                            <span class="fs-4 fw-bold text-white">{{ number_format($product->price, 2) }}</span>
                        </div>
                        <span class="badge border border-gold text-gold rounded-pill px-3 py-2">
                            Stock: {{ $product->quantity ?? 0 }}
                        </span>
                    </div>
                </div>
                
                {{-- Actions --}}
                <div class="card-footer bg-transparent border-gold-top d-flex justify-content-between align-items-center py-3 px-4">
                    <a href="{{ route('products.edit', $product->product_id) }}" class="btn btn-sm btn-outline-warning px-4 rounded-pill transition-all">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    
                    <form action="{{ route('products.destroy', $product->product_id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to remove this luxury timepiece from the system?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger px-4 rounded-pill transition-all">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        {{-- Empty State --}}
        <div class="col-12 text-center py-5 mt-5">
            <div class="mb-4">
                <i class="fas fa-box-open fa-5x text-gold opacity-10"></i>
            </div>
            <h4 class="text-white opacity-50 fw-light">The vault is currently empty.</h4>
            <p class="text-muted mb-4">No luxury timepieces have been registered yet.</p>
            <a href="{{ route('products.create') }}" class="btn btn-outline-gold">
                START YOUR COLLECTION
            </a>
        </div>
        @endforelse
    </div>
</div>

<style>
    .text-gold { color: var(--accent1) !important; }
    .bg-gold { background-color: var(--accent1) !important; }
    .border-gold { border: 1px solid rgba(212, 175, 55, 0.4) !important; }
    .border-gold-top { border-top: 1px solid rgba(212, 175, 55, 0.1) !important; }
    
    .btn-gold { 
        background-color: var(--accent1); 
        color: #000; 
        border: none; 
        font-weight: bold; 
        transition: 0.3s;
        letter-spacing: 1px;
        font-size: 0.85rem;
    }
    
    .btn-gold:hover { 
        background-color: #fff; 
        color: #000; 
        transform: translateY(-2px); 
        box-shadow: 0 8px 20px rgba(212, 175, 55, 0.3); 
    }
    
    .alert-aurum {
        background-color: var(--accent1);
        color: #000;
        font-weight: 600;
    }

    .product-card { 
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        background: linear-gradient(145deg, #1a1a1a 0%, #0a0a0a 100%) !important;
    }
    
    .product-card:hover { 
        transform: translateY(-12px); 
        box-shadow: 0 20px 40px rgba(0,0,0,0.6) !important; 
        border-color: var(--accent1) !important; 
    }

    .transition-all { transition: all 0.3s ease; }
    
    .btn-outline-warning { color: #ffc107; border-color: #ffc107; }
    .btn-outline-warning:hover { background-color: #ffc107; color: #000; }
    
    .btn-outline-danger:hover { box-shadow: 0 0 15px rgba(220, 53, 69, 0.3); }

    .card-title {
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-size: 1.1rem;
    }
</style>
@endsection