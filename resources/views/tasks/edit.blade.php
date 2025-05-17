@extends(in_array(auth()->user()->is_admin, [0, 2]) ? 'userLayout.app' : 'layout.app')

@section('content')
<div class="max-w-4xl mx-auto p-8 bg-white rounded-2xl shadow-lg mt-20 mb-10 border border-gray-100">
    <div class="mb-8">
        <a href="{{ route('mission.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition-colors duration-200 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Geri Dön
        </a>
    </div>

    <h2 class="text-3xl font-bold text-gray-800 mb-8 pb-2 border-b-2 border-indigo-100">Görev Düzenle</h2>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PATCH')

        <div class="space-y-6">
            <!-- Başlık Alanı -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Görev Başlığı</label>
                <input type="text" name="title" id="title" 
                    class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200 outline-none"
                    value="{{ $task->title }}"
                    placeholder="Görev başlığını giriniz">
            </div>

            <!-- Açıklama Alanı -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Görev Detayları</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200 outline-none"
                    placeholder="Görevle ilgili detaylı açıklama...">{{ $task->description }}</textarea>
            </div>

            <!-- Tarih Seçimleri -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">Başlangıç Tarihi</label>
                    <input type="date" name="start_date" id="start_date" 
                        class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200"
                        value="{{ $task->start_date }}">
                </div>

                <div>
                    <label for="due_date" class="block text-sm font-semibold text-gray-700 mb-2">Bitiş Tarihi</label>
                    <input type="date" name="due_date" id="due_date" 
                        class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200"
                        value="{{ $task->due_date }}">
                </div>
            </div>
        </div>

        <!-- Güncelle Butonu -->
        <div class="pt-6">
            <button type="submit" 
                class="w-full bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                Görevi Güncelle
            </button>
        </div>
    </form>
</div>
@endsection