@extends('layouts.app')

@section('title', 'Update Hub | Aurum Time')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-gold bg-dark text-white animate__animated animate__fadeIn">
                {{-- Header --}}
                <div class="card-header border-gold text-center py-4 bg-transparent">
                    <h3 class="text-gold fw-bold mb-0" style="letter-spacing: 2px;">UPDATE LOGISTICS HUB</h3>
                    <p class="small text-muted mt-2 text-uppercase">Modifying registry for: <span class="text-white">{{ $warehouse->warehouse_name }}</span></p>
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

                    <form action="{{ route('warehouses.update', $warehouse->warehouse_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-gold small fw-bold">WAREHOUSE NAME <span class="text-danger">*</span></label>
                                <input type="text" name="warehouse_name" 
                                       value="{{ old('warehouse_name', $warehouse->warehouse_name) }}" 
                                       class="form-control bg-black text-white border-secondary focus-gold" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-gold small fw-bold">CITY / LOCATION <span class="text-danger">*</span></label>
                                <input type="text" name="city" 
                                       value="{{ old('city', $warehouse->city) }}" 
                                       class="form-control bg-black text-white border-secondary focus-gold" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            {{-- Store Association --}}
                            <div class="col-md-6">
                                <label class="form-label text-gold small fw-bold">AFFILIATED STORE <span class="text-danger">*</span></label>
                                <select name="store_id" class="form-select bg-black text-white border-secondary focus-gold" required>
                                    <option value="">-- بدون متجر (اختياري) --</option>
                                    @foreach($stores as $store)
                                        <option value="{{ $store->store_id }}" 
                                            {{ old('store_id', $warehouse->store_id) == $store->store_id ? 'selected' : '' }}>
                                            {{ $store->store_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            {{-- Manager Designation --}}
                            <div class="col-md-6">
                                <label class="form-label text-gold small fw-bold">ASSIGNED MANAGER <span class="text-danger">*</span></label>
                                <select name="manager_id" class="form-select bg-black text-white border-secondary focus-gold" required>
                                    @foreach($managers as $manager)
                                        <option value="{{ $manager->user_id }}" 
                                            {{ old('manager_id', $warehouse->manager_id) == $manager->user_id ? 'selected' : '' }}>
                                            {{ $manager->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Technical Brochure --}}
                        <div class="mb-4">
                            <label class="form-label text-gold small fw-bold">TECHNICAL BROCHURE (PDF/IMAGE)</label>
                            
                            @if($warehouse->brochure)
                                <div class="mb-3 p-3 bg-black bg-opacity-50 rounded border border-gold border-opacity-25 d-flex align-items-center justify-content-between shadow-sm">
                                    <div class="small">
                                        <i class="fas fa-paperclip text-gold me-2"></i>
                                        <span class="text-muted">Current File:</span> 
                                        <a href="{{ asset('uploads/brochures/' . $warehouse->brochure) }}" target="_blank" class="text-info text-decoration-none ms-1 fw-bold">
                                            {{ Str::limit($warehouse->brochure, 30) }}
                                        </a>
                                    </div>
                                    <span class="badge bg-secondary opacity-50 small">KEEPING EXISTING</span>
                                </div>
                            @endif
                            
                            <input type="file" name="brochure" class="form-control bg-black text-white border-secondary focus-gold">
                            <div class="form-text text-muted small mt-2">Only upload a new file if you wish to replace the current brochure.</div>
                        </div>

                        {{-- Additional Description --}}
                        <div class="mb-4">
                            <label class="form-label text-gold small fw-bold">INTERNAL NOTES / DESCRIPTION</label>
                            <textarea name="description" class="form-control bg-black text-white border-secondary focus-gold" rows="3" placeholder="Additional hub details...">{{ old('description', $warehouse->description) }}</textarea>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between align-items-center mt-5 border-top pt-4 border-secondary border-opacity-25">
                            <a href="{{ route('warehouses.index') }}" class="btn btn-link text-muted text-decoration-none">
                                <i class="fas fa-times me-1"></i> Cancel Changes
                            </a>
                            <button type="submit" class="btn btn-gold px-5 shadow-sm fw-bold">
                                <i class="fas fa-save me-2"></i> UPDATE HUB DATA
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
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
    }
    
    .btn-gold:hover { 
        background-color: #fff; 
        color: #000; 
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3);
    }

    .focus-gold:focus {
        background-color: #000 !important;
        color: white !important;
        border-color: var(--accent1) !important;
        box-shadow: 0 0 12px rgba(212, 175, 55, 0.15);
    }

    .form-control, .form-select {
        padding: 12px;
        border-radius: 8px;
    }

    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23d4af37' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    }
</style>
@endsection