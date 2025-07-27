@extends('layouts.admin')

@section('page-title', 'Applications')

@section('content')
<div class="applications-container">
    <!-- Clean Header -->
    <div class="page-header-clean">
        <div class="header-main">
            <h1 class="page-title-clean">
                <i class="fas fa-users pulse-icon"></i>
                Applications
            </h1>
            <div class="header-actions">
                <a href="{{ route('application.form') }}" class="btn-modern btn-primary">
                    <i class="fas fa-plus"></i>
                    <span>New Application</span>
                </a>
                <a href="{{ route('applications.export') }}" class="btn-modern btn-success">
                    <i class="fas fa-download"></i>
                    <span>Export</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="controls-bar">
        <div class="search-container">
            <div class="search-box-modern">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" placeholder="Search applications..." class="search-input-modern">
            </div>
        </div>
        <div class="filter-container">
            <select id="positionFilter" class="filter-select-modern" onchange="filterByPosition()">
                <option value="">All Positions</option>
                @foreach($applications->pluck('apply_job')->unique() as $position)
                    <option value="{{ $position }}">{{ $position }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="table-container-modern">
        <div class="table-card">
            <table class="table-modern" id="applicationsTable">
                <thead>
                    <tr>
                        <th>App No</th>
                        <th>Applicant</th>
                        <th>Position</th>
                        <th>Contact</th>
                        <th>Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $application)
                    <tr class="table-row-modern fade-in" data-id="{{ $application->id }}">
                        <td>
                            <span class="badge-modern badge-primary">{{ $application->application_no }}</span>
                        </td>
                        <td>
                            <div class="applicant-card">
                                <div class="applicant-avatar">
                                    {{ substr($application->name, 0, 1) }}
                                </div>
                                <div class="applicant-info">
                                    <div class="applicant-name">{{ $application->name }}</div>
                                    <div class="applicant-father">{{ $application->father_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-modern badge-info">{{ $application->apply_job }}</span>
                        </td>
                        <td>
                            <div class="contact-info">
                                <div class="contact-item">
                                    <i class="fas fa-phone"></i>
                                    <span>{{ $application->mobile }}</span>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <span>{{ Str::limit($application->gmail, 25) }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="date-info">
                                {{ $application->date ? (is_string($application->date) ? \Carbon\Carbon::parse($application->date)->format('M j, Y') : $application->date->format('M j, Y')) : 'N/A' }}
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="action-group">
                                <a href="{{ route('applications.show', $application->id) }}" 
                                   class="action-btn action-btn-view" 
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('applications.edit', $application->id) }}" 
                                   class="action-btn action-btn-edit" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('applications.downloadPDF', $application->id) }}" 
                                   class="action-btn action-btn-pdf" 
                                   title="Download PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <button type="button" 
                                        class="action-btn action-btn-delete" 
                                        title="Delete"
                                        onclick="confirmDelete({{ $application->id }}, '{{ $application->application_no }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="no-data-row">
                        <td colspan="6" class="text-center">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h3>No Applications Found</h3>
                                <p>Start by creating your first job application</p>
                                <a href="{{ route('application.form') }}" class="btn-modern btn-primary">
                                    <i class="fas fa-plus"></i>
                                    <span>Create Application</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($applications->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <div class="pagination-wrapper">
            {{ $applications->links('pagination::bootstrap-4') }}
        </div>
    </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay">
    <div class="modal-modern">
        <div class="modal-header-modern">
            <h3><i class="fas fa-exclamation-triangle text-danger"></i> Confirm Delete</h3>
            <button type="button" class="modal-close-modern" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body-modern">
            <p>Are you sure you want to delete application <strong id="deleteAppNo"></strong>?</p>
            <p class="text-muted">This action cannot be undone.</p>
        </div>
        <div class="modal-footer-modern">
            <button type="button" class="btn-modern btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-modern btn-danger">
                    <i class="fas fa-trash"></i>
                    <span>Delete</span>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
/* Modern Applications Management Styles */
.applications-container {
    padding: 0;
    background: #f8f9fa;
    min-height: 100vh;
}

/* Clean Header */
.page-header-clean {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    margin-bottom: 30px;
    border-radius: 0 0 20px 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.header-main {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

.page-title-clean {
    font-size: 2.2rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 15px;
}

.pulse-icon {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.header-actions {
    display: flex;
    gap: 15px;
}

/* Modern Buttons */
.btn-modern {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
    font-size: 0.9rem;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.btn-secondary {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.btn-danger {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    color: white;
}

/* Controls Bar */
.controls-bar {
    background: white;
    padding: 20px 30px;
    margin-bottom: 20px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

.search-container {
    flex: 1;
    max-width: 400px;
}

.search-box-modern {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 15px;
    color: #666;
    z-index: 1;
}

.search-input-modern {
    width: 100%;
    padding: 12px 15px 12px 45px;
    border: 2px solid #e9ecef;
    border-radius: 25px;
    font-size: 14px;
    outline: none;
    transition: all 0.3s ease;
}

.search-input-modern:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.filter-container {
    display: flex;
    gap: 15px;
}

.filter-select-modern {
    padding: 12px 20px;
    border: 2px solid #e9ecef;
    border-radius: 25px;
    font-size: 14px;
    outline: none;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-select-modern:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Modern Table */
.table-container-modern {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    margin-bottom: 30px;
}

.table-card {
    overflow-x: auto;
}

.table-modern {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.table-modern thead {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.table-modern th {
    padding: 20px 15px;
    text-align: left;
    font-weight: 600;
    color: #495057;
    border: none;
    font-size: 0.9rem;
}

.table-modern td {
    padding: 20px 15px;
    border-bottom: 1px solid #f1f3f4;
    vertical-align: middle;
}

.table-row-modern {
    transition: all 0.3s ease;
    opacity: 0;
    animation: fadeInUp 0.6s ease-out forwards;
}

.table-row-modern:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Stagger animation for table rows */
.table-row-modern:nth-child(1) { animation-delay: 0.1s; }
.table-row-modern:nth-child(2) { animation-delay: 0.2s; }
.table-row-modern:nth-child(3) { animation-delay: 0.3s; }
.table-row-modern:nth-child(4) { animation-delay: 0.4s; }
.table-row-modern:nth-child(5) { animation-delay: 0.5s; }

/* Modern Badges */
.badge-modern {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-align: center;
    white-space: nowrap;
}

.badge-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.badge-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

/* Applicant Card */
.applicant-card {
    display: flex;
    align-items: center;
    gap: 12px;
}

.applicant-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
}

.applicant-info {
    flex: 1;
}

.applicant-name {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 2px;
}

.applicant-father {
    font-size: 0.8rem;
    color: #6c757d;
}

/* Contact Info */
.contact-info {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
}

.contact-item i {
    color: #6c757d;
    width: 12px;
}

/* Date Info */
.date-info {
    font-weight: 500;
    color: #495057;
}

/* Action Buttons */
.action-group {
    display: flex;
    gap: 5px;
    justify-content: center;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    border-radius: 8px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.action-btn-view {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.action-btn-edit {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
}

.action-btn-pdf {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    color: white;
}

.action-btn-delete {
    background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);
    color: white;
}

/* Empty State */
.empty-state {
    padding: 60px 20px;
    text-align: center;
}

.empty-icon {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 20px;
}

.empty-state h3 {
    color: #6c757d;
    margin-bottom: 10px;
}

.empty-state p {
    color: #adb5bd;
    margin-bottom: 30px;
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

/* Modal Styles */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    backdrop-filter: blur(5px);
}

.modal-modern {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 15px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    max-width: 500px;
    width: 90%;
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translate(-50%, -60%);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%);
    }
}

.modal-header-modern {
    padding: 25px 30px 20px;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header-modern h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.modal-close-modern {
    background: none;
    border: none;
    font-size: 1.2rem;
    color: #6c757d;
    cursor: pointer;
    padding: 5px;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.modal-close-modern:hover {
    background: #f8f9fa;
    color: #495057;
}

.modal-body-modern {
    padding: 25px 30px;
}

.modal-footer-modern {
    padding: 20px 30px 25px;
    display: flex;
    justify-content: flex-end;
    gap: 15px;
}

.text-danger {
    color: #dc3545;
}

.text-muted {
    color: #6c757d;
}

.text-center {
    text-align: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-main {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }
    
    .controls-bar {
        flex-direction: column;
        gap: 15px;
    }
    
    .search-container {
        max-width: 100%;
    }
    
    .action-group {
        flex-wrap: wrap;
    }
    
    .page-title-clean {
        font-size: 1.8rem;
    }
}

.table-wrapper {
    min-width: 100%;
    overflow-x: auto;
}

.applications-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.applications-table th {
    background: #f8f9fa;
    padding: 15px 12px;
    text-align: left;
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #e0e0e0;
    white-space: nowrap;
}

.applications-table th i {
    margin-right: 5px;
    color: #2196F3;
}

.sortable {
    cursor: pointer;
    user-select: none;
    position: relative;
}

.sortable:hover {
    background: #e9ecef;
}

.sort-icon {
    margin-left: 5px;
    opacity: 0.5;
}

.applications-table td {
    padding: 15px 12px;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
}

.application-row:hover {
    background: #f8f9fa;
}

.app-badge {
    background: #2196F3;
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.applicant-details {
    display: flex;
    flex-direction: column;
}

.applicant-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 2px;
}

.father-name {
    color: #666;
    font-size: 12px;
}

.position-badge {
    background: #4CAF50;
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.date-display {
    font-weight: 600;
    color: #333;
}

.created-date {
    color: #666;
    font-size: 11px;
    display: block;
    margin-top: 2px;
}

.phone-link, .email-link {
    color: #2196F3;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 5px;
}

.phone-link:hover, .email-link:hover {
    text-decoration: underline;
}

.education-badge {
    background: #FF9800;
    color: white;
    padding: 2px 6px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 500;
}

.experience {
    color: #666;
    font-size: 11px;
    display: block;
    margin-top: 2px;
}

.action-buttons {
    display: flex;
    gap: 5px;
}

.btn-action {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 12px;
    transition: all 0.2s ease;
}

.btn-view {
    background: #17a2b8;
    color: white;
}

.btn-edit {
    background: #ffc107;
    color: #212529;
}

.btn-pdf {
    background: #dc3545;
    color: white;
}

.btn-delete {
    background: #6c757d;
    color: white;
}

.btn-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.no-data-message {
    padding: 60px 20px;
    text-align: center;
    color: #666;
}

.no-data-message i {
    font-size: 48px;
    color: #ccc;
    margin-bottom: 20px;
}

.no-data-message h3 {
    margin: 0 0 10px;
    color: #333;
}

.stats-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    padding: 30px;
    background: #f8f9fa;
}

.stat-card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 20px;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
    background: linear-gradient(135deg, #2196F3, #1976D2);
}

.stat-info h3 {
    font-size: 28px;
    font-weight: bold;
    margin: 0;
    color: #333;
}

.stat-info p {
    margin: 5px 0 0;
    color: #666;
    font-size: 14px;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
}

.modal-content {
    background: white;
    margin: 15% auto;
    padding: 0;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.modal-header {
    padding: 20px;
    border-bottom: 1px solid #e0e0e0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    color: #dc3545;
    display: flex;
    align-items: center;
    gap: 10px;
}

.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #666;
}

.modal-body {
    padding: 20px;
}

.warning-text {
    color: #dc3545;
    font-size: 14px;
    margin-top: 10px;
}

.modal-footer {
    padding: 20px;
    border-top: 1px solid #e0e0e0;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }
    
    .action-bar {
        flex-direction: column;
        align-items: stretch;
    }
    
    .action-left, .action-right {
        justify-content: center;
    }
    
    .search-input {
        width: 200px;
    }
    
    .stats-cards {
        grid-template-columns: 1fr;
        padding: 20px;
    }
}
</style>

<script>
// Search functionality
function searchApplications() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('.application-row');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
}

// Filter by position
function filterByPosition() {
    const selectedPosition = document.getElementById('positionFilter').value;
    const rows = document.querySelectorAll('.application-row');
    
    rows.forEach(row => {
        const positionCell = row.querySelector('.position-badge').textContent;
        row.style.display = !selectedPosition || positionCell === selectedPosition ? '' : 'none';
    });
}

// Delete confirmation
function confirmDelete(id, appNo) {
    document.getElementById('deleteAppNo').textContent = appNo;
    document.getElementById('deleteForm').action = `/admin/applications/${id}`;
    document.getElementById('deleteModal').style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

// Real-time search
document.getElementById('searchInput').addEventListener('input', searchApplications);

// Table sorting
document.querySelectorAll('.sortable').forEach(header => {
    header.addEventListener('click', function() {
        const table = document.getElementById('applicationsTable');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('.application-row'));
        const sortKey = this.dataset.sort;
        const isAscending = !this.classList.contains('sort-asc');
        
        // Reset all sort icons
        document.querySelectorAll('.sortable').forEach(h => {
            h.classList.remove('sort-asc', 'sort-desc');
        });
        
        // Set current sort direction
        this.classList.add(isAscending ? 'sort-asc' : 'sort-desc');
        
        // Sort rows
        rows.sort((a, b) => {
            let aVal, bVal;
            
            switch(sortKey) {
                case 'application_no':
                    aVal = a.querySelector('.app-badge').textContent;
                    bVal = b.querySelector('.app-badge').textContent;
                    break;
                case 'name':
                    aVal = a.querySelector('.applicant-name').textContent;
                    bVal = b.querySelector('.applicant-name').textContent;
                    break;
                case 'apply_job':
                    aVal = a.querySelector('.position-badge').textContent;
                    bVal = b.querySelector('.position-badge').textContent;
                    break;
                case 'date':
                    aVal = a.querySelector('.date-display').textContent;
                    bVal = b.querySelector('.date-display').textContent;
                    break;
                default:
                    return 0;
            }
            
            if (aVal < bVal) return isAscending ? -1 : 1;
            if (aVal > bVal) return isAscending ? 1 : -1;
            return 0;
        });
        
        // Re-append sorted rows
        rows.forEach(row => tbody.appendChild(row));
    });
});
</script>
@endsection