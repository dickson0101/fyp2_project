<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use PDF;
use ZipArchive;

class PDFController extends Controller
{
    public function index(Request $request)
    {
        $content = nl2br($request->input('description'));
        $drawingData = $request->old('drawing_data', '');

        return view('pdf.index', compact('content', 'drawingData'));
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
            foreach ($request->file('attachments') as $index => $attachment) {
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

        // Log the number of attachments found
        Log::info("Number of attachments found: " . count($attachments));

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

        // Clean up the temporary directory
        File::deleteDirectory($tempDir);

        // Return the ZIP file path for download
        return response()->download($zipPath)->deleteFileAfterSend(true);

    } catch (Exception $e) {
        Log::error('Error during PDF and ZIP generation: ' . $e->getMessage());
        return back()->with('error', 'An error occurred during PDF and ZIP generation');
    }
}

    // Helper function to recursively remove a directory
    private function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $object))
                        $this->rrmdir($dir . DIRECTORY_SEPARATOR . $object);
                    else
                        unlink($dir . DIRECTORY_SEPARATOR . $object);
                }
            }
            rmdir($dir);
        }
    }
}
