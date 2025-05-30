<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <link rel="icon" type="image/x-icon" href="images/favLogo.png">

    <style>
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .sidebar-item {
            transition: all 0.3s, transform 0.3s;
            display: block;
            padding: 10px;
        }

        .sidebar-item:hover,
        .sidebar-item.active {
            background-color: #e0f2fe;
            color: #075985;
        }

        .logo-box {
            padding: 10px;

            display: inline-block;
            transition: transform 0.3s ease;
        }

        .logo-box:hover {
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .sidebar {
                display: fixed;
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 100%;
                background: white;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                overflow-y: auto;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-toggle {
                display: block;
                font-size: 1.5rem;
                cursor: pointer;
                z-index: 1100;
            }
        }
    </style>
</head>

<body class="flex">
    <div class="lg:hidden p-4 relative">
        <span class="sidebar-toggle text-gray-600">
            <i class="fas fa-bars"></i>
        </span>
    </div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="sidebar fixed w-64 bg-white h-screen p-5 text-gray-600 rounded-xl md:w-1/4 lg:w-1/5 xl:w-1/6 ">

        @php
            $isAdmin = Auth::user()->is_admin ?? 0; // Kullanıcı giriş yapmamışsa varsayılan olarak 0 al
            $redirectUrl = $isAdmin == 2 ? url('manager') : url('user');
        @endphp

        <div class="flex items-center justify-center mb-10 border-b border-gray-200 w-full">
            <a href="{{ $redirectUrl }}" class="flex items-center">
                <div class="logo-box rounded-full mt-4">
                    <img src="{{ asset('images/deneme1.png') }}" alt="logo" />
                </div>
            </a>
        </div>

        <ul id="sidebar-menu" class="space-y-4">


            <li>
                @if (auth()->user()->is_admin == 0)
                    <a href="{{ route('user') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                        <i class="fas fa-th-large mr-3"></i>
                        Kullanıcı Paneli
                    </a>
                @elseif (auth()->user()->is_admin == 2)
                    <a href="{{ route('manager') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                        <i class="fas fa-th-large mr-3"></i>
                        Müdür Paneli
                    </a>
                @endif
            </li>


            <li>
                <a href="{{ route('userProfile') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-regular fa-id-card mr-3"></i>
                    Profilim
                </a>
            </li>





            <li>
                <a href="{{ route('user.projects.index') }}"
                    class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-regular fa-file-code mr-3"></i>
                    Projelerim
                </a>
            </li>


            <li>
                <a href="{{ route('mission.indexUser') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-solid fa-layer-group mr-3"></i>
                    Görevlerim
                </a>
            </li>






            <li>
                <a href="{{ route('offday.index') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-regular fa-pen-to-square mr-4"></i>
                    İzin Taleplerim
                </a>
            </li>

            <li>
                <a href="{{ route('user.workSessions') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-regular fa-clock mr-3"></i>
                    Mesai Takibim </a>
            </li>


            <li>
                <a href="{{ route('user.teammates') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-solid fa-user-group mr-4"></i>
                    Takım Arkadaşlarım
                </a>
            </li>




        </ul>

        <div class="">
            <div class="flex flex-col justify-center mt-auto gap-4 border-t border-gray-300 pt-4">
                <a href="{{ route('user.contact') }}"
                    class="flex items-center gap-3 pl-4 py-2 rounded-md hover:bg-sky-100 transition-colors duration-300 group">
                    <i class="fa-solid fa-headset text-lg text-gray-500 group-hover:text-sky-700"></i>
                    <span class=" font-medium text-gray-700 group-hover:text-sky-700">Destek</span>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 pl-4 py-2 w-full rounded-md hover:bg-red-100 transition-colors duration-300 group">
                        <i class="fas fa-sign-out-alt text-lg text-gray-500 group-hover:text-red-700"></i>
                        <span class=" font-medium text-gray-700 group-hover:text-red-700">Çıkış Yap</span>
                    </button>
                </form>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarItems = document.querySelectorAll('.sidebar-item');

            sidebarItems.forEach(item => {
                item.addEventListener('click', function() {
                    sidebarItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            const currentUrl = window.location.href;
            sidebarItems.forEach(item => {
                if (item.href === currentUrl) {
                    item.classList.add('active');
                }
            });

            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.querySelector('.sidebar-toggle');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
            });

            document.addEventListener('click', function(e) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            });
        });
    </script>
</body>

</html>
