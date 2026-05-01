@extends('layouts.app')

@section('title', 'Add New Timepiece | Aurum Time')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-gold bg-dark text-white animate__animated animate__fadeInUp">
                <div class="card-header border-gold text-center py-4 bg-transparent">
                    <h3 class="text-gold fw-bold mb-0" style="letter-spacing: 2px;">REGISTER NEW TIMEPIECE</h3>
                    <p class="small text-muted mt-2 text-uppercase">Input luxury item details into global inventory</p>
                </div>
                
                <div class="card-body p-4">

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 mb-4 py-2" style="background-color: rgba(220, 53, 69, 0.1); color: #ff8a8a;">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label text-gold small fw-bold">WATCH MODEL NAME <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control bg-black text-white border-secondary @error('name') is-invalid @enderror" placeholder="e.g. Rolex Submariner Date" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-gold small fw-bold">PRICE (USD $) <span class="text-danger">*</span></label>
                                {{-- تطبيق المطلب 2: السعر العشري --}}
                                <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" class="form-control bg-black text-white border-secondary @error('price') is-invalid @enderror" placeholder="0.00" required>
                                <div class="form-text text-muted" style="font-size: 0.7rem;">Decimals allowed (e.g. 15400.50)</div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label text-gold small fw-bold">ASSIGN TO WAREHOUSE <span class="text-danger">*</span></label>
                                <select name="warehouse_id" class="form-select bg-black text-white border-secondary @error('warehouse_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>Select Destination...</option>
                                    @foreach($warehouses as $warehouse)
                                        <option value="{{ $warehouse->warehouse_id }}" {{ old('warehouse_id') == $warehouse->warehouse_id ? 'selected' : '' }}>
                                            {{ $warehouse->warehouse_name }} ({{ $warehouse->city }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-gold small fw-bold">PRODUCT IMAGE</label>
                            <input type="file" name="image" class="form-control bg-black text-white border-secondary @error('image') is-invalid @enderror" accept="image/*">
                            <div class="form-text text-muted" style="font-size: 0.7rem;">Preferred: PNG or JPG (Max 2MB).</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-gold small fw-bold">SPECIFICATIONS / DESCRIPTION</label>
                            <textarea name="description" class="form-control bg-black text-white border-secondary" rows="4" placeholder="Enter technical details, movement, and condition...">{{ old('description') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5 border-top pt-4 border-secondary">
                            <a href="{{ route('products.index') }}" class="btn btn-link text-muted text-decoration-none small">
                                <i class="fas fa-chevron-left me-1"></i> Back to Inventory
                            </a>
                            <button type="submit" class="btn btn-gold px-5">
                                <i class="fas fa-check-circle me-2"></i> SAVE TO DATABASE
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-gold { border: 1px solid var(--accent1) !important; }
    .text-gold { color: var(--accent1); }
    
    .btn-gold { 
        background-color: var(--accent1); 
        color: #000; 
        border: none; 
        font-weight: bold;
        padding: 12px 30px;
        transition: 0.4s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .btn-gold:hover { 
        background-color: #fff; 
        color: #000; 
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
    }

    .form-control, .form-select {
        padding: 12px;
        transition: 0.3s;
    }

    .form-control:focus, .form-select:focus {
        background-color: #000 !important;
        color: white !important;
        border-color: var(--accent1) !important;
        box-shadow: 0 0 8px rgba(212, 175, 55, 0.2);
    }

    /* Customizing the dropdown arrow color to Gold */
    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23d4af37' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    }
</style>
@endsection