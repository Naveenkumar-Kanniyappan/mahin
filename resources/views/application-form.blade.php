<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahin Facility Services Application</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
           body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
        }
        .form-row {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .form-row label {
            width: 200px;
            font-weight: bold;
        }
        .form-row input, .form-row select {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .photo-upload {
            margin-bottom: 20px;
        }
        .photo-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 10px;
        }
        .photo-upload-btn {
            background: #4CAF50;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
        }
        .actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .actions button, .actions a {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-submit {
            background: #2196F3;
            color: white;
        }
        .btn-update {
            background: #4CAF50;
            color: white;
        }
        .btn-clear {
            background: #f44336;
            color: white;
        }
        .btn-download {
            background: #607d8b;
            color: white;
        }
        .btn-print {
            background: #ff9800;
            color: white;
        }
        .btn-cancel {
            background: #9e9e9e;
            color: white;
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-danger {
            background: #ffdddd;
            border-left: 4px solid #f44336;
        }
        .alert-success {
            background: #ddffdd;
            border-left: 4px solid #4CAF50;
        }
        .edit-mode {
            background-color: #fffde7;
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
                    <img src="{{ asset('images/form-tittle.jpeg') }}" alt="Company Logo" style="width: 40%;">
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
                <img id="photoPreview" class="photo-preview" 
                     src="{{ isset($application) && $application->photo_path ? asset('storage/'.$application->photo_path) : 'https://via.placeholder.com/150' }}" 
                     alt="Photo Preview" 
                     style="{{ (isset($application) && $application->photo_path) ? 'display: block;' : 'display: none;' }}">
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
                <button type="button" class="btn-download" onclick="searchApplication()" style="margin-left: 10px;">Search</button>
            </div>

            <div class="actions">
                <button type="button" class="btn-clear" onclick="clearForm()">Clear Form</button>
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
                    preview.src = e.target.result;
                    preview.style.display = 'block';
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

        // Clear form
        function clearForm() {
            if(confirm('Are you sure you want to clear all form data?')) {
                document.getElementById('applicationForm').reset();
                const preview = document.getElementById('photoPreview');
                preview.style.display = 'none';
                preview.src = 'https://via.placeholder.com/150';
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
                if(data.photo_path) {
                    preview.src = `/storage/${data.photo_path}`;
                    preview.style.display = 'block';
                } else {
                    preview.src = 'https://via.placeholder.com/150';
                    preview.style.display = 'none';
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
                
                // Add Cancel button if not exists
                if(!document.querySelector('.btn-cancel')) {
                    const cancelBtn = document.createElement('a');
                    cancelBtn.href = `/applications/${data.id}`;
                    cancelBtn.className = 'btn-cancel';
                    cancelBtn.textContent = 'Cancel';
                    document.querySelector('.actions').appendChild(cancelBtn);
                }
                
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
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
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