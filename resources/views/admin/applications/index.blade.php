@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Job Applications</h1>
    
    <div class="mb-4">
        <a href="{{ route('applications.export') }}" class="btn btn-success">Export to Excel</a>
    </div>
    
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>App No</th>
                <th>Name</th>
                <th>Position</th>
                <th>Date</th>
                <th>Mobile</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $application)
            <tr>
                <td>{{ $application->application_no }}</td>
                <td>{{ $application->name }}</td>
                <td>{{ $application->apply_job }}</td>
                <td>{{ $application->date->format('d/m/Y') }}</td>
                <td>{{ $application->mobile }}</td>
                <td>
                    <a href="{{ route('applications.show', $application->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('applications.edit', $application->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('applications.downloadPDF', $application->id) }}" class="btn btn-primary btn-sm">PDF</a>
                    <form action="{{ route('applications.destroy', $application->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    {{ $applications->links() }}
</div>
@endsection