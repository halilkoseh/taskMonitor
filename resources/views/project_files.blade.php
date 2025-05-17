@extends(in_array(auth()->user()->is_admin, [0, 2]) ? 'userLayout.app' : 'layout.app')

@section('content')
    <div class="container mx-auto p-6 ">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Proje Dosyaları</h2>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                {{ session('error') }}
            </div>
        @endif


        @if ($taskAttachments->count() > 0)
            <h4
                class="text-xl font-semibold text-gray-800 col-span-full mt-8 border-b-2 border-gray-300 pb-2 flex items-center">
                📂 Göreve Ait Dosyalar
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($taskAttachments as $task)
                    <div
                        class="bg-white p-5 shadow-md rounded-xl flex flex-col items-center border border-gray-200 transition-transform transform hover:scale-105 hover:shadow-lg">
                        <div class="text-gray-500 text-6xl mb-3">
                            <i class="fa fa-file"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-800 text-center truncate w-48">
                            📄 {{ basename($task->attachments) }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">📅 {{ $task->created_at->format('d-m-Y H:i') }}</p>

                        <div class="mt-3 flex space-x-3">
                            <a href="{{ asset($task->attachments) }}"
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 flex items-center transition">
                                <i class="fa fa-download mr-2"></i> İndir
                            </a>

                            <form action="{{ url('/projects/files/delete/' . $task->id) }}" method="POST"
                                onsubmit="return confirm('Bu dosyayı silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 bg-red-500 text-white rounded-lg shadow-md hover:bg-red-600 flex items-center transition">
                                    <i class="fa fa-trash mr-2"></i> Sil
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-5">
            @foreach (['Atandı' => $attachments, 'Onaylandı' => $approveds, 'Revize' => $reviseds, 'Onay Bekliyor' => $waitings] as $type => $files)
                @if ($files->count() > 0)
                    <h4 class="text-lg font-bold col-span-full text-gray-700 mb-4">{{ ucfirst($type) }}</h4>
                    @foreach ($files as $file)
                        <div class="bg-white p-6 shadow-md rounded-lg hover:shadow-lg transition-shadow duration-300">
                            <div class="flex flex-col items-center text-center">
                                <i class="fa fa-file text-gray-500 text-6xl mb-4"></i>
                                <p class="text-sm text-gray-700 font-medium">Dosya Adı:
                                    {{ basename($file->file_path ?? $file->file) }}</p>
                                <p class="text-xs text-gray-500 mt-1">Oluşturulma:
                                    {{ $file->created_at->format('d-m-Y H:i') }}</p>
                                <div class="mt-4 flex space-x-3">
                                    @if ($type === 'Atandı')
                                        <a href="{{ asset($file->file_path ?? $file->file) }}"
                                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-300 flex items-center"
                                            download>
                                            <i class="fa fa-download mr-2"></i> İndir
                                        </a>
                                    @else
                                        @if ($file->task_id)
                                            @php
                                                $route = match ($type) {
                                                    'Onaylandı' => url('/tasks/approved/' . $file->task_id),
                                                    'Revize' => url('/tasks/revised/' . $file->task_id),
                                                    'Onay Bekliyor' => url('/tasks/waiting/' . $file->task_id),
                                                    default => '',
                                                };
                                            @endphp
                                            <a href="{{ $route }}"
                                                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-300 flex items-center">
                                                <i class="fa fa-eye mr-2"></i> Görüntüle
                                            </a>
                                        @else
                                            <div class="text-red-500 text-sm">Hata: Task ID bulunamadı.</div>
                                        @endif
                                    @endif
                                    <form action="{{ url('/projects/files/delete/' . $file->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endforeach
        </div>



    </div>
@endsection
