<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waiting;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

class WaitingController extends Controller
{
    public function index($taskId)
    {
        $task = Task::findOrFail($taskId);
        $files = Waiting::where('task_id', $taskId)->get();
        return view('tasks.waiting', compact('task', 'files'));
    }

    public function store(Request $request, $taskId)
    {
        $request->validate([
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,zip|max:20480',
            'note' => 'required|string|max:5000'
        ]);

        $task = Task::findOrFail($taskId);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Orijinal dosya adını al
                $originalName = $file->getClientOriginalName();
                $fileName = time() . '_' . $originalName; // Çakışmayı önlemek için zaman damgası ekleyelim

                // Dosyayı kaydet
                $path = $file->storeAs('uploads', $fileName, 'public');

                // Veritabanına kaydet
                Waiting::create([
                    'task_id' => $task->id,
                    'file_path' => $path,
                    'note' => $request->note,
                ]);
            }
        } else {
            // Dosya yoksa sadece not kaydet
            Waiting::create([
                'task_id' => $task->id,
                'file_path' => null,
                'note' => $request->note,
            ]);
        }

        return back()->with('success', 'Bilgiler başarıyla kaydedildi.');
    }



    public function download($id)
    {
        $file = Waiting::findOrFail($id);
        return Storage::download('public/' . $file->file_path);
    }

    public function destroy($id)
    {
        $file = Waiting::findOrFail($id);
        Storage::delete('public/' . $file->file_path);
        $file->delete();

        return back()->with('success', 'Dosya silindi.');
    }
}
