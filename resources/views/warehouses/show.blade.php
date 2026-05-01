@extends('layouts.app')

@section('title', 'Hub Inventory Details | Aurum Time')

@section('content')
<div class="container mt-4">
    {{-- الجزء العلوي: ملف المستودع --}}
    <div class="card bg-dark border-gold text-white mb-5 shadow-lg animate__animated animate__fadeIn">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start mb-4 border-bottom border-secondary pb-3">
                <div>
                    <h2 class="text-gold fw-bold mb-1" style="letter-spacing: 1px;">
                        <i class="fas fa-warehouse me-2"></i> {{ $warehouse->warehouse_name ?? $warehouse->name }}
                    </h2>
                    <p class="text-white-50 mb-0">
                        <i class="fas fa-map-marker-alt me-2 text-gold"></i>{{ $warehouse->city }} Hub Location
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('warehouses.edit', $warehouse->warehouse_id) }}" class="btn btn-gold btn-sm px-4">
                        <i class="fas fa-edit me-1"></i> MODIFY HUB
                    </a>
                    <a href="{{ route('warehouses.index') }}" class="btn btn-outline-light btn-sm px-4">BACK TO LIST</a>
                </div>
            </div>

            <div class="row g-4 text-center">
                {{-- المتجر --}}
                <div class="col-md-4">
                    <div class="p-3 rounded bg-black bg-opacity-50 border border-secondary h-100">
                        <small class="text-gold d-block mb-2 text-uppercase fw-bold" style="font-size: 0.75rem;">Affiliated Store</small>
                       <span class="fw-bold fs-5 text-white">
    {{ $warehouse->store->store_name ?? 'N/A' }}
</span>
                    </div>
                </div>

                {{-- المدير --}}
                <div class="col-md-4">
    <div class="p-3 rounded bg-black bg-opacity-50 border border-secondary h-100 text-center">
        <small class="text-gold d-block mb-2 text-uppercase fw-bold" style="font-size: 0.75rem;">Regional Manager</small>
        
        <span class="fw-bold fs-5 text-white">
            @if($warehouse->manager)
                {{-- نستخدم الاسم الكامل الموجود في صورتك --}}
                {{ $warehouse->manager->full_name ?? 'Name Empty in DB' }}
            @else
                <span class="text-white-50 small italic">Not Assigned</span>
            @endif
        </span>
    </div>
</div>

                {{-- زر التحميل في هذا العمود --}}
                <div class="col-md-4">
                    <div class="p-3 rounded bg-black bg-opacity-50 border border-secondary h-100">
                        <small class="text-gold d-block mb-2 text-uppercase fw-bold" style="font-size: 0.75rem;">Technical Documentation</small>
                        
                        @if($warehouse->brochure)
                            {{-- زر التحميل باللون الذهبي ليكون واضحاً --}}
                            <a href="{{ asset('storage/' . $warehouse->brochure) }}" 
                               download="{{ ($warehouse->warehouse_name ?? 'Warehouse') }}_Brochure.pdf" 
                               class="btn btn-gold btn-sm w-100 mt-2 shadow-sm">
                                <i class="fas fa-download me-1"></i> DOWNLOAD BROCHURE
                            </a>
                        @else
                            <span class="text-muted small d-block mt-2">
                                <i class="fas fa-info-circle me-1"></i> No file attached
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- قسم المخزون النشط --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-gold mb-0 fw-bold border-start border-gold border-4 ps-3">ACTIVE INVENTORY</h3>
        <span class="badge bg-gold text-dark px-4 py-2 rounded-pill fw-bold">Total Items: {{ count($products) }}</span>
    </div>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card bg-dark border-gold text-white h-100 product-card shadow">
                    <div class="position-relative">
                        @if($product->upload_file)
                            <img src="{{ asset('uploads/products/' . $product->upload_file) }}" 
                                 class="card-img-top border-gold-bottom" 
                                 alt="{{ $product->product_name }}" 
                                 style="height: 250px; object-fit: cover;">
                        @else
                            <div class="bg-black d-flex align-items-center justify-content-center border-gold-bottom" style="height: 250px;">
                                <i class="fas fa-clock fa-4x text-gold opacity-25"></i>
                            </div>
                        @endif
                        <div class="price-tag">${{ number_format($product->price, 2) }}</div>
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="text-gold fw-bold mb-2">{{ $product->product_name }}</h5>
                        <p class="small text-white-50 mb-4 flex-grow-1">
                            {{ Str::limit($product->description, 90) }}
                        </p>
                        <div class="pt-3 border-top border-secondary d-flex justify-content-between align-items-center">
                            <span class="small text-uppercase text-muted">ID: #{{ $product->product_id }}</span>
                            <a href="{{ route('products.edit', $product->product_id) }}" class="btn btn-sm btn-outline-gold rounded-pill px-3">
                                <i class="fas fa-cog me-1"></i> Manage
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 border-gold border-dashed rounded bg-black bg-opacity-25 shadow-sm">
                    <i class="fas fa-box-open fa-4x mb-3 text-gold opacity-25"></i>
                    <h4 class="text-white fw-bold">No Inventory Found</h4>
                    <p class="text-white-50">There are no items assigned to {{ $warehouse->warehouse_name ?? $warehouse->name }}.</p>
                    <a href="{{ route('products.create') }}" class="btn btn-gold btn-sm mt-3 px-4">
                        <i class="fas fa-plus me-1"></i> ADD PRODUCT
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
    :root { --gold: #D4AF37; }
    .border-gold { border: 1.5px solid var(--gold) !important; }
    .border-gold-bottom { border-bottom: 2.5px solid var(--gold) !important; }
    .text-gold { color: var(--gold) !important; }
    .bg-gold { background-color: var(--gold) !important; }
    
    .btn-gold { 
        background-color: var(--gold); 
        color: #000 !important; 
        border: none; 
        font-weight: bold;
        text-transform: uppercase;
        transition: 0.3s;
    }
    .btn-gold:hover { 
        background-color: #fff; 
        color: #000 !important;
        transform: translateY(-2px);
    }
    .btn-outline-gold {
        border: 1px solid var(--gold);
        color: var(--gold);
    }
    .btn-outline-gold:hover {
        background-color: var(--gold);
        color: #000;
    }
    .price-tag {
        position: absolute; bottom: 10px; right: 10px;
        background: rgba(0, 0, 0, 0.85); color: var(--gold);
        padding: 5px 15px; border-radius: 4px;
        font-weight: bold; border: 1px solid var(--gold);
        backdrop-filter: blur(4px);
    }
    .product-card { transition: all 0.3s ease; }
    .product-card:hover { transform: translateY(-8px); border-color: #fff !important; }
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
</style>
@endsection