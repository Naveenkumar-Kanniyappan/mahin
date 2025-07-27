<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahin Facility Services Application</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 50%, #0D47A1 100%);
            min-height: 100vh;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #2196F3;
            padding-bottom: 20px;
            position: relative;
        }
        
        .header::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 150px;
            height: 3px;
            background: #1976D2;
        }
        .form-row {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .form-row label {
            width: 200px;
            font-weight: 600;
            color: #1976D2;
            flex-shrink: 0;
        }
        
        .form-row input, .form-row select {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-row input:focus, .form-row select:focus {
            outline: none;
            border-color: #2196F3;
            box-shadow: 0 0 10px rgba(33, 150, 243, 0.2);
            transform: translateY(-1px);
        }
        .photo-upload {
            margin-bottom: 25px;
            text-align: center;
            padding: 20px;
            border: 2px dashed #2196F3;
            border-radius: 10px;
            background: #E3F2FD;
        }
        
        .photo-preview {
            width: 150px;
            height: 180px;
            object-fit: cover;
            border: 3px solid #2196F3;
            border-radius: 10px;
            margin: 10px auto;
            display: block;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background: #f5f5f5;
        }
        
        .default-user-icon {
            width: 150px;
            height: 180px;
            border: 3px solid #2196F3;
            border-radius: 10px;
            margin: 10px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #E3F2FD, #BBDEFB);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .default-user-icon i {
            font-size: 4rem;
            color: #1976D2;
            opacity: 0.7;
        }
        
        .photo-upload input[type="file"] {
            margin: 10px 0;
            padding: 10px;
            border: 2px solid #2196F3;
            border-radius: 8px;
            background: white;
        }
        .actions {
            margin-top: 30px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .actions button, .actions a {
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-width: 120px;
            justify-content: center;
        }
        #searchBtn {
            background: linear-gradient(135deg, #1976D2, #0D47A1);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            box-shadow: 0 4px 15px rgba(25, 118, 210, 0.4);
        }
        .btn-submit {
            background: linear-gradient(135deg, #1976D2, #0D47A1);
            color: white;
            box-shadow: 0 4px 15px rgba(25, 118, 210, 0.4);
        }
        
        .btn-update {
            background: linear-gradient(135deg, #1976D2, #0D47A1);
            color: white;
            box-shadow: 0 4px 15px rgba(25, 118, 210, 0.4);
        }
        
        .btn-clear {
            background: linear-gradient(135deg, #1565C0, #0D47A1);
            color: white;
            box-shadow: 0 4px 15px rgba(21, 101, 192, 0.4);
        }
        
        .btn-download {
            background: linear-gradient(135deg, #1976D2, #1565C0);
            color: white;
            box-shadow: 0 4px 15px rgba(25, 118, 210, 0.4);
        }
        
        .btn-print {
            background: linear-gradient(135deg, #1976D2, #1565C0);
            color: white;
            box-shadow: 0 4px 15px rgba(25, 118, 210, 0.4);
        }
        
        .btn-cancel {
            background: linear-gradient(135deg, #42A5F5, #1976D2);
            color: white;
            box-shadow: 0 4px 15px rgba(66, 165, 245, 0.4);
        }
        
        .btn-back {
            background: linear-gradient(135deg, #1976D2, #1565C0);
            color: white;
            box-shadow: 0 4px 15px rgba(25, 118, 210, 0.4);
        }
        
        .btn-edit {
            background: linear-gradient(135deg, #1976D2, #0D47A1);
            color: white;
            box-shadow: 0 4px 15px rgba(25, 118, 210, 0.4);
        }
        
        .actions button:hover, .actions a:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }
        
        .actions button:active, .actions a:active {
            transform: translateY(0);
        }
        .alert {
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-weight: 500;
            border-left: 5px solid;
        }
        
        .alert-danger {
            background: #ffebee;
            color: #c62828;
            border-left-color: #f44336;
        }
        
        .alert-success {
            background: #e8f5e8;
            color: #2e7d32;
            border-left-color: #4CAF50;
        }
        
        .alert-info {
            background: #e3f2fd;
            color: #1565c0;
            border-left-color: #2196F3;
        }
        .edit-mode {
            background: linear-gradient(135deg, #fffde7, #fff8e1);
            border: 2px solid #FF9800;
        }
        .spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            vertical-align: middle;
            border: 0.2em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border .75s linear infinite;
        }
        
        @keyframes spinner-border {
            to { transform: rotate(360deg); }
        }
        
        /* Additional styling for better appearance */
        .right-info {
            background: #E3F2FD;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #2196F3;
        }
        
        .right-info input {
            border: 2px solid #2196F3;
            border-radius: 8px;
            padding: 8px 12px;
        }
        
        .appno {
            color: #1976D2;
        }
        
        .appno span {
            background: white;
            color: #1976D2;
            font-weight: bold;
            border: 2px solid #2196F3 !important;
        }
        
        hr {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, #2196F3, #1976D2, #2196F3);
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <form id="applicationForm" method="POST" 
          action="{{ isset($application) ? route('applications.update', $application->id) : route('applications.store') }}" 
          enctype="multipart/form-data">
        @csrf
        @if(isset($application))
            @method('PUT')
            <input type="hidden" name="id" value="{{ $application->id }}">
        @endif
        
        <div class="container {{ isset($application) ? 'edit-mode' : '' }}">
            <!-- Header Section -->
            <div class="header">
                <div>
                    <img src="{{ asset('images/form-logo.jpeg') }}" alt="Logo" style="width: 140px; height: 140px; object-fit: contain;">
                </div>
                <div style="text-align: center;">
                    <img src="{{ asset('images/form-tittle.jpeg') }}" alt="Company Logo" style="width: 70%; height: 60px;">
                    <p style="margin-top: 5px; text-align: center; font-size: large; color: #0601a0;">
                        23A, Bus Stand Road,<br>
                        Aruppukkottai-626101, Virudhunagar (Dit).
                    </p>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="right-info" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div style="display: flex; align-items: center;">
                    <label for="date" style="font-weight: bold; margin-right: 10px;">Date:</label>
                   <input type="date" id="date" name="date" 
       value="{{ 
           isset($application) ? 
               (is_string($application->date) ? \Carbon\Carbon::parse($application->date)->format('Y-m-d') : $application->date->format('Y-m-d')) : 
               (old('date') ?: \Carbon\Carbon::now()->format('Y-m-d')) 
       }}" required>
                </div>
                <div style="display: flex; align-items: center;">
                    <label for="location" style="font-weight: bold; margin-right: 10px;">Location:</label>
                    <input type="text" id="location" name="location" value="{{ isset($application) ? $application->location : old('location') }}" required>
                </div>
                <div class="appno" style="font-weight: bold;">
                    App No: <span id="AppNo" style="border:1px solid #777; border-radius:3px; padding: 3px 25px;">
                        {{ isset($application) ? $application->application_no : $appNo }}
                    </span>
                </div>
            </div>

            <hr style="height:1px; border-width:0; background-color: #333; margin-bottom: 20px;">

            <!-- Alerts Section -->
            <div id="formAlerts">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <!-- Photo Upload -->
            <div class="photo-upload">
                <label for="photo" style="font-weight: bold; display: block; margin-bottom: 5px;">Upload Photo:</label>
                <input type="file" id="photo" name="photo" accept="image/*" onchange="previewPhoto(event)" {{ !isset($application) ? 'required' : '' }}>
                <div id="photoContainer">
                    @if(isset($application) && $application->photo_path)
                        <img id="photoPreview" class="photo-preview" 
                             src="{{ asset('storage/'.$application->photo_path) }}" 
                             alt="Photo Preview" 
                             style="display: block;">
                    @else
                        <div id="defaultIcon" class="default-user-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <img id="photoPreview" class="photo-preview" 
                             src="" 
                             alt="Photo Preview" 
                             style="display: none;">
                    @endif
                </div>
            </div>

            <!-- Personal Information -->
            <div class="form-row">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="{{ isset($application) ? $application->name : old('name') }}" required>
            </div>

            <div class="form-row">
                <label for="father_name">Father/Mother Name:</label>
                <input type="text" id="father_name" name="father_name" value="{{ isset($application) ? $application->father_name : old('father_name') }}" required>
            </div>

            <div class="form-row">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="{{ isset($application) ? $application->address : old('address') }}" required>
            </div>

            <div class="form-row">
                <label for="mobile">Mobile No:</label>
                <input type="text" id="mobile" name="mobile" value="{{ isset($application) ? $application->mobile : old('mobile') }}" required>
            </div>

            <div class="form-row">
                <label for="gmail">Gmail ID:</label>
                <input type="email" id="gmail" name="gmail" value="{{ isset($application) ? $application->gmail : old('gmail') }}" required>
            </div>

            <!-- Document Information -->
            <div class="form-row">
                <label for="aadhar">Aadhar No:</label>
                <input type="text" id="aadhar" name="aadhar" value="{{ isset($application) ? $application->aadhar : old('aadhar') }}" required>
            </div>

            <div class="form-row">
                <label for="pan">PAN No:</label>
                <input type="text" id="pan" name="pan" value="{{ isset($application) ? $application->pan : old('pan') }}">
            </div>

            <!-- Bank Information -->
            <div class="form-row">
                <label for="bank_account_no">Bank Account No:</label>
                <input type="text" id="bank_account_no" name="bank_account_no" value="{{ isset($application) ? $application->bank_account_no : old('bank_account_no') }}" required>
            </div>

            <div class="form-row">
                <label for="ifsc">IFSC Code:</label>
                <input type="text" id="ifsc" name="ifsc" value="{{ isset($application) ? $application->ifsc : old('ifsc') }}" required>
            </div>

            <!-- Education and Experience -->
            <div class="form-row">
                <label for="education">Education:</label>
                <select id="education" name="education" required>
                    <option value="">Select</option>
                    <option value="10" {{ (isset($application) && $application->education == '10') || old('education') == '10' ? 'selected' : '' }}>10th</option>
                    <option value="+2" {{ (isset($application) && $application->education == '+2') || old('education') == '+2' ? 'selected' : '' }}>12th</option>
                    <option value="Graduation" {{ (isset($application) && $application->education == 'Graduation') || old('education') == 'Graduation' ? 'selected' : '' }}>Graduation</option>
                    <option value="Post Graduation" {{ (isset($application) && $application->education == 'Post Graduation') || old('education') == 'Post Graduation' ? 'selected' : '' }}>Post Graduation</option>
                </select>
            </div>

            <div class="form-row">
                <label for="experience">Experience:</label>
                <input type="text" id="experience" name="experience" value="{{ isset($application) ? $application->experience : old('experience') }}" required>
            </div>

            <!-- Job Application -->
            <div class="form-row">
                <label for="apply_job">Apply For Job:</label>
                <select id="apply_job" name="apply_job" required>
                    <option value="">Select</option>
                    @foreach(['Supervisor', 'Captain', 'Cashier', 'Waiter', 'Food master', 'Chat master', 'Dishwash', 'Kitchen assistant', 'Sales man', 'House keeping', 'Stall man', 'Security', 'Load man'] as $job)
                        <option value="{{ $job }}" 
                            {{ (isset($application) && $application->apply_job == $job) || old('apply_job') == $job ? 'selected' : '' }}>
                            {{ $job }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Search and Actions -->
            <div class="form-row">
                <label for="searchAppNo">Search Application:</label>
                <input type="text" id="searchAppNo" name="searchAppNo" placeholder="APP number or ID" style="width: 150px;">
                <button type="button" id="searchBtn" class="btn-download" onclick="searchApplication()" style="margin-left: 10px;">Search</button>
            </div>

            <div class="actions">
                <!-- <button type="button" class="btn-clear" onclick="clearForm()">Clear Form</button> -->
                <button type="button" class="btn-download" onclick="downloadPDF()">Download PDF</button>
                <button type="button" class="btn-print" onclick="window.print()">Print</button>
                @if(isset($application))
                    <button type="submit" class="btn-update" id="submitBtn">Update</button>
                    <a href="{{ route('applications.show', $application->id) }}" class="btn-cancel">Cancel</a>
                @else
                    <button type="submit" class="btn-submit" id="submitBtn">Submit</button>
                @endif
            </div>
        </div>
    </form>

    <script>
        // Preview uploaded photo
        function previewPhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('photoPreview');
                    const defaultIcon = document.getElementById('defaultIcon');
                    
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    
                    if (defaultIcon) {
                        defaultIcon.style.display = 'none';
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        // Download as PDF
        function downloadPDF() {
            const element = document.querySelector('.container');
            const appNo = document.getElementById('AppNo').textContent.trim();
            const opt = {
                margin: 10,
                filename: `application-${appNo}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }

        // Enable form for editing
        function enableFormForEditing() {
            // Enable all form fields
            const formElements = document.querySelectorAll('#applicationForm input, #applicationForm select, #applicationForm textarea');
            formElements.forEach(element => {
                element.disabled = false;
                element.readOnly = false;
            });
            
            // Show submit button as Update
            const submitBtn = document.getElementById('submitBtn');
            if(submitBtn) {
                submitBtn.style.display = 'inline-flex';
                submitBtn.textContent = 'Update';
                submitBtn.className = 'btn-update';
            }
            
            // Hide navigation buttons during editing
            const navButtons = document.querySelectorAll('.btn-back, .btn-edit');
            navButtons.forEach(btn => btn.style.display = 'none');
            
            showAlert('info', 'Form enabled for editing. Make your changes and click Update.');
        }
        
        // Disable form for viewing
        function disableFormForViewing() {
            // Disable all form fields
            const formElements = document.querySelectorAll('#applicationForm input, #applicationForm select, #applicationForm textarea');
            formElements.forEach(element => {
                element.disabled = true;
                element.readOnly = true;
            });
            
            // Hide submit button
            const submitBtn = document.getElementById('submitBtn');
            if(submitBtn) {
                submitBtn.style.display = 'none';
            }
        }

        // Clear form
        function clearForm() {
            if(confirm('Are you sure you want to clear all form data?')) {
                document.getElementById('applicationForm').reset();
                const preview = document.getElementById('photoPreview');
                const defaultIcon = document.getElementById('defaultIcon');
                
                preview.style.display = 'none';
                preview.src = '';
                
                if (defaultIcon) {
                    defaultIcon.style.display = 'flex';
                }
                
                // Remove navigation buttons
                const navButtons = document.querySelectorAll('.btn-cancel, .btn-back, .btn-edit');
                navButtons.forEach(btn => btn.remove());
                
                // Reset form action and method
                const form = document.getElementById('applicationForm');
                form.action = '/applications';
                const methodInput = form.querySelector('input[name="_method"]');
                if(methodInput) methodInput.remove();
                const idInput = form.querySelector('input[name="id"]');
                if(idInput) idInput.remove();
                
                // Reset submit button
                const submitBtn = document.getElementById('submitBtn');
                if(submitBtn) {
                    submitBtn.textContent = 'Submit';
                    submitBtn.className = 'btn-submit';
                    submitBtn.style.display = 'inline-flex';
                }
                
                // Enable form fields
                const formElements = document.querySelectorAll('#applicationForm input, #applicationForm select, #applicationForm textarea');
                formElements.forEach(element => {
                    element.disabled = false;
                    element.readOnly = false;
                });
            }
        }

        // Search application
        async function searchApplication() {
            const searchTerm = document.getElementById('searchAppNo').value.trim();
            if(!searchTerm) {
                showAlert('danger', 'Please enter an application number or ID');
                return;
            }
            
            // Show loading state
            const searchBtn = document.querySelector('.btn-download');
            const originalBtnText = searchBtn.innerHTML;
            searchBtn.disabled = true;
            searchBtn.innerHTML = '<span class="spinner"></span> Searching...';
            
            try {
                const response = await fetch(`/applications/search?searchAppNo=${encodeURIComponent(searchTerm)}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if(!response.ok) {
                    const error = await response.json();
                    throw error;
                }

                const data = await response.json();
                
                // Populate form fields
                const fields = [
                    'date', 'location', 'name', 'father_name', 'address',
                    'mobile', 'gmail', 'aadhar', 'pan', 'bank_account_no',
                    'ifsc', 'education', 'experience', 'apply_job'
                ];
                
                fields.forEach(field => {
                    if (document.getElementById(field)) {
                        document.getElementById(field).value = data[field] || '';
                    }
                });
                
                // Update application number display
                document.getElementById('AppNo').textContent = data.application_no;
                
                // Set photo preview
                const preview = document.getElementById('photoPreview');
                const defaultIcon = document.getElementById('defaultIcon');
                
                if(data.photo_path) {
                    preview.src = `/storage/${data.photo_path}`;
                    preview.style.display = 'block';
                    if (defaultIcon) {
                        defaultIcon.style.display = 'none';
                    }
                } else {
                    preview.style.display = 'none';
                    if (defaultIcon) {
                        defaultIcon.style.display = 'flex';
                    }
                }
                
                // Update form action for update
                const form = document.getElementById('applicationForm');
                form.action = `/applications/${data.id}`;
                
                // Add hidden ID field if not exists
                if(!document.querySelector('input[name="id"]')) {
                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'id';
                    idInput.value = data.id;
                    form.appendChild(idInput);
                }
                
                // Add method override for PUT if not exists
                if(!document.querySelector('input[name="_method"]')) {
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    form.appendChild(methodInput);
                }
                
                // Change button to Update
                const submitBtn = document.getElementById('submitBtn');
                if(submitBtn) {
                    submitBtn.textContent = 'Update';
                    submitBtn.className = 'btn-update';
                }
                
                // Remove existing navigation buttons
                const existingNavButtons = document.querySelectorAll('.btn-cancel, .btn-back, .btn-edit');
                existingNavButtons.forEach(btn => btn.remove());
                
                // Add navigation buttons
                const actionsDiv = document.querySelector('.actions');
                
                // Add Back to List button
                const backBtn = document.createElement('button');
                backBtn.type = 'button';
                backBtn.className = 'btn btn-back';
                backBtn.textContent = 'Back to List';
                backBtn.onclick = function() {
                    window.location.href = '/';
                };
                actionsDiv.appendChild(backBtn);
                
                // Add Edit button
                const editBtn = document.createElement('button');
                editBtn.type = 'button';
                editBtn.className = 'btn btn-edit';
                editBtn.textContent = 'Edit';
                editBtn.onclick = function() {
                    // Enable form fields for editing
                    enableFormForEditing();
                };
                actionsDiv.appendChild(editBtn);
                
                // Add Cancel button
                const cancelBtn = document.createElement('button');
                cancelBtn.type = 'button';
                cancelBtn.className = 'btn btn-cancel';
                cancelBtn.textContent = 'Cancel';
                cancelBtn.onclick = function() {
                    clearForm();
                    window.location.href = '/';
                };
                actionsDiv.appendChild(cancelBtn);
                
                // Disable form for viewing
                disableFormForViewing();
                
                // Show success message
                showAlert('success', 'Application loaded successfully!');
            } catch (error) {
                showAlert('danger', error.message || 'Failed to load application');
            } finally {
                searchBtn.disabled = false;
                searchBtn.innerHTML = originalBtnText;
            }
        }

        // Form submission handler
        document.getElementById('applicationForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const form = e.target;
            const submitBtn = document.getElementById('submitBtn');
            const isUpdate = form.querySelector('input[name="_method"]');
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner"></span> Processing...';

            try {
                // Create FormData and manually append all fields
                const formData = new FormData();
                const fields = [
                    'date', 'location', 'name', 'father_name', 'address',
                    'mobile', 'gmail', 'aadhar', 'pan', 'bank_account_no',
                    'ifsc', 'education', 'experience', 'apply_job'
                ];

                fields.forEach(field => {
                    if (form[field]) {
                        formData.append(field, form[field].value);
                    }
                });

                // Add CSRF token and method
                let csrfToken = form.querySelector('input[name="_token"]')?.value;
                if (!csrfToken) {
                    // Fallback to meta tag if form token not found
                    csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                }
                if (!csrfToken) {
                    throw new Error('CSRF token not found. Please refresh the page and try again.');
                }
                formData.append('_token', csrfToken);
                if (isUpdate) {
                    formData.append('_method', 'PUT');
                    formData.append('id', form.id.value);
                }

                // Handle file upload
                if (form.photo.files[0]) {
                    formData.append('photo', form.photo.files[0]);
                }

                const url = isUpdate ? `/applications/${form.id.value}` : '/applications';
                const response = await fetch(url, {
                    method: 'POST', // Always POST when using FormData
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    throw data;
                }

                if (data.success) {
                    showAlert('success', data.message);
                    
                    if (!isUpdate) {
                        // Reset form for new submissions
                        form.reset();
                        const preview = document.getElementById('photoPreview');
                        preview.style.display = 'none';
                        preview.src = 'https://via.placeholder.com/150';
                        
                        if (data.new_app_no) {
                            document.getElementById('AppNo').textContent = data.new_app_no;
                        }
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                let errorMessage = 'An error occurred. Please try again.';
                
                if (error.errors) {
                    errorMessage = Object.values(error.errors).join('<br>');
                } else if (error.message) {
                    errorMessage = error.message;
                }
                
                showAlert('danger', errorMessage);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = isUpdate ? 'Update' : 'Submit';
            }
        });

        // Show alert message
        function showAlert(type, message) {
            const alertsContainer = document.getElementById('formAlerts');
            alertsContainer.innerHTML = `
                <div class="alert alert-${type}">
                    ${message}
                </div>
            `;
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                alertsContainer.innerHTML = '';
            }, 5000);
        }

        // Auto-fill form if coming from search
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const searchAppNo = urlParams.get('searchAppNo');
            
            if(searchAppNo) {
                document.getElementById('searchAppNo').value = searchAppNo;
                searchApplication();
            }
        });
    </script>
</body>
</html>