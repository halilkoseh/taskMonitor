@extends(in_array(auth()->user()->is_admin, [0, 2]) ? 'userLayout.app' : 'layout.app')

@section('content')
    <div class="container mx-auto px-4 py-6 mt-16">
        <div class="max-w-3xl mx-auto">
            <form action="{{ route('projects.update', $project->id) }}" method="POST"
                class="space-y-6 bg-white p-8 rounded-lg shadow-lg">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <a href="{{ route('projects.index') }}"
                        class="text-sky-500 hover:text-blue-800 transition-colors duration-200">
                        <i class="fa-solid fa-chevron-left"></i> Geri Dön
                    </a>
                </div>
                <h1 class="text-3xl font-bold mb-6 text-center">Proje Düzenle</h1>

                <div class="space-y-2">
                    <label for="name" class="block text-gray-700 font-medium">Proje Adı</label>
                    <input type="text" name="name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:outline-none"
                        value="{{ $project->name }}" required>
                </div>
                <div class="space-y-2">
                    <label for="type" class="block text-gray-700 font-medium">Proje Türü</label>
                    <input type="text" name="type"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:outline-none"
                        value="{{ $project->type }}" required>
                </div>


                <div class="space-y-2">
                    <label for="project_manager" class="block text-gray-700 font-medium">Proje Müdürü</label>
                    <select name="project_manager"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:outline-none">
                        <option value="">Proje Müdürü Seç</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $project->project_manager == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                


                <div class="space-y-2">
                    <label for="description" class="block text-gray-700 font-medium">Açıklama</label>
                    <textarea name="description"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:outline-none">{{ $project->description }}</textarea>
                </div>
                <button type="submit"
                    class="w-full py-3 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition duration-300">Güncelle</button>
            </form>
        </div>
    </div>
@endsection
