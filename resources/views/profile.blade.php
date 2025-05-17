@extends(in_array(auth()->user()->is_admin, [0, 2]) ? 'userLayout.app' : 'layout.app')
 @section('content')

<div class="content-container">
    <div class="bg-[#EFEFEF]">
        <div class="max-w-4xl mt-8 mx-auto p-6">
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h1 class="text-3xl font-bold mb-4 text-gray-700 flex items-center"><i class="fa-solid fa-id-card mr-2 text-blue-500"></i> Ayarlar</h1>
                <p class="text-gray-600">
                    Profil bilgilerinizi görüntüleyebilir, değişiklik yapabilir veya olası hataları bildirebilirsiniz.
                </p>
            </div>

            <div class="bg-white p-8 rounded-lg shadow-md">
                <div class="flex items-center space-x-6 mb-6">
                    <img class="w-24 h-24 rounded-full object-cover border-4 border-blue-100" src="{{ asset('images/' . $user->profilePic) }}" alt="Profil Resmi" />
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>

                <h3 class="text-xl font-semibold mb-4 text-gray-800 border-b-2 pb-2">Kullanıcı Bilgileri</h3>

                <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-4">
                            <label class="block text-gray-600 font-semibold mb-2">Ad:</label>
                            <input type="text" value="{{ $user->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200" />
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-600 font-semibold mb-2">Kullanıcı Adı:</label>
                            <input type="text" value="{{ $user->username }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200" />
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-600 font-semibold mb-2">Görev:</label>
                            <input type="text" value="{{ $user->gorev }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200" />
                        </div>
                    </div>

                    <div>
                        <div class="mb-4">
                            <label class="block text-gray-600 font-semibold mb-2">E-mail:</label>
                            <input type="email" value="{{ $user->email }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200" />
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-600 font-semibold mb-2">İletişim:</label>
                            <input type="text" value="{{ $user->phoneNumber }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200" />
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-600 font-semibold mb-2">LinkedIn:</label>
                            <input type="text" value="{{ $user->linkedinAddress }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200" />
                        </div>
                    </div>
                </form>

                @if ($user->id != 1)
                <div class="bg-blue-50 p-6 mt-8 rounded-lg border border-blue-200 text-center">
                    <p class="text-gray-700 text-lg mb-4">
                        Bilgilerde herhangi bir yanlışlık olduğunu düşünüyorsanız lütfen bize bildirin.
                    </p>
                    <a href="mailfrom:{{ $user->email }}" class="text-blue-500 hover:text-blue-700 transition duration-200">info@taskmonitor.com.tr

                    </a>
                </div>
                @endif

                <div class="bg-white p-6 mt-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Parola Değiştir</h3>

                    @if (session('success'))
                    <div class="bg-green-500 text-white p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                    @endif @if ($errors->any())
                    <div class="bg-red-500 text-white p-4 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('profile.updatePassword') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="current_password" class="block text-gray-700">Mevcut Parola</label>
                            <input type="password" id="current_password" name="current_password" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200" required />
                        </div>
                        <div class="mb-4">
                            <label for="new_password" class="block text-gray-700">Yeni Parola</label>
                            <input type="password" id="new_password" name="new_password" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200" required />
                        </div>
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="block text-gray-700">Yeni Parola (Tekrar)</label>
                            <input
                                type="password"
                                id="new_password_confirmation"
                                name="new_password_confirmation"
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200"
                                required
                            />
                        </div>
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition duration-200">Parolayı Güncelle</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection
</div>
