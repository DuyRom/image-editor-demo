<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\TcpdfFpdi;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
    public function uploadAndLock(Request $request)
    {
        // Validate the uploaded PDF
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:10000'
        ]);

        $file = $request->file('pdf');
        $path = $file->store('pdfs');

        $pdfPath = storage_path('app/' . $path);

        // Create a new TCPDF object with FPDI
        $pdf = new TcpdfFpdi();
        $pageCount = $pdf->setSourceFile($pdfPath);

        // Import each page and add it to the new PDF
        for ($i = 1; $i <= $pageCount; $i++) {
            $pageId = $pdf->importPage($i);
            $pdf->AddPage();
            $pdf->useTemplate($pageId);
        }

        // Default permissions
        $defaultPermissions = [
            'print', 'modify', 'copy',
            'annot-forms', 'fill-forms', 'extract',
            'assemble', 'print-high'
        ];

        // Get permissions from the request
        $selectedPermissions = $request->input('permissions', []);
        $ownerPassword = $request->input('owner_password') ?? null;

        // Check if 'modify' is selected
        if (in_array('modify', $selectedPermissions)) {
            // Remove all permissions
            $permissions = [];
        } else {
            // Remove selected permissions from default
            $permissions = array_diff($defaultPermissions, $selectedPermissions);
        }

        // Set permissions based on user input
        $pdf->SetProtection($permissions, '', $ownerPassword, 0);

        // Save the encrypted PDF
        $encryptedPdfPath = 'pdfs/encrypted_' . $file->getClientOriginalName();
        Storage::put($encryptedPdfPath, $pdf->Output('', 'S'));

        // Return the encrypted PDF file as a download response
        return Storage::download($encryptedPdfPath, 'encrypted_' . time() . $file->getClientOriginalName());
    }
}
