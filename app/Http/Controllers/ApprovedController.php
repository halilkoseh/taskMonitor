<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Approved;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

class ApprovedController extends Controller
{
    public function index($taskId)
    {
        $task = Task::findOrFail($taskId);
        $files = Approved::where('task_id', $taskId)->get();
        return view('tasks.approved', compact('task', 'files'));
    }

    public function store(Request $request, $taskId)
    {
        $request->validate([
            'files' => 'nullable|array',
            'files.*' => 'file|max:10240',
            'note' => 'required|string|max:5000'
        ]);

        $task = Task::findOrFail($taskId);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Orijinal dosya adını al
                $originalName = $file->getClientOriginalName();
                $fileName = time() . '_' . $originalName; // Çakışmayı önlemek için zaman damgası ekleyelim

                // Dosyayı kaydet
                $path = $file->storeAs('approved_uploads', $fileName, 'public');

                // Veritabanına kaydet
                Approved::create([
                    'task_id' => $task->id,
                    'file_path' => $path,
                    'note' => $request->note,
                ]);
            }
        } else {
            // Dosya yoksa sadece not kaydet
            Approved::create([
                'task_id' => $task->id,
                'file_path' => null,
                'note' => $request->note,
            ]);
        }

        return back()->with('success', 'Bilgiler başarıyla kaydedildi.');
    }


    public function download($id)
    {
        $file = Approved::findOrFail($id);
        return Storage::download('public/' . $file->file_path);
    }

    public function destroy($id)
    {
        $file = Approved::findOrFail($id);
        Storage::delete('public/' . $file->file_path);
        $file->delete();

        return back()->with('success', 'Dosya silindi.');
    }
}
