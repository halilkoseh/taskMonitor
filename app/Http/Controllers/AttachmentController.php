<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function download($filename)
    {
        // Corrected the typo from 'stroage' to 'storage'
        $filePath = public_path('storage/attachments/' . $filename);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'Dosya bulunamadı.');
        }
    }
}
