<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Revised;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

class RevisedController extends Controller
{
    public function index($taskId)
    {
        $task = Task::findOrFail($taskId);
        $files = Revised::where('task_id', $taskId)->get();
        return view('tasks.revised', compact('task', 'files'));
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
                $path = $file->storeAs('revised_uploads', $fileName, 'public');
    
                // Veritabanına kaydet
                Revised::create([
                    'task_id' => $task->id,
                    'file_path' => $path,
                    'note' => $request->note,
                ]);
            }
        } else {
            // Dosya yoksa sadece notu kaydet
            Revised::create([
                'task_id' => $task->id,
                'file_path' => null,
                'note' => $request->note,
            ]);
        }
    
        return back()->with('success', 'Revize bilgileri kaydedildi.');
    }
    

    public function download($id)
    {
        $file = Revised::findOrFail($id);
        return Storage::download('public/' . $file->file_path);
    }

    public function destroy($id)
    {
        $file = Revised::findOrFail($id);
        Storage::delete('public/' . $file->file_path);
        $file->delete();

        return back()->with('success', 'Revize edilen dosya silindi.');
    }
}
