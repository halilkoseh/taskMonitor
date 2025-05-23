@extends(in_array(auth()->user()->is_admin, [0, 2]) ? 'userLayout.app' : 'layout.app')

@section('content')
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }

        .content-container {
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .user-info-container {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .user-info {
            display: flex;
            align-items: center;
            position: relative;
            padding: 5px;
            border-radius: 50%;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .search-container {
            position: relative;
            width: 100%;
            max-width: 500px;
        }

        .search-container .search-input {
            padding-left: 35px;
            width: 100%;
        }

        .search-container .search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .text-stroke {
            -webkit-text-stroke: 1px black;
            text-stroke: 1px black;
        }

        .bg-sidebar {
            background-color: #3a6ea5;
        }

        .bg-task {
            background-color: #ebebeb;
        }

        .task-card {
            background-color: #ffffff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
            cursor: move;
            position: relative;
        }

        .badge {
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
            display: inline-block;
        }

        .task-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #a0a0a0;
            margin-top: 10px;
        }

        .task-dates {
            font-size: 12px;
            color: #a0a0a0;
            text-align: left;
            margin-top: 10px;
        }

        .profile-picture {
            position: absolute;
            bottom: 10px;
            right: 10px;
            border-radius: 50%;
        }

        .dragging {
            opacity: 0.5;
        }

        .project-box {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            position: relative;
        }

        .project-card {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .project-card .icon-container {
            flex: 0 0 auto;
            margin-right: 1rem;
        }

        .project-card .text-container {
            flex: 1 1 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .see-all-link {
            color: #0284c7;
            text-decoration: underline;
            cursor: pointer;
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            z-index: 1;
            background-color: #ffffff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 0.25rem;
        }

        .dropdown.show .dropdown-content {
            display: block;
        }

        .dropdown-content a,
        .dropdown-content form button {
            color: #000000;
            padding: 0.5rem 1rem;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover,
        .dropdown-content form button:hover {
            background-color: #f1f1f1;
        }

        .bg-light-green-100 {
            background-color: #dcedc8;
        }

        .text-light-green-500 {
            color: #8bc34a;
        }

        .badge-light-green-100 {
            background-color: #dcedc8;
        }
    </style>

    <div class="content-container mx-auto bg-[#EFEFEF]">

       
        <div class="bg-[#EFEFEF] mt-8">
            <div class="max-w-4xl mt-8 mx-auto p-6">
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h1 class="text-3xl font-bold mb-4 text-gray-700 flex items-center">
                        <i class="fa-solid fa-id-card mr-2 text-blue-500"></i> Ayarlar
                    </h1>
                    <p class="text-gray-600">
                        Profil bilgilerinizi görüntüleyebilir, değişiklik yapabilir veya olası hataları bildirebilirsiniz.
                    </p>
                </div>
        
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="flex items-center space-x-6 mb-6">
                        <img class="w-24 h-24 rounded-full object-cover border-4 border-blue-100" src="{{ asset('images/' . $user->profilePic) }}" alt="Profil Resmi">
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
                                <input type="text" value="{{ $user->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-600 font-semibold mb-2">Kullanıcı Adı:</label>
                                <input type="text" value="{{ $user->username }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-600 font-semibold mb-2">Görev:</label>
                                <input type="text" value="{{ $user->gorev }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200">
                            </div>
                        </div>
        
                        <div>
                            <div class="mb-4">
                                <label class="block text-gray-600 font-semibold mb-2">E-mail:</label>
                                <input type="email" value="{{ $user->email }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-600 font-semibold mb-2">İletişim:</label>
                                <input type="text" value="{{ $user->phoneNumber }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-600 font-semibold mb-2">LinkedIn:</label>
                                <input type="text" value="{{ $user->linkedinAddress }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200">
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
                        @endif
        
                        @if ($errors->any())
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
                                <input type="password" id="current_password" name="current_password" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200" required>
                            </div>
                            <div class="mb-4">
                                <label for="new_password" class="block text-gray-700">Yeni Parola</label>
                                <input type="password" id="new_password" name="new_password" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200" required>
                            </div>
                            <div class="mb-4">
                                <label for="new_password_confirmation" class="block text-gray-700">Yeni Parola (Tekrar)</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200" required>
                            </div>
                            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition duration-200">Parolayı Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        


    </div>


@endsection
