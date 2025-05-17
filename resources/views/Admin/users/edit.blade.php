<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet">
    <title>Task Monitor</title>
    <style>
        .main-content {
            margin-top: 2rem;
        }

        @media (min-width: 768px) {
            .main-content {
                padding: 2rem;
                box-sizing: border-box;
            }
        }
    </style>
</head>

<body>
    @extends(in_array(auth()->user()->is_admin, [0, 2]) ? 'userLayout.app' : 'layout.app')

    @section('content')
        <div class="main-content  p-6 sm:p-10 lg:p-16 bg-[#EFEFEF] min-h-screen flex items-center justify-center">


            <div class="max-w-3xl w-full bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-8">


                    <!-- Geri Dön Butonu -->
                    <div class="flex items-center mb-6">
                        <a href="{{ route('admin.users.show') }}"
                            class="flex items-center text-blue-500 hover:text-blue-700">
                            <i class="fa-solid fa-chevron-left mr-2"></i> Geri Dön
                        </a>
                    </div>

                    <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Kullanıcı Güncelle</h2>

                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data"
                        id="updateForm">
                        @csrf
                        @method('PUT')

                        <!-- Form Alanları -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Ad Soyad -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Adı Soyadı</label>
                                <input type="text" name="name" id="name" value="{{ $user->name }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-300">
                            </div>

                            <!-- Görev -->
                            <div>
                                <label for="gorev" class="block text-sm font-medium text-gray-700">Görevi</label>
                                <input type="text" name="gorev" id="gorev" value="{{ $user->gorev }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-300">
                            </div>

                            <!-- Kullanıcı Türü Seçimi -->
                            <div class="col-span-2">
                                <label for="profileType" class="block text-sm font-medium text-gray-700">Kullanıcı
                                    Türü</label>
                                <select id="profileType" name="profileType"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-300">
                                    <option value="admin" {{ $user->is_admin == 1 ? 'selected' : '' }}>Admin</option>
                                    <option value="yonetici" {{ $user->is_admin == 2 ? 'selected' : '' }}>Proje Müdürü</option>
                                    <option value="calisan" {{ $user->is_admin == 0 ? 'selected' : '' }}>Çalışan</option>
                                </select>
                            </div>

                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700">Kullanıcı Adı</label>
                                <input type="text" name="username" id="username" value="{{ $user->username }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-300">
                            </div>

                            <!-- Şifre -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-red-600">
                                    Şifre (Zorunlu)
                                </label> <input type="password" name="password" id="password"
                                    placeholder="Yeni Şifre Girin"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-300">
                                <span id="password-error" class="text-red-500 text-sm hidden">Bu alan boş
                                    bırakılamaz.</span>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                                <input type="email" name="email" id="email" value="{{ $user->email }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-300">
                            </div>

                            <!-- Telefon -->
                            <div>
                                <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Telefon
                                    Numarası</label>
                                <input type="tel" name="phoneNumber" id="phoneNumber" value="{{ $user->phoneNumber }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-300">
                            </div>

                            <!-- LinkedIn -->
                            <div>
                                <label for="linkedinAddress" class="block text-sm font-medium text-gray-700">LinkedIn
                                    Adresi</label>
                                <input type="url" name="linkedinAddress" id="linkedinAddress"
                                    value="{{ $user->linkedinAddress }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-300">
                            </div>

                            <!-- Portföy -->
                            <div>
                                <label for="portfolioLink" class="block text-sm font-medium text-gray-700">Portföy
                                    Adresi</label>
                                <input type="url" name="portfolioLink" id="portfolioLink"
                                    value="{{ $user->portfolioLink }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-300">
                            </div>

                            <!-- Profil Resmi -->
                            <div class="col-span-2">
                                <label for="profilePic" class="block text-sm font-medium text-gray-700">Profil Resmi</label>
                                <input type="file" id="profilePic" name="profilePic" accept="image/*"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-300">
                            </div>
                        </div>



                        <div class="flex justify-between mt-4">

                            <!-- Güncelle Butonu -->
                            <div class="flex justify-end mt-2">
                                <button type="submit"
                                    class="inline-block px-6 py-3 bg-blue-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800">
                                    Güncelle
                                </button>
                            </div>
                    </form>

                    <!-- Kullanıcı Silme Butonu (Güncelleme Formunun Dışında) -->
                    @if ($user->name !== 'admin')
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" id="deleteForm"
                            onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');"
                            class=" flex justify-end">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-block px-6 py-3 bg-red-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 mt-2">
                                Sil
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        </div>
    @endsection
</body>

</html>
