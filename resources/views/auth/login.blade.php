<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Monitor</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://i.pinimg.com/originals/83/37/27/833727799b63e97bc88c47dea6159bd7.jpg');
            background-size: cover;
            background-position: center;
            font-family: 'Inter', sans-serif;
        }

        .icon {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
        }

        .input-container {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
        }

        .input-field {
            padding-left: 2.5rem;
        }
    </style>

</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="max-w-lg w-full p-12 bg-white rounded-lg shadow-lg">
        <div class="icon">
            <img src="{{ asset('images/deneme.png') }}" alt="logo" class="w-48" />
        </div>
        
        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4 input-container">
                <label for="username" class="sr-only">Kullanıcı Adı:</label>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 input-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4c-3.866 0-7 3.134-7 7s3.134 7 7 7 7-3.134 7-7-3.134-7-7-7zm0 14c-3.866 0-7 3.134-7 7s3.134 7 7 7 7-3.134 7-7-3.134-7-7-7z" />
                </svg>
                <input type="text" id="username" name="username" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm input-field"
                    placeholder="Kullanıcı Adı">
            </div>

            <div class="mb-4 input-container">
                <label for="password" class="sr-only">Şifre:</label>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 input-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12V6a4 4 0 00-8 0v6H6a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2h-2z" />
                </svg>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm input-field"
                    placeholder="Şifre">
            </div>

            <div class="flex items-center mb-8">
                <input id="remember_me" name="remember_me" type="checkbox"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-gray-900">Beni Hatırla</label>
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-3 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600 text-lg mb-8">Giriş
                Yap</button>
        </form>

        <!-- Demo Credentials Box -->
        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-md">
            <h3 class="text-lg font-medium text-blue-800 mb-2">Demo Kullanıcı Bilgileri</h3>
            <div class="grid grid-cols-2 gap-2 text-sm">
                <div>
                    <p class="font-semibold">Admin Kullanıcı:</p>
                    <p>Username: <span class="font-mono bg-gray-100 px-1 rounded">admin</span></p>
                    <p>Password: <span class="font-mono bg-gray-100 px-1 rounded">password</span></p>
                </div>
                <div>
                    <p class="font-semibold">Normal Kullanıcı:</p>
                    <p>Username: <span class="font-mono bg-gray-100 px-1 rounded">fawuqifaby</span></p>
                    <p>Password: <span class="font-mono bg-gray-100 px-1 rounded">password</span></p>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500">Bu bir demo projedir. Lütfen gerçek bilgilerinizi kullanmayınız.</p>
        </div>

        @if ($errors->any())
        <div class="mt-4">
            @foreach ($errors->all() as $error)
            <p class="text-sm text-red-600">{{ $error }}</p>
            @endforeach
        </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rememberMeCheckbox = document.getElementById('remember_me');
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');

            const storedUsername = localStorage.getItem('storedUsername');
            const storedPassword = localStorage.getItem('storedPassword');
            const rememberMeChecked = localStorage.getItem('rememberMeChecked');

            if (rememberMeChecked === 'true' && storedUsername && storedPassword) {
                usernameInput.value = storedUsername;
                passwordInput.value = storedPassword;
                rememberMeCheckbox.checked = true;
            }

            rememberMeCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    localStorage.setItem('storedUsername', usernameInput.value);
                    localStorage.setItem('storedPassword', passwordInput.value);
                    localStorage.setItem('rememberMeChecked', true);
                } else {
                    localStorage.removeItem('storedUsername');
                    localStorage.removeItem('storedPassword');
                    localStorage.removeItem('rememberMeChecked');
                }
            });

            const loginForm = document.getElementById('loginForm');
            loginForm.addEventListener('submit', function () {
                localStorage.removeItem('storedUsername');
                localStorage.removeItem('storedPassword');
                localStorage.removeItem('rememberMeChecked');
            });
        });
    </script>
</body>

</html>
