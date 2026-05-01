{{-- This file contains the card loop for AJAX updates --}}

@forelse($warehouses as $warehouse)
    <div class="col-md-6 mb-4 animate__animated animate__fadeIn">
        <div class="card bg-dark border-gold text-white shadow-lg h-100 warehouse-item">
            <div class="card-body p-4">
                {{-- Header: Name & Location --}}
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h4 class="text-gold mb-1 fw-bold">
                            <i class="fas fa-warehouse me-2"></i> {{ $warehouse->warehouse_name }}
                        </h4>
                        <small class="text-muted text-uppercase fw-bold" style="letter-spacing: 1px;">
                            <i class="fas fa-map-marker-alt text-gold me-1"></i> {{ $warehouse->city ?? 'Global Distribution' }}
                        </small>
                    </div>
                    <span class="badge bg-gold text-dark px-3 py-2 rounded-pill shadow-sm small fw-bold">ACTIVE</span>
                </div>
                
                {{-- Details Box --}}
                <div class="p-3 mb-4 rounded bg-black bg-opacity-40 border border-secondary border-opacity-25 shadow-inner">
                    <div class="small mb-2 d-flex align-items-center">
                        <i class="fas fa-store text-gold me-3" style="width: 15px;"></i>
                        <span class="text-secondary me-2">Affiliated Store:</span> 
                        <span class="text-white fw-bold">{{ $warehouse->store_name ?? 'Aurum Central' }}</span>
                    </div>
                    <div class="small mb-3 d-flex align-items-center">
                        <i class="fas fa-user-tie text-gold me-3" style="width: 15px;"></i>
                        <span class="text-secondary me-2">Manager in Charge:</span> 
                        <span class="text-white fw-bold">{{ $warehouse->manager_full_name ?? 'Head Office' }}</span>
                    </div>

                    {{-- PDF Brochure Link --}}
                    @if($warehouse->brochure)
                    <div class="pt-2 border-top border-secondary border-opacity-25 mt-2">
                        <a href="{{ asset('uploads/brochures/' . $warehouse->brochure) }}" target="_blank" class="text-gold text-decoration-none small fw-bold hover-link">
                            <i class="fas fa-file-pdf text-danger me-2"></i> VIEW HUB BROCHURE (PDF)
                        </a>
                    </div>
                    @endif
                </div>
                
                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between align-items-center mt-auto pt-2">
                    {{-- Left Side: View Products --}}
                    <a href="{{ route('warehouses.show', $warehouse->warehouse_id) }}" class="btn btn-sm btn-gold px-3 rounded-pill fw-bold">
                        <i class="fas fa-gem me-1"></i> VIEW WATCHES
                    </a>

                    {{-- Right Side: Edit & Delete --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('warehouses.edit', $warehouse->warehouse_id) }}" class="btn btn-sm btn-outline-light px-3 rounded-pill opacity-75 hover-opacity-100">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form action="{{ route('warehouses.destroy', $warehouse->warehouse_id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to decommission this warehouse? Linked timepieces will remain in inventory but unassigned.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-pill shadow-hover">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    {{-- Empty State (Search Results) --}}
    <div class="col-12 text-center py-5 mt-4">
        <div class="p-5 border-gold border-dashed rounded bg-dark bg-opacity-30 shadow-lg">
            <i class="fas fa-search-location fa-4x mb-4 text-gold opacity-25"></i>
            <h4 class="text-gold fw-bold">NO MATCHING HUBS FOUND</h4>
            <p class="mb-0 text-white opacity-50">No warehouses in the Aurum network match your current search criteria.</p>
        </div>
    </div>
@endforelse

<style>
    .warehouse-item { 
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); 
        border: 1px solid rgba(212, 175, 55, 0.2) !important;
    }
    
    .warehouse-item:hover { 
        border-color: var(--accent1) !important; 
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important;
    }

    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
    
    .hover-link:hover { text-decoration: underline !important; color: #fff !important; }
    
    .hover-opacity-100:hover { opacity: 1 !important; }

    .shadow-hover:hover { box-shadow: 0 0 10px rgba(220, 53, 69, 0.4); }
    
    .shadow-inner { box-shadow: inset 0 2px 10px rgba(0,0,0,0.5); }
</style>