<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Attachment;
use App\Models\Approved;
use App\Models\Revised;
use App\Models\Waiting;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

class ProjectFilesController extends Controller
{
    public function show($projectId)
    {
        // Projeye ait dosyaları çekiyoruz
        $attachments = Attachment::whereHas('task', function ($query) use ($projectId) {
            $query->where('project_id', $projectId);
        })->get();

        $approveds = Approved::whereHas('task', function ($query) use ($projectId) {
            $query->where('project_id', $projectId);
        })->get();

        $reviseds = Revised::whereHas('task', function ($query) use ($projectId) {
            $query->where('project_id', $projectId);
        })->get();

        $waitings = Waiting::whereHas('task', function ($query) use ($projectId) {
            $query->where('project_id', $projectId);
        })->get();

        $taskAttachments = Task::where('project_id', $projectId)
            ->whereNotNull('attachments')
            ->get(['id', 'attachments', 'created_at']);

        return view('project_files', compact('attachments', 'approveds', 'reviseds', 'waitings', 'taskAttachments'));
    }

    public function destroy($fileId)
    {
        $file = Attachment::find($fileId) ??
                Approved::find($fileId) ??
                Revised::find($fileId) ??
                Waiting::find($fileId) ??
                Task::whereNotNull('attachments')->find($fileId);

        if ($file) {
            $filePath = $file->file_path ?? $file->file ?? $file->attachments;

            if ($filePath && Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            // Eğer Task içindeki attachments null olacaksa, sadece güncelleyelim
            if ($file instanceof Task) {
                $file->update(['attachments' => null]);
            } else {
                $file->delete();
            }

            return back()->with('success', 'Dosya başarıyla silindi.');
        }

        return back()->with('error', 'Dosya bulunamadı.');
    }
}
