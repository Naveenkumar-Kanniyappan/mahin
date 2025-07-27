<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application - {{ $application->application_no }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2196F3;
            padding-bottom: 15px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2196F3;
            margin-bottom: 5px;
        }
        .form-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .app-no {
            font-size: 14px;
            color: #666;
        }
        .content {
            display: flex;
            gap: 20px;
        }
        .form-section {
            flex: 1;
        }
        .photo-section {
            width: 150px;
            text-align: center;
        }
        .photo-box {
            width: 150px;
            height: 180px;
            border: 2px solid #2196F3;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }
        .photo-box img {
            max-width: 140px;
            max-height: 170px;
            object-fit: cover;
        }
        .form-row {
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
        }
        .form-row label {
            width: 140px;
            font-weight: bold;
            color: #2196F3;
            margin-right: 10px;
        }
        .form-row .value {
            flex: 1;
            border-bottom: 1px solid #ccc;
            padding-bottom: 2px;
            min-height: 16px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2196F3;
            margin: 20px 0 15px 0;
            border-bottom: 1px solid #2196F3;
            padding-bottom: 5px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        @media print {
            body { margin: 0; padding: 15px; }
            .header { page-break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">MAHIN FACILITY SERVICES</div>
        <div class="form-title">JOB APPLICATION FORM</div>
        <div class="app-no">Application No: {{ $application->application_no }}</div>
    </div>

    <div class="content">
        <div class="form-section">
            <div class="section-title">Personal Information</div>
            
            <div class="form-row">
                <label>Date:</label>
                <div class="value">{{ $application->date ? $application->date->format('d/m/Y') : $application->date }}</div>
            </div>
            
            <div class="form-row">
                <label>Location:</label>
                <div class="value">{{ $application->location }}</div>
            </div>
            
            <div class="form-row">
                <label>Name:</label>
                <div class="value">{{ $application->name }}</div>
            </div>
            
            <div class="form-row">
                <label>Father's Name:</label>
                <div class="value">{{ $application->father_name }}</div>
            </div>
            
            <div class="form-row">
                <label>Address:</label>
                <div class="value">{{ $application->address }}</div>
            </div>
            
            <div class="form-row">
                <label>Mobile:</label>
                <div class="value">{{ $application->mobile }}</div>
            </div>
            
            <div class="form-row">
                <label>Email:</label>
                <div class="value">{{ $application->gmail }}</div>
            </div>

            <div class="section-title">Identity & Banking</div>
            
            <div class="form-row">
                <label>Aadhar No:</label>
                <div class="value">{{ $application->aadhar }}</div>
            </div>
            
            <div class="form-row">
                <label>PAN No:</label>
                <div class="value">{{ $application->pan ?? 'N/A' }}</div>
            </div>
            
            <div class="form-row">
                <label>Bank Account:</label>
                <div class="value">{{ $application->bank_account_no }}</div>
            </div>
            
            <div class="form-row">
                <label>IFSC Code:</label>
                <div class="value">{{ $application->ifsc }}</div>
            </div>

            <div class="section-title">Professional Information</div>
            
            <div class="form-row">
                <label>Education:</label>
                <div class="value">{{ $application->education }}</div>
            </div>
            
            <div class="form-row">
                <label>Experience:</label>
                <div class="value">{{ $application->experience }}</div>
            </div>
            
            <div class="form-row">
                <label>Applied Position:</label>
                <div class="value">{{ $application->apply_job }}</div>
            </div>
        </div>

        <div class="photo-section">
            <div class="photo-box">
                @if($application->photo_path)
                    <img src="{{ public_path('storage/' . $application->photo_path) }}" alt="Applicant Photo">
                @else
                    <div style="color: #999;">No Photo</div>
                @endif
            </div>
            <div style="font-size: 10px; color: #666;">Passport Size Photo</div>
        </div>
    </div>

    <div class="footer">
        <p>Generated on {{ now()->format('d/m/Y H:i:s') }} | Mahin Facility Services Job Application System</p>
    </div>
</body>
</html>
