@extends(in_array(auth()->user()->is_admin, [0, 2]) ? 'userLayout.app' : 'layout.app')

@section('content')
    <div class="container mx-auto px-4 py-8 ">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
            <div class="mb-6">
                <a href="{{ route('tasks.show', $task->id) }}" class="text-sky-500 hover:text-blue-800 transition-colors duration-200 flex items-center">
                    <i class="fa-solid fa-chevron-left mr-2"></i> Geri Dön
                </a>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $task->title }} - Revize Durumu Belgeler</h2>

            <!-- 📌 Dosya Yükleme Formu -->
  <!-- 📌 Dosya Yükleme Formu -->
<form id="uploadForm" action="{{ route('tasks.revised.upload', $task->id) }}" method="POST" enctype="multipart/form-data" class="mb-8">
    @csrf
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
        <label class="block text-gray-700 font-semibold mb-2">Dosya Seç (Opsiyonel):</label> <!-- Etiket güncellendi -->
        <input type="file" id="fileInput" name="files[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 mb-4">

        <label class="block text-gray-700 font-semibold mb-2">Açıklama (Zorunlu):</label>
        <textarea id="noteInput" name="note" rows="3" class="border p-2 rounded w-full mb-4" placeholder="Bu revizyon hakkında açıklama girin..." required></textarea>

        <!-- 📌 Uyarı Mesajı -->
        <p id="warningMessage" class="text-red-500 text-sm font-semibold hidden mb-4">Lütfen zorunlu açıklama alanını doldurun.</p>

        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-200">Kaydet</button>
    </div>
</form>

            <!-- 📌 Yüklenen Dosyalar Listesi -->
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Revize Edilen Dosyalar</h3>
            <ul class="space-y-3">
                @foreach ($files as $file)
                    <li class="flex flex-col bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <!-- 📌 Açıklama (Not) Alanı -->
                        <p class="text-gray-600 text-lg italic mb-2">{{ $file->note }}</p>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('tasks.revised.download', $file->id) }}" class="text-blue-500 hover:text-blue-600 font-medium">{{ basename($file->file_path) }}</a>
                            </div>
                            <form action="{{ route('tasks.revised.delete', $file->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-600 ml-2">Sil</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- 📌 JavaScript Uyarı Sistemi -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("uploadForm");
            const fileInput = document.getElementById("fileInput");
            const noteInput = document.getElementById("noteInput");
            const warningMessage = document.getElementById("warningMessage");

            form.addEventListener("submit", function (event) {
                if (noteInput.value.trim() === "") {
                    event.preventDefault(); // Formun gönderilmesini engelle
                    warningMessage.classList.remove("hidden"); // Uyarı mesajını göster
                } else {
                    warningMessage.classList.add("hidden"); // Uyarıyı gizle
                }
            });

            // Kullanıcı açıklama girdiğinde uyarıyı gizle
            noteInput.addEventListener("input", function () {
                if (noteInput.value.trim() !== "") {
                    warningMessage.classList.add("hidden");
                }
            });
        });
    </script>
@endsection
