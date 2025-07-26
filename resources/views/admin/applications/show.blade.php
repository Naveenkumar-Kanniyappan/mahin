@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Application Details: {{ $application->name }}</h1>
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('storage/'.$application->photo_path) }}" alt="Photo" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <p><strong>Date:</strong> {{ $application->date->format('d/m/Y') }}</p>
                    <p><strong>Location:</strong> {{ $application->location }}</p>
                    <p><strong>Name:</strong> {{ $application->name }}</p>
                    <p><strong>Father/Mother Name:</strong> {{ $application->father_name }}</p>
                    <p><strong>Address:</strong> {{ $application->address }}</p>
                    <p><strong>Mobile:</strong> {{ $application->mobile }}</p>
                    <p><strong>Email:</strong> {{ $application->gmail }}</p>
                    <p><strong>Aadhar:</strong> {{ $application->aadhar }}</p>
                    <p><strong>PAN:</strong> {{ $application->pan ?? 'N/A' }}</p>
                    <p><strong>Bank Account:</strong> {{ $application->bank_account_no }}</p>
                    <p><strong>IFSC:</strong> {{ $application->ifsc }}</p>
                    <p><strong>Education:</strong> {{ $application->education }}</p>
                    <p><strong>Experience:</strong> {{ $application->experience }}</p>
                    <p><strong>Applied Position:</strong> {{ $application->apply_job }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary">Back to List</a>
        <a href="{{ route('applications.edit', $application->id) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection