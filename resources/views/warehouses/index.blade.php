@extends('layouts.app')

@section('title', 'Logistics Hubs | Aurum Time')

@section('content')
<div class="container">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-5 animate__animated animate__fadeIn">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--accent1); letter-spacing: 1px;">CENTRAL LOGISTICS HUBS</h2>
            <p class="text-muted small mb-0 text-uppercase" style="letter-spacing: 2px;">Global Distribution & Inventory Management</p>
        </div>
        <a href="{{ route('warehouses.create') }}" class="btn btn-gold px-4 shadow-sm fw-bold">
            <i class="fas fa-plus-square me-2"></i> ESTABLISH NEW HUB
        </a>
    </div>

    {{-- Advanced Search Section --}}
    <div class="row mb-5 justify-content-center">
        <div class="col-md-7">
            <div class="search-wrapper shadow-lg rounded-pill overflow-hidden border border-gold border-opacity-25 bg-dark">
                <div class="input-group">
                    <span class="input-group-text bg-gold border-0 px-4 text-dark">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control bg-dark text-white border-0 py-3" 
                           placeholder="Search by hub name, city, or assigned manager...">
                </div>
            </div>
            <div id="searchIndicator" class="text-center mt-2 small text-gold opacity-50 d-none">
                <i class="fas fa-spinner fa-spin me-1"></i> Filtering results...
            </div>
        </div>
    </div>

    {{-- Success Notification --}}
    @if(session('success'))
        <div class="alert alert-gold alert-dismissible fade show border-0 text-center mb-4 shadow-lg py-3 animate__animated animate__bounceIn" role="alert">
            <i class="fas fa-check-circle me-2 text-dark"></i> 
            <strong class="text-dark">{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- The Warehouses Grid (Handled by AJAX) --}}
    <div id="warehousesList" class="row">
        @include('warehouses._list')
    </div>
</div>

{{-- AJAX Script for Live Search --}}
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let query = this.value;
        let listContainer = document.getElementById('warehousesList');
        let indicator = document.getElementById('searchIndicator');

        // Show loading indicator
        indicator.classList.remove('d-none');

        fetch(`{{ route('warehouses.index') }}?search=${query}`, {
            headers: { 
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(html => {
            listContainer.innerHTML = html;
            indicator.classList.add('d-none');
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            indicator.classList.add('d-none');
        });
    });
</script>

<style>
    /* Custom Styling for Index */
    .search-wrapper { transition: all 0.3s ease; }
    .search-wrapper:focus-within { 
        border-color: var(--accent1) !important; 
        box-shadow: 0 0 25px rgba(212, 175, 55, 0.2) !important;
        transform: scale(1.01);
    }

    .alert-gold {
        background-color: var(--accent1);
        border-radius: 12px;
    }

    .btn-gold {
        background-color: var(--accent1);
        color: #000;
        border: none;
        transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        font-size: 0.85rem;
    }

    .btn-gold:hover {
        background-color: #fff;
        color: #000;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.4);
    }

    #searchInput::placeholder {
        color: rgba(255,255,255,0.3);
        font-size: 0.9rem;
    }

    #searchInput:focus {
        background-color: #000 !important;
        box-shadow: none;
    }

    .border-gold { border: 1px solid var(--accent1) !important; }
</style>
@endsection