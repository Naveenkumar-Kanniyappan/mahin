@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Professional Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <i class="fas fa-file-alt text-primary fs-4"></i>
                            </div>
                            <h1 class="h2 mb-0 text-dark fw-semibold">Application Details</h1>
                        </div>
                        <p class="text-muted mb-0">
                            <span class="badge bg-primary bg-opacity-10 text-primary">{{ $application->apply_job }}</span>
                            <span class="mx-2">•</span>
                            Applied on {{ $application->date->format('M d, Y') }}
                        </p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('admin.applications.index') }}" class="btn btn-outline-primary px-3">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                        <a href="{{ route('applications.edit', $application->id) }}" class="btn btn-primary px-4">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <button class="btn btn-outline-secondary" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Applicant Photo -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 text-dark fw-semibold">
                        <i class="fas fa-user-circle me-2 text-primary"></i>Applicant Profile
                    </h6>
                </div>
                <div class="card-body text-center d-flex flex-column">
                    <div class="mx-auto mb-4 position-relative" style="width: 200px; height: 240px;">
                        @if($application->photo_path && file_exists(storage_path('app/public/'.$application->photo_path)))
                            <img src="{{ asset('storage/'.$application->photo_path) }}" 
                                 alt="{{ $application->name }}" 
                                 class="img-fluid rounded-3 border shadow-sm w-100 h-100 object-fit-cover">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light rounded-3 border shadow-sm w-100 h-100">
                                <i class="fas fa-user text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="mt-auto">
                        <h3 class="h4 text-dark mb-1">{{ $application->name }}</h3>
                        <p class="text-muted mb-2">{{ $application->apply_job }}</p>
                        <div class="d-flex justify-content-center gap-3">
                            <div>
                                <small class="text-muted d-block">Application ID</small>
                                <strong class="text-primary">#{{ $application->id }}</strong>
                            </div>
                            <div>
                                <small class="text-muted d-block">Status</small>
                                <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Information -->
        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="card border mb-4">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0 text-dark">Personal Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Full Name</label>
                            <p class="mb-0">{{ $application->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Father/Mother Name</label>
                            <p class="mb-0">{{ $application->father_name }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted small">Address</label>
                            <p class="mb-0">{{ $application->address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card border mb-4">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0 text-dark">Contact Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Mobile</label>
                            <p class="mb-0">{{ $application->mobile }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Email</label>
                            <p class="mb-0">{{ $application->gmail }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents & Banking -->
            <div class="card border mb-4">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0 text-dark">Documents & Banking</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Aadhar Number</label>
                            <p class="mb-0 font-monospace">{{ $application->aadhar }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">PAN Number</label>
                            <p class="mb-0 font-monospace">{{ $application->pan ?? 'Not Provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Bank Account</label>
                            <p class="mb-0 font-monospace">{{ $application->bank_account_no }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">IFSC Code</label>
                            <p class="mb-0 font-monospace">{{ $application->ifsc }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="card border mb-4">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0 text-dark">Professional Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Education</label>
                            <p class="mb-0">{{ $application->education }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Experience</label>
                            <p class="mb-0">{{ $application->experience }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Location</label>
                            <p class="mb-0">{{ $application->location }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Professional Clean Styling */
.card {
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: 1px solid #dee2e6;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    font-weight: 500;
}

.form-label {
    font-weight: 500;
    margin-bottom: 0.25rem;
}

/* Print Styles */
@media print {
    .btn { 
        display: none !important; 
    }
    .card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
        break-inside: avoid;
        margin-bottom: 1rem;
    }
    .card-header {
        background-color: #f0f0f0 !important;
        -webkit-print-color-adjust: exact;
    }
    .container-fluid {
        max-width: 100% !important;
    }
    body {
        font-size: 12px;
    }
    h2, h5, h6 {
        color: #000 !important;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .d-flex {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>
@endsection