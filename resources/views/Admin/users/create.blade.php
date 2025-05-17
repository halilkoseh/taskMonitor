<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .animated-input:focus-within {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.1);
        }

        .form-section {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .file-upload {
            border: 2px dashed #cbd5e1;
            transition: all 0.3s ease;
        }

        .file-upload:hover {
            border-color: #6366f1;
            background-color: rgba(99, 102, 241, 0.05);
        }
    </style>
    <title>Task Monitor</title>
</head>

<body>
    @extends(in_array(auth()->user()->is_admin, [0, 2]) ? 'userLayout.app' : 'layout.app')

    @section('content')
        <div class="min-h-screen form-section flex items-center justify-center p-4 md:p-8">
            <div class="w-full max-w-2xl bg-white rounded-xl shadow-2xl p-6 md:p-8 transition-all duration-300">
                <div class="mb-6">
                    <a href="{{ route('admin.users.show') }}" 
                       class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                        <i class="fas fa-arrow-left mr-2"></i> Geri Dön
                    </a>
                </div>

                <h1 class="text-4xl font-bold text-center mb-8 bg-gradient-to-r from-indigo-600 to-blue-500 bg-clip-text text-transparent">
                    Yeni Kullanıcı Ekle
                </h1>

                <form id="userForm" action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- İsim Soyisim -->
                        <div class="animated-input relative bg-white rounded-lg p-1 shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-user text-indigo-600 ml-3 absolute"></i>
                                <input type="text" id="name" name="name" required
                                    class="w-full pl-10 pr-4 py-3 border-0 rounded-lg bg-gray-50 focus:ring-2 focus:ring-indigo-600 placeholder-gray-400"
                                    placeholder="İsim Soyisim">
                            </div>
                        </div>

                        <!-- Kullanıcı Adı -->
                        <div class="animated-input relative bg-white rounded-lg p-1 shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-at text-indigo-600 ml-3 absolute"></i>
                                <input type="text" id="username" name="username" required
                                    class="w-full pl-10 pr-4 py-3 border-0 rounded-lg bg-gray-50 focus:ring-2 focus:ring-indigo-600 placeholder-gray-400"
                                    placeholder="Kullanıcı Adı">
                            </div>
                        </div>

                        <!-- Görev -->
                        <div class="animated-input relative bg-white rounded-lg p-1 shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-briefcase text-indigo-600 ml-3 absolute"></i>
                                <input type="text" id="gorev" name="gorev" required
                                    class="w-full pl-10 pr-4 py-3 border-0 rounded-lg bg-gray-50 focus:ring-2 focus:ring-indigo-600 placeholder-gray-400"
                                    placeholder="Kullanıcı Görevi">
                            </div>
                        </div>

                        <!-- Şifre -->
                        <div class="animated-input relative bg-white rounded-lg p-1 shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-lock text-indigo-600 ml-3 absolute"></i>
                                <input type="password" id="password" name="password" required
                                    class="w-full pl-10 pr-4 py-3 border-0 rounded-lg bg-gray-50 focus:ring-2 focus:ring-indigo-600 placeholder-gray-400"
                                    placeholder="Şifre">
                            </div>
                        </div>

                        <!-- E-posta -->
                        <div class="animated-input relative bg-white rounded-lg p-1 shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-indigo-600 ml-3 absolute"></i>
                                <input type="email" id="email" name="email" required
                                    class="w-full pl-10 pr-4 py-3 border-0 rounded-lg bg-gray-50 focus:ring-2 focus:ring-indigo-600 placeholder-gray-400"
                                    placeholder="E-posta Adresi">
                            </div>
                        </div>

                        <!-- Telefon -->
                        <div class="animated-input relative bg-white rounded-lg p-1 shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-phone text-indigo-600 ml-3 absolute"></i>
                                <input type="tel" id="phoneNumber" name="phoneNumber" required
                                    class="w-full pl-10 pr-4 py-3 border-0 rounded-lg bg-gray-50 focus:ring-2 focus:ring-indigo-600 placeholder-gray-400"
                                    placeholder="Telefon Numarası">
                            </div>
                        </div>

                        <!-- LinkedIn -->
                        <div class="animated-input relative bg-white rounded-lg p-1 shadow-sm">
                            <div class="flex items-center">
                                <i class="fab fa-linkedin text-indigo-600 ml-3 absolute"></i>
                                <input type="url" id="linkedinAddress" name="linkedinAddress" required
                                    class="w-full pl-10 pr-4 py-3 border-0 rounded-lg bg-gray-50 focus:ring-2 focus:ring-indigo-600 placeholder-gray-400"
                                    placeholder="LinkedIn Profil Linki">
                            </div>
                        </div>

                        <!-- Portföy -->
                        <div class="animated-input relative bg-white rounded-lg p-1 shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-link text-indigo-600 ml-3 absolute"></i>
                                <input type="url" id="portfolioLink" name="portfolioLink" required
                                    class="w-full pl-10 pr-4 py-3 border-0 rounded-lg bg-gray-50 focus:ring-2 focus:ring-indigo-600 placeholder-gray-400"
                                    placeholder="Portföy Linki">
                            </div>
                        </div>

                        <!-- Kullanıcı Türü -->
                        <div class="animated-input relative bg-white rounded-lg p-1 shadow-sm md:col-span-2">
                            <div class="flex items-center">
                                <i class="fas fa-user-tag text-indigo-600 ml-3 absolute"></i>
                                <select id="profileType" name="profileType" required
                                    class="w-full pl-10 pr-4 py-3 border-0 rounded-lg bg-gray-50 focus:ring-2 focus:ring-indigo-600 appearance-none">
                                    <option value="" disabled selected>Kullanıcı Türü Seçiniz</option>
                                    <option value="admin">Admin</option>
                                    <option value="yonetici">Proje Müdürü</option>
                                    <option value="calisan">Çalışan</option>
                                </select>
                                <i class="fas fa-chevron-down text-gray-400 absolute right-3"></i>
                            </div>
                        </div>

                        <!-- Profil Resmi -->
                        <div class="md:col-span-2">
                            <label class="file-upload block w-full p-8 text-center rounded-lg cursor-pointer transition-colors">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-camera text-3xl text-indigo-600 mb-2"></i>
                                    <span class="text-indigo-600 font-medium">Profil Resmi Yükle</span>
                                    <span class="text-gray-500 text-sm">(Maksimum 2MB)</span>
                                </div>
                                <input type="file" id="profilePic" name="profilePic" accept="image/*" required
                                    class="hidden">
                            </label>
                        </div>
                    </div>

                    <button type="submit" id="submitBtn" disabled
                        class="w-full py-4 px-6 bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-user-plus mr-2"></i> Kullanıcıyı Oluştur
                    </button>
                </form>

                <!-- Hata ve Başarı Mesajları -->
                @if ($errors->any())
                    <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <ul class="text-red-600">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center"><i class="fas fa-times-circle mr-2"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-green-600"><i class="fas fa-check-circle mr-2"></i> {{ session('success') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <script>
            const form = document.getElementById('userForm');
            const inputs = form.querySelectorAll('input, select');
            const submitBtn = document.getElementById('submitBtn');

            function checkForm() {
                let allFilled = true;
                inputs.forEach(input => {
                    if (!input.checkValidity()) allFilled = false;
                });
                submitBtn.disabled = !allFilled;
            }

            inputs.forEach(input => {
                input.addEventListener('input', checkForm);
                input.addEventListener('change', checkForm);
            });

            // File upload styling
            const fileUpload = document.querySelector('.file-upload');
            const fileInput = document.getElementById('profilePic');

            fileInput.addEventListener('change', function(e) {
                if (this.files[0]) {
                    fileUpload.classList.add('border-indigo-600', 'bg-indigo-50');
                } else {
                    fileUpload.classList.remove('border-indigo-600', 'bg-indigo-50');
                }
            });
        </script>
    @endsection
</body>

</html>