@extends('layouts.app')

@section('title', 'Establish Warehouse | Aurum Time')

{{-- 1. إضافة مكتبة Select2 CSS وتنسيقها --}}
@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* تنسيق قائمة الاختيار المتعدد لتناسب التصميم الداكن */
    .select2-container--default .select2-selection--multiple {
        background-color: #000 !important;
        border: 1px solid #6c757d !important; /* لون الحدود الافتراضي */
        min-height: 45px;
        padding: 5px;
        transition: 0.3s;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #d4af37 !important; /* اللون الذهبي عند الضغط */
        box-shadow: 0 0 10px rgba(212, 175, 55, 0.2);
    }

    /* تنسيق العناصر المختارة (الموظفين) */
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #d4af37 !important; /* الخلفية الذهبية للموظف المختار */
        color: #000 !important;
        font-weight: bold;
        border: none !important;
        padding: 2px 10px !important;
        margin-top: 5px !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #000 !important;
        margin-right: 5px !important;
    }

    /* تنسيق القائمة المنسدلة نفسها */
    .select2-dropdown {
        background-color: #000 !important;
        border: 1px solid #d4af37 !important;
        color: white !important;
    }

    .select2-results__option--highlighted[aria-selected] {
        background-color: #d4af37 !important;
        color: #000 !important;
    }

    .select2-search__field {
        background-color: #000 !important;
        color: white !important;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-gold bg-dark text-white animate__animated animate__fadeInDown">
                <div class="card-header border-gold text-center py-4 bg-transparent">
                    <h3 class="text-gold fw-bold mb-0" style="letter-spacing: 2px;">ESTABLISH NEW WAREHOUSE</h3>
                    <p class="small text-muted mt-2 text-uppercase">Configure a new logistics hub for the global network</p>
                </div>
                
                <div class="card-body p-4">
                    
                    {{-- Error Notifications --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 mb-4 py-2" style="background-color: rgba(220, 53, 69, 0.1); color: #ff8a8a;">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('warehouses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-gold small fw-bold">WAREHOUSE NAME <span class="text-danger">*</span></label>
                                <input type="text" name="warehouse_name" 
                                       class="form-control bg-black text-white border-secondary @error('warehouse_name') is-invalid @enderror" 
                                       placeholder="e.g. Aurum Central Hub" 
                                       value="{{ old('warehouse_name') }}"
                                       minlength="3" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-gold small fw-bold">CITY / REGION <span class="text-danger">*</span></label>
                                <input type="text" name="city" 
                                       class="form-control bg-black text-white border-secondary @error('city') is-invalid @enderror" 
                                       placeholder="e.g. Dubai, London, Riyadh" 
                                       value="{{ old('city') }}"
                                       required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            {{-- Requirement #6: Store Association (Optional) --}}
                            <div class="col-md-6">
                                <label class="form-label text-gold small fw-bold">AFFILIATED STORE</label>
                                <select name="store_id" class="form-select bg-black text-white border-secondary @error('store_id') is-invalid @enderror">
                                    <option value="">-- NO STORE (OPTIONAL) --</option>
                                    @foreach($stores as $store)
                                        <option value="{{ $store->store_id }}" {{ old('store_id') == $store->store_id ? 'selected' : '' }}>
                                            {{ $store->store_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Requirement #7: Manager Designation --}}
                            <div class="col-md-6">
                                <label class="form-label text-gold small fw-bold">ASSIGNED MANAGER <span class="text-danger">*</span></label>
                                <select name="manager_id" class="form-select bg-black text-white border-secondary @error('manager_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>Select Manager...</option>
                                    @foreach($managers as $manager)
                                        <option value="{{ $manager->user_id }}" {{ old('manager_id') == $manager->user_id ? 'selected' : '' }}>
                                            {{ $manager->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- اختيار الموظفين - التعديل الجديد --}}
                      <div class="col-md-5">
                                <label class="form-label text-gold small fw-bold">ASSIGNED STAFF <span class="text-danger">*</span></label>
                                <select name="staff_id" class="form-select bg-black text-white border-secondary @error('staff_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>Select STAFF...</option>
                                    @foreach($staffs as $staff)
                                        <option value="{{ $staff->user_id }}" {{ old('staff_id') == $staff->user_id ? 'selected' : '' }}>
                                            {{ $staff->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Requirement #1: Technical Brochure --}}
                        <div class="mb-4">
                            <label class="form-label text-gold small fw-bold">TECHNICAL BROCHURE (PDF/IMAGE)</label>
                            <input type="file" name="brochure" class="form-control bg-black text-white border-secondary @error('brochure') is-invalid @enderror">
                            <div class="form-text text-muted" style="font-size: 0.7rem;">Upload warehouse specifications or blueprints.</div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5 border-top pt-4 border-secondary">
                            <a href="{{ route('warehouses.index') }}" class="btn btn-link text-muted text-decoration-none small">
                                <i class="fas fa-arrow-left me-1"></i> Return to Hubs
                            </a>
                            <button type="submit" class="btn btn-gold px-5 shadow-sm">
                                <i class="fas fa-plus-square me-2"></i> ESTABLISH HUB
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 2. إضافة سكربتات تشغيل Select2 --}}
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#staff-select').select2({
            placeholder: "  Search and select staff members...",
            width: '100%',
            allowClear: true
        });
    });
</script>
@endsection

<style>
    .border-gold { border: 1px solid #d4af37 !important; }
    .text-gold { color: #d4af37; }
    
    .btn-gold { 
        background-color: #d4af37; 
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
        border-width: 1px;
    }

    .form-control:focus, .form-select:focus {
        background-color: #000 !important;
        color: white !important;
        border-color: #d4af37 !important;
        box-shadow: 0 0 10px rgba(212, 175, 55, 0.2);
    }

    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23d4af37' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    }
</style>
@endsection