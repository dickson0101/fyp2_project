<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ReportFile;
use App\Models\Appointment;
use Carbon\Carbon;
use PDF;
use ZipArchive;
use Exception;



class PDFController extends Controller
{
    public function index(Request $request)
{
    $patient_id = $request->session()->get('selected_patient_id');
    $patient = User::find($patient_id);

    
    $content = $request->session()->get('pdf_content', ''); 
    $drawingData = $request->session()->get('drawing_data', ''); 

    return view('pdf.index', compact('patient', 'content', 'drawingData'));
}


public function generatePDFAndZip(Request $request)
{
    Log::info('PDF and ZIP generation started');

    $request->validate([
        'description' => 'required|string',
        'drawing' => 'nullable|string',
        'attachments' => 'nullable|array',
        'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
    ]);

    try {
        // Generate PDF
        $content = $request->input('description');
        $drawingData = $request->input('drawing');

        $pdf = PDF::loadView('pdf.template', [
            'content' => $content,
            'drawingData' => $drawingData
        ])->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        // Create a temporary directory
        $tempDir = storage_path('app/temp/' . uniqid());
        if (!File::makeDirectory($tempDir, 0755, true)) {
            Log::error("Failed to create temporary directory: $tempDir");
            return back()->with('error', 'Failed to create temporary directory');
        }

        // Save the generated PDF
        $pdfPath = $tempDir . '/Patient_Report.pdf';
        $pdf->save($pdfPath);
        Log::info("PDF saved: $pdfPath, Size: " . File::size($pdfPath) . " bytes");

        // Handle file attachments
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $fileName = $attachment->getClientOriginalName();
                $savedPath = $attachment->move($tempDir, $fileName);
                if ($savedPath) {
                    $attachments[] = $savedPath;
                    Log::info("Attachment saved: $savedPath, Size: " . File::size($savedPath) . " bytes");
                } else {
                    Log::error("Failed to save attachment: $fileName");
                }
            }
        }

        // Create ZIP file
        $zipName = 'patient_report_' . date('Y-m-d_His') . '.zip';
        $zipPath = storage_path('app/public/' . $zipName);

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            // Add PDF
            $zip->addFile($pdfPath, 'Patient_Report.pdf');
            Log::info("Added to ZIP: Patient_Report.pdf");

            // Add attachments
            foreach ($attachments as $attachment) {
                $fileName = basename($attachment);
                $zip->addFile($attachment, $fileName);
                Log::info("Added to ZIP: $fileName");
            }

            $zip->close();
            Log::info("ZIP file created: $zipPath, Size: " . File::size($zipPath) . " bytes");
        } else {
            Log::error("Failed to create ZIP file");
            return back()->with('error', 'Failed to create ZIP file');
        }

        // Verify ZIP contents
        $verificationZip = new ZipArchive();
        if ($verificationZip->open($zipPath) === TRUE) {
            Log::info("ZIP file contains " . $verificationZip->numFiles . " files");
            for ($i = 0; $i < $verificationZip->numFiles; $i++) {
                $stat = $verificationZip->statIndex($i);
                Log::info("File in ZIP: " . $stat['name'] . ", Size: " . $stat['size'] . " bytes");
            }
            $verificationZip->close();
        } else {
            Log::error("Failed to open ZIP file for verification");
        }

        // Retrieve patient ID and doctor's name
        $patient_id = $request->session()->get('selected_patient_id');
        $doctor = auth()->user();

        if (!$doctor) {
            Log::error("No authenticated user found");
            return back()->with('error', 'No authenticated user found');
        }

        if (!$patient_id) {
            Log::error("No patient ID found in session");
            return back()->with('error', 'Patient ID not found');
        }

        // Get the doctor's name
        $doctor_name = $doctor->name;

        // Upload the ZIP file record to the database
        $relativePath = basename($zipPath);

        ReportFile::create([
            'doctor_name' => $doctor_name,
            'report_date' => now(),
            'file_path' => $relativePath,
            'patient_id' => $patient_id,
        ]);

       

        // Return the ZIP file path for download
        return response()->download($zipPath);

    } catch (Exception $e) {
        Log::error('Error during PDF and ZIP generation: ' . $e->getMessage());
        return back()->with('error', 'An error occurred during PDF and ZIP generation');
    }
}


    // Helper function to recursively remove a directory
   


    public function selectPatient(Request $request)
    {
        // Retrieve all appointments with their associated patients
        $appointments = Appointment::with('patient')
            ->orderBy('appointmentDate', 'asc')
            ->get();
        
        // Extract unique patients from the appointments
        $patientsWithAppointments = $appointments->pluck('patient')->unique('id')->filter();
        
        // Check if a patient is selected and filter appointments accordingly
        $selectedPatientId = $request->input('patient_id');
        $selectedTimeSlot = $request->input('time_slot');
    
        // Filter appointments based on selected patient and time slot
        $filteredAppointments = $appointments->filter(function ($appointment) use ($selectedPatientId, $selectedTimeSlot) {
            return ($appointment->patient->id == $selectedPatientId) && ($selectedTimeSlot ? $appointment->timeSlot == $selectedTimeSlot : true);
        });
    
        // Extract unique time slots for the selected patient
        $timeSlots = $appointments->where('patient_id', $selectedPatientId)->pluck('timeSlot')->unique();
    
        // Log debugging information
        \Log::info('Filtered Appointments: ' . $filteredAppointments->toJson());
        
        // Return the view with the patients and appointments data
        return view('select-patient', [
            'usersWithAppointments' => $patientsWithAppointments,
            'appointments' => $appointments,
            'selectedPatientId' => $selectedPatientId,
            'timeSlots' => $timeSlots,
            'selectedTimeSlot' => $selectedTimeSlot,
            'filteredAppointments' => $filteredAppointments
        ]);
    }
    
    
    
    
    
    public function storeSelectedPatient(Request $request)
    {
        $patientId = $request->input('patient_id');
        $selectedDate = $request->input('selected_date');

        if ($patientId) {
            $patient = User::findOrFail($patientId);
            $request->session()->put('selected_patient_name', $patient->name);
            $request->session()->put('selected_patient_id', $patient->id);
            $request->session()->put('selected_appointment_date', $selectedDate);
            return redirect()->route('pdf.index');
        }

        return redirect()->route('select.patient')->with('error', 'Please select a patient.');
    }
    public function viewReport()
    {
        $reportFiles = ReportFile::with('patient')->get();

        foreach ($reportFiles as $report) {
            $report->file_exists = Storage::disk('public')->exists($report->file_path);
        }

        return view('reportView', compact('reportFiles'));
    }

    public function nurseReport()
    {
        $reportFiles = ReportFile::with('patient')->get();

        foreach ($reportFiles as $report) {
            $report->file_exists = Storage::disk('public')->exists($report->file_path);
        }

        return view('nurseReport', compact('reportFiles'));
    }

    public function viewReports()
{
    $reportFiles = ReportFile::with('patient')->get();
    
    $patient_id = auth()->user()->id; 
    $reports = ReportFile::where('patient_id', $patient_id)->get();

    foreach ($reportFiles as $report) {
        $report->file_exists = Storage::disk('public')->exists($report->file_path);
    }
    
    return view('report', compact('reports', 'patient_id', 'reportFiles'));
}

    public function downloadReport($id)
    {
        $report = ReportFile::findOrFail($id);
        $filePath = $report->file_path;

        if (!Storage::disk('public')->exists($filePath)) {
            Log::error("File not found for download: $filePath");
            return back()->with('error', 'File not found. Please contact support.');
        }

        $fullPath = Storage::disk('public')->path($filePath);
        
        return response()->download($fullPath);
    }


    public function editZip($reportId)
{
    try {
        Log::info("Attempting to edit ZIP for report ID: $reportId");
        
        $report = ReportFile::findOrFail($reportId);
        Log::info("Report found: " . $report->file_path);

        $zipPath = Storage::disk('public')->path($report->file_path);
        Log::info("ZIP path: $zipPath");

        if (!file_exists($zipPath)) {
            Log::error("ZIP file does not exist: $zipPath");
            return back()->with('error', 'ZIP file not found.');
        }

        $tempDir = storage_path('app/temp/' . uniqid());
        Log::info("Temp directory: $tempDir");

        if (!File::makeDirectory($tempDir, 0755, true)) {
            Log::error("Failed to create temp directory: $tempDir");
            return back()->with('error', 'Failed to create temporary directory.');
        }

        $zip = new ZipArchive();
        $openResult = $zip->open($zipPath);
        if ($openResult !== TRUE) {
            Log::error("Failed to open ZIP file. Error code: $openResult");
            return back()->with('error', 'Failed to open ZIP file. Error code: ' . $openResult);
        }

        $extractResult = $zip->extractTo($tempDir);
        if ($extractResult === false) {
            Log::error("Failed to extract ZIP file to: $tempDir");
            return back()->with('error', 'Failed to extract ZIP file.');
        }
        $zip->close();

        $files = File::files($tempDir);
        $pdfContent = '';
        $attachments = [];
        $drawingData = '';

        foreach ($files as $file) {
            if (strtolower($file->getExtension()) === 'pdf') {
                $pdfContent = File::get($file);
                Log::info("PDF content extracted from: " . $file->getFilename());
            } elseif (strtolower($file->getExtension()) === 'png' && $file->getFilename() === 'drawing.png') {
                $drawingData = 'data:image/png;base64,' . base64_encode(File::get($file));
                Log::info("Drawing data extracted from: " . $file->getFilename());
            } else {
                $attachments[] = [
                    'name' => $file->getFilename(),
                    'path' => $file->getPathname(),
                    'size' => $file->getSize(),
                    'type' => $this->getMimeType($file->getPathname())
                ];
                Log::info("Attachment found: " . $file->getFilename());
            }
        }

        Log::info("Rendering editZip view");
        return view('editZip', compact('report', 'pdfContent', 'attachments', 'tempDir', 'drawingData'));
    } catch (\Exception $e) {
        Log::error("Error in editZip: " . $e->getMessage());
        return back()->with('error', 'An error occurred while editing the report: ' . $e->getMessage());
    }
}

private function getMimeType($path)
{
    if (function_exists('mime_content_type')) {
        return mime_content_type($path);
    }

    // Fallback method if mime_content_type is not available
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $path);
    finfo_close($finfo);

    return $mimeType;
}


public function updateZip(Request $request, $reportId)
{
    $report = ReportFile::find($reportId);

    if (!$report) {
        return back()->with('error', 'Report not found.');
    }

    $zipPath = Storage::disk('public')->path($report->file_path);
    $tempDir = storage_path('app/temp/' . uniqid());

    // Extract ZIP contents
    $zip = new ZipArchive();
    if ($zip->open($zipPath) === TRUE) {
        $zip->extractTo($tempDir);
        $zip->close();
    } else {
        return back()->with('error', 'Failed to open ZIP file.');
    }

    // Update PDF content
    if ($request->has('description')) {
        $content = $request->input('description');
        $drawingData = $request->input('drawing');
        $pdf = PDF::loadView('pdf.template', ['content' => $content, 'drawingData' => $drawingData])
            ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->save($tempDir . '/Patient_Report.pdf');
    }

    // Remove attachments
    $removedAttachments = explode(',', $request->input('removed_attachments'));
    foreach ($removedAttachments as $attachment) {
        if (!empty($attachment)) {
            $attachmentPath = $tempDir . '/' . $attachment;
            if (File::exists($attachmentPath)) {
                File::delete($attachmentPath);
            }
        }
    }

    // Add new attachments
    if ($request->hasFile('new_attachments')) {
        foreach ($request->file('new_attachments') as $attachment) {
            $fileName = $attachment->getClientOriginalName();
            $attachment->move($tempDir, $fileName);
        }
    }

    // Recreate ZIP
    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        $files = File::allFiles($tempDir);
        foreach ($files as $file) {
            $relativePath = substr($file->getPathname(), strlen($tempDir) + 1);
            $zip->addFile($file->getPathname(), $relativePath);
        }
        $zip->close();
    } else {
        return back()->with('error', 'Failed to create new ZIP file.');
    }

    // Clean up temporary directory
    File::deleteDirectory($tempDir);

    return redirect()->route('reportView')->with('success', 'Report updated successfully.');
}

public function destroy($id)
    {
        $reportFile = ReportFile::findOrFail($id);
        $filePath = $reportFile->file_path;
        
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            Log::info("Deleted file: $filePath");
        } else {
            Log::warning("File not found for deletion: $filePath");
        }
        
        $reportFile->delete();
        
        return redirect()->route('reportView')->with('success', 'Report file deleted successfully.');
    }
}

