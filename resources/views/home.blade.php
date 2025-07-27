@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Dashboard Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="dashboard-title">Admin Dashboard</h1>
                        <p class="dashboard-subtitle">Mahin Facility Services - Application Management</p>
                    </div>
                    <div class="dashboard-actions">
                        <span class="current-time">{{ now()->format('l, F j, Y - g:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card stats-card-primary">
                <div class="card-body">
                    <div class="stats-content">
                        <div class="stats-info">
                            <div class="stats-number">{{ $totalApplications }}</div>
                            <div class="stats-label">Total Applications</div>
                            <div class="stats-change">+{{ $todayApplications }} today</div>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stats-card stats-card-success">
                <div class="card-body">
                    <div class="stats-content">
                        <div class="stats-info">
                            <div class="stats-number">{{ $todayApplications }}</div>
                            <div class="stats-label">Today's Applications</div>
                            <div class="stats-change">{{ now()->format('M j, Y') }}</div>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stats-card stats-card-info">
                <div class="card-body">
                    <div class="stats-content">
                        <div class="stats-info">
                            <div class="stats-number">{{ $thisMonthApplications }}</div>
                            <div class="stats-label">This Month</div>
                            <div class="stats-change">{{ now()->format('F Y') }}</div>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stats-card stats-card-warning">
                <div class="card-body">
                    <div class="stats-content">
                        <div class="stats-info">
                            <div class="stats-number">{{ $applicationsByJob->count() }}</div>
                            <div class="stats-label">Job Categories</div>
                            <div class="stats-change">Active positions</div>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Recent Applications -->
        <div class="col-md-8 col-lg-8" style="flex: 0 0 70%; max-width: 70%;">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pb-3">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="fas fa-clock text-primary me-2"></i>
                        Recent Applications
                    </h5>
                    <a href="{{ route('admin.applications.index') }}" class="btn btn-primary btn-sm px-3 py-2">
                        <i class="fas fa-eye me-1"></i>View All
                    </a>
                </div>
                <div class="card-body">
                    @if($recentApplications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th width="15%">App No</th>
                                        <th width="45%">Name</th>
                                        <th width="40%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentApplications as $app)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary px-2 py-1">
                                                #{{ $app->application_no }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar-small me-2 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem; font-weight: bold;">
                                                    {{ strtoupper(substr($app->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-medium text-dark">{{ $app->name }}</div>
                                                    <small class="text-muted">{{ $app->apply_job }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('applications.show', $app) }}" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('applications.edit', $app) }}" 
                                                   class="btn btn-outline-warning btn-sm" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('applications.downloadPDF', $app) }}" 
                                                   class="btn btn-outline-success btn-sm" 
                                                   title="Download PDF">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <form action="{{ route('applications.destroy', $app) }}" 
                                                      method="POST" 
                                                      class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this application?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-outline-danger btn-sm" 
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No applications found.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Applications by Job Type -->
        <div class="col-md-4 col-lg-4" style="flex: 0 0 30%; max-width: 30%;">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="fas fa-chart-bar text-primary me-2"></i>
                        Applications by Position
                    </h5>
                </div>
                <div class="card-body position-scrollable">
                    @if($applicationsByJob->count() > 0)
                        @foreach($applicationsByJob as $job)
                        <div class="position-item mb-3 p-3 bg-light rounded-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium text-dark">{{ $job->apply_job }}</span>
                                <span class="badge bg-primary rounded-pill px-3 py-2">
                                    {{ $job->count }} 
                                    <small class="text-white-50">apps</small>
                                </span>
                            </div>
                            <div class="progress" style="height: 10px; border-radius: 10px;">
                                <div class="progress-bar bg-gradient" role="progressbar" 
                                     style="width: {{ ($job->count / $totalApplications) * 100 }}%; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);"
                                     data-bs-toggle="tooltip" 
                                     title="{{ number_format(($job->count / $totalApplications) * 100, 1) }}% of total applications"></div>
                            </div>
                            <small class="text-muted mt-1 d-block">
                                {{ number_format(($job->count / $totalApplications) * 100, 1) }}% of total
                            </small>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="text-muted mb-0">No position data available</p>
                            <small class="text-muted">Applications will appear here once submitted</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.applications.index') }}" class="action-btn action-btn-primary w-100">
                                <i class="fas fa-list-ul"></i>
                                <span>View All Applications</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('applications.export') }}" class="action-btn action-btn-success w-100">
                                <i class="fas fa-file-excel"></i>
                                <span>Export to Excel</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('application.form') }}" class="action-btn action-btn-info w-100">
                                <i class="fas fa-user-plus"></i>
                                <span>New Application</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="action-btn action-btn-warning w-100" onclick="refreshDashboard()">
                                <i class="fas fa-sync-alt"></i>
                                <span>Refresh Data</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Header */
.dashboard-header {
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: white;
    padding: 30px;
    border-radius: 15px;
    margin-bottom: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.dashboard-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 5px;
    color: white;
}

.dashboard-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 0;
}

.dashboard-stats-icon {
    font-size: 2.5rem;
    opacity: 0.9;
    margin-left: 15px;
    color: rgba(255, 255, 255, 0.9);
    text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.current-time {
    font-size: 0.95rem;
    opacity: 0.8;
    background: rgba(255,255,255,0.1);
    padding: 8px 15px;
    border-radius: 20px;
}

/* Statistics Cards */
.stats-card {
    border: none;
    border-radius: 1rem;
    overflow: hidden;
    transition: all 0.3s ease;
    margin-bottom: 25px;
    position: relative;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.stats-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(255,255,255,0.1), transparent);
    pointer-events: none;
}

.stats-card-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.stats-card-success {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.stats-card-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.stats-card-warning {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
}

.stats-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 5px;
}

.stats-label {
    font-size: 1rem;
    font-weight: 500;
    opacity: 0.9;
    margin-bottom: 5px;
}

.stats-change {
    font-size: 0.85rem;
    opacity: 0.8;
    background: rgba(255,255,255,0.2);
    padding: 3px 8px;
    border-radius: 10px;
    display: inline-block;
}

.stats-icon {
    font-size: 3rem;
    opacity: 0.3;
}

/* Regular Cards */
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.08);
    margin-bottom: 25px;
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 8px 35px rgba(0,0,0,0.12);
}

.card-header {
    background: linear-gradient(135deg, #2196F3, #1976D2);
    color: white;
    border-radius: 15px 15px 0 0 !important;
    border: none;
    padding: 20px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 80px;
}

.card-body {
    padding: 20px;
    font-size: 0.9rem;
    line-height: 1.5;
}

/* Fixed Height Cards with Scrollbars */
.card.h-100 {
    height: 450px !important;
    max-height: 450px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.card.h-100 .card-body {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
}

/* Position Card Scrollable Styling */
.position-scrollable {
    max-height: none;
    overflow-y: auto;
    overflow-x: hidden;
    padding-right: 10px;
}

/* Recent Applications Table Scrollable */
.table-responsive {
    max-height: none;
    overflow-y: visible;
    border-radius: 8px;
}

.table-responsive::-webkit-scrollbar {
    width: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.05);
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: rgba(0, 123, 255, 0.3);
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 123, 255, 0.5);
}

/* Enhanced Table Styling */
.table {
    font-size: 0.85rem;
    margin-bottom: 0;
}

.table th {
    font-size: 0.8rem;
    font-weight: 600;
    color: #495057;
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    padding: 10px 8px;
}

.table td {
    padding: 8px;
    vertical-align: middle;
    border-top: 1px solid #dee2e6;
}

.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

/* Card Header Sizing */
.card-header h5 {
    font-size: 1rem;
    font-weight: 600;
}

/* Buttons */
.btn {
    border-radius: 10px;
    font-weight: 500;
    padding: 10px 20px;
    transition: all 0.3s ease;
    border: none;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.btn-primary {
    border-radius: 10px;
    background: linear-gradient(135deg, #2196F3, #1976D2);
}

.btn-success {
    border-radius: 10px;
    background: linear-gradient(135deg, #4CAF50, #388E3C);
}

.btn-info { 
    border-radius: 10px;
    background: linear-gradient(135deg, #00BCD4, #0097A7);
}

.btn-danger {
    border-radius: 10px;
    background: linear-gradient(135deg, #f44336, #d32f2f);
}

.btn-block {
    width: 100%;
    margin-bottom: 10px;
}

/* Table Improvements */
.table {
    border-radius: 10px;
    overflow: hidden;
}

.table thead th {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border: none;
    font-weight: 600;
    color: #495057;
    padding: 15px;
}

.table tbody td {
    padding: 15px;
    border: none;
    border-bottom: 1px solid #f1f3f4;
    vertical-align: middle;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

/* Progress Bars */
.progress {
    border-radius: 10px;
    background-color: rgba(255,255,255,0.2);
}

.progress-bar {
    background: linear-gradient(135deg, #2196F3, #1976D2) !important;
    border-radius: 10px;
}

/* Badges */
.badge-primary {
    background: linear-gradient(135deg, #2196F3, #1976D2);
    border-radius: 10px;
    padding: 5px 10px;
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-title {
        font-size: 2rem;
    }
    
    .stats-number {
        font-size: 2rem;
    }
    
    .stats-icon {
        font-size: 2rem;
    }
    
    .dashboard-header {
        padding: 20px;
    }
    
    .current-time {
        display: none;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stats-card, .card {
    animation: fadeInUp 0.6s ease-out;
}

.stats-card:nth-child(1) { animation-delay: 0.1s; }
.stats-card:nth-child(2) { animation-delay: 0.2s; }
.stats-card:nth-child(3) { animation-delay: 0.3s; }
.stats-card:nth-child(4) { animation-delay: 0.4s; }

/* Small Action Buttons */
.action-btn-sm {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 6px;
    text-decoration: none;
    margin: 0 2px;
    transition: all 0.3s ease;
    font-size: 0.85rem;
}

.action-btn-sm:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.action-btn-sm.action-btn-primary {
    background: linear-gradient(135deg, #2196F3, #1976D2);
    color: white;
}

.action-btn-sm.action-btn-warning {
    background: linear-gradient(135deg, #FF9800, #F57C00);
    color: white;
}

.action-btn-sm.action-btn-danger {
    background: linear-gradient(135deg, #f44336, #d32f2f);
    color: white;
}

.action-buttons {
    display: flex;
    gap: 5px;
}

/* User Avatar Small */
.user-avatar-small {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
}

/* Enhanced Badges */
.badge {
    font-size: 0.75rem;
    padding: 6px 10px;
    border-radius: 12px;
    font-weight: 500;
}

.bg-primary {
    background: linear-gradient(135deg, #2196F3, #1976D2) !important;
}

.bg-info {
    background: linear-gradient(135deg, #00BCD4, #0097A7) !important;
}

/* Loading Animation */
.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
function refreshDashboard() {
    // Show loading state
    const refreshBtn = event.target.closest('.action-btn');
    const originalContent = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '<div class="loading-spinner"></div> <span>Refreshing...</span>';
    refreshBtn.style.pointerEvents = 'none';
    
    // Simulate refresh (reload page after short delay)
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

// Add smooth animations to stats cards on load
document.addEventListener('DOMContentLoaded', function() {
    // Animate numbers counting up
    const statsNumbers = document.querySelectorAll('.stats-number');
    statsNumbers.forEach(number => {
        const finalValue = parseInt(number.textContent);
        let currentValue = 0;
        const increment = finalValue / 30;
        
        const counter = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                number.textContent = finalValue;
                clearInterval(counter);
            } else {
                number.textContent = Math.floor(currentValue);
            }
        }, 50);
    });
    
    // Add hover effects to action buttons
    const actionButtons = document.querySelectorAll('.action-btn-sm');
    actionButtons.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.05)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>

@endsection
