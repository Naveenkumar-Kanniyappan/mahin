<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Exports\ApplicationsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::latest()->paginate(10);
        return view('admin.applications.index', compact('applications'));
    }

    public function create()
    {
        $nextId = Application::max('id') + 1;
        $appNo = 'APP' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
        return view('application-form', compact('appNo'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $this->processPhoto($request->file('photo'));
        }

        $application = Application::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully!',
            'new_app_no' => $application->application_no
        ]);
    }

    public function show(Application $application)
    {
        return view('admin.applications.show', compact('application'));
    }

    public function edit(Application $application)
    {
        $appNo = $application->application_no;
        return view('application-form', compact('application', 'appNo'));
    }

    public function update(Request $request, Application $application)
    {
        $validated = $this->validateRequest($request, false);
        
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($application->photo_path) {
                Storage::disk('public')->delete($application->photo_path);
            }
            $validated['photo_path'] = $this->processPhoto($request->file('photo'));
        }

        $application->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Application updated successfully!'
        ]);
    }

    public function destroy(Application $application)
    {
        // Delete photo if exists
        if ($application->photo_path) {
            Storage::disk('public')->delete($application->photo_path);
        }
        
        $application->delete();
        
        return redirect()->route('admin.applications.index')
            ->with('success', 'Application deleted successfully!');
    }

    public function search(Request $request)
    {
        $searchAppNo = trim($request->query('searchAppNo'));

        if (!$searchAppNo) {
            return response()->json(['error' => 'Please enter an application number'], 400);
        }

        $normalizedInput = preg_replace('/\s+/', '', strtolower($searchAppNo));

        try {
            $application = Application::whereRaw('REPLACE(LOWER(application_no), " ", "") = ?', [$normalizedInput])
                ->orWhere('id', $searchAppNo)
                ->first();

            if (!$application) {
                return response()->json(['error' => 'Application not found'], 404);
            }

            return response()->json([
                'id' => $application->id,
                'application_no' => $application->application_no,
                'date' => $application->date ? $application->date->format('Y-m-d') : $application->date,
                'location' => $application->location,
                'name' => $application->name,
                'father_name' => $application->father_name,
                'address' => $application->address,
                'mobile' => $application->mobile,
                'gmail' => $application->gmail,
                'aadhar' => $application->aadhar,
                'pan' => $application->pan,
                'bank_account_no' => $application->bank_account_no,
                'ifsc' => $application->ifsc,
                'education' => $application->education,
                'experience' => $application->experience,
                'apply_job' => $application->apply_job,
                'photo_path' => $application->photo_path
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error, please contact admin.'], 500);
        }
    }

    public function downloadPDF(Application $application)
    {
        $pdf = Pdf::loadView('pdf.application', compact('application'));
        return $pdf->download('application-'.$application->application_no.'.pdf');
    }

    public function export()
    {
        return Excel::download(new ApplicationsExport, 'applications.xlsx');
    }

    protected function validateRequest(Request $request, $requirePhoto = true)
    {
        $rules = [
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'address' => 'required|string',
            'mobile' => 'required|string|digits:10',
            'gmail' => 'required|email|max:255',
            'aadhar' => 'required|string|digits:12',
            'pan' => 'nullable|string|regex:/[A-Z]{5}[0-9]{4}[A-Z]{1}/',
            'bank_account_no' => 'required|string|max:30',
            'ifsc' => 'required|string|max:20',
            'education' => 'required|string|max:50',
            'experience' => 'required|string|max:255',
            'apply_job' => 'required|string|max:50',
        ];

        if ($requirePhoto) {
            $rules['photo'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
        } else {
            $rules['photo'] = 'sometimes|image|mimes:jpeg,png,jpg|max:2048';
        }

        return $request->validate($rules);
    }

    protected function processPhoto($photo)
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($photo)->resize(300, 300)->toJpeg();
        $filename = 'photos/' . uniqid() . '.jpg';
        Storage::disk('public')->put($filename, $image);
        return $filename;
    }
}