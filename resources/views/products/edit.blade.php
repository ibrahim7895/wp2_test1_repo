@extends('layouts.app')

@section('title', 'Edit Timepiece | Aurum Time')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-gold bg-dark text-white animate__animated animate__fadeIn">
                <div class="card-header border-gold text-center py-4 bg-transparent">
                    <h3 class="text-gold fw-bold mb-0" style="letter-spacing: 2px;">EDIT LUXURY ITEM</h3>
                    <p class="small text-muted mt-2 text-uppercase">Modify specifications for: <span class="text-white">{{ $product->product_name }}</span></p>
                </div>
                
                <div class="card-body p-4">

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 mb-4 py-2" style="background-color: rgba(220, 53, 69, 0.1); color: #ff8a8a;">
                            <ul class="mb-0 small text-start">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        {{-- Product Name --}}
                        <div class="mb-4">
                            <label class="form-label text-gold small fw-bold">MODEL NAME <span class="text-danger">*</span></label>
                            <input type="text" name="name" 
                                   value="{{ old('name', $product->product_name) }}" 
                                   class="form-control bg-black text-white border-secondary @error('name') is-invalid @enderror" 
                                   placeholder="e.g. Rolex Submariner" required>
                        </div>

                        <div class="row mb-4">
                            {{-- Warehouse Selection --}}
                            <div class="col-md-6">
                                <label class="form-label text-gold small fw-bold">WAREHOUSE LOCATION <span class="text-danger">*</span></label>
                                <select name="warehouse_id" class="form-select bg-black text-white border-secondary" required>
                                    @foreach($warehouses as $warehouse)
                                        <option value="{{ $warehouse->warehouse_id }}" 
                                            {{ (old('warehouse_id', $product->warehouse_id) == $warehouse->warehouse_id) ? 'selected' : '' }}>
                                            {{ $warehouse->warehouse_name }} ({{ $warehouse->city }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Price with Decimals (Requirement #2) --}}
                            <div class="col-md-6">
                                <label class="form-label text-gold small fw-bold">PRICE (USD $) <span class="text-danger">*</span></label>
                                <input type="number" name="price" 
                                       value="{{ old('price', $product->price) }}" 
                                       class="form-control bg-black text-white border-secondary @error('price') is-invalid @enderror" 
                                       step="0.01" min="0" required>
                                <div class="form-text text-muted small" style="font-size: 0.7rem;">Precision: 0.00 allowed.</div>
                            </div>
                        </div>

                        {{-- Current & New Image --}}
                        <div class="mb-4">
                            <label class="form-label text-gold small fw-bold">TIMEPIECE IMAGE</label>
                            
                            @if(isset($product->upload_file) && $product->upload_file)
                                <div class="mb-3 d-flex align-items-center bg-black p-3 rounded border border-secondary">
                                    <img src="{{ asset('uploads/products/' . $product->upload_file) }}" 
                                         width="80" height="80" 
                                         class="rounded border border-gold object-fit-cover me-3 shadow-sm"
                                         alt="Current Image">
                                    <div>
                                        <small class="text-gold d-block fw-bold mb-1">Current Media</small>
                                        <code class="text-muted small text-break">{{ $product->upload_file }}</code>
                                    </div>
                                </div>
                            @endif

                            <input type="file" name="image" class="form-control bg-black text-white border-secondary @error('image') is-invalid @enderror" accept="image/*">
                            <div class="form-text text-muted" style="font-size: 0.7rem;">Upload a new image to replace the current one.</div>
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label class="form-label text-gold small fw-bold">PRODUCT DESCRIPTION</label>
                            <textarea name="description" class="form-control bg-black text-white border-secondary" rows="4" 
                                      placeholder="Update technical specs, condition, or provenance...">{{ old('description', $product->description) }}</textarea>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between align-items-center mt-5 border-top pt-4 border-secondary">
                            <a href="{{ route('products.index') }}" class="btn btn-link text-muted text-decoration-none small">
                                <i class="fas fa-times me-1"></i> Cancel Changes
                            </a>
                            <button type="submit" class="btn btn-gold px-5 shadow-sm">
                                <i class="fas fa-save me-2"></i> UPDATE REGISTRY
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
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
    }

    .form-control, .form-select {
        padding: 12px;
        transition: 0.3s;
    }

    .form-control:focus, .form-select:focus {
        background-color: #000 !important;
        color: white !important;
        border-color: var(--accent1) !important;
        box-shadow: 0 0 10px rgba(212, 175, 55, 0.2);
    }

    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23d4af37' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    }

    .object-fit-cover { object-fit: cover; }
</style>
@endsection