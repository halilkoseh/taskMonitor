<div id="sidebar"
    class="sidebar fixed lg:static w-72 bg-white p-5 text-gray-600 
       
            transform -translate-x-full lg:translate-x-0
            transition-transform duration-300 z-50">







    <div class="flex items-center justify-center mb-10 border-b border-gray-200 w-full">
        <a href="{{ url('admin') }}" class="flex items-center">
            <div class="logo-box rounded-full mt-4">
                <img src="{{ asset('images/deneme1.png') }}" alt="logo" />
            </div>
        </a>
    </div>




    <ul id="sidebar-menu" class="space-y-4">
        <li>
            <a href="{{ route('admin') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                <i class="fas fa-th-large mr-3"></i> Admin Paneli
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users.show') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                <i class="fa-regular fa-id-card mr-3"></i> Kullanıcılar
            </a>
        </li>
        <li>
            <a href="{{ route('projects.index') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                <i class="fa-regular fa-file-code mr-4"></i> Projeler
            </a>
        </li>
        <li>
            <a href="{{ route('mission.index') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                <i class="fa-solid fa-layer-group mr-3"></i> Görevler
            </a>
        </li>


        @php
            use App\Models\Offday;
            $offdayCount = Offday::count();
        @endphp
        <li>
            <a href="{{ route('admin.offdays.index') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                <i class="fa-regular fa-pen-to-square mr-3"></i> İzin Takip
                @if ($offdayCount > 0)
                    <span id="offday-count" class="ml-2 px-2 py-1 rounded text-[#0BA5E9]">
                        {{ $offdayCount }}
                    </span>
                @endif
            </a>
        </li>


        @php
            use App\Models\Contact;
            $contactCount = Contact::count();
        @endphp
        <li>
            <a href="{{ route('admin.contacts.index') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                <i class="fa-solid fa-life-ring mr-3"></i> Destek Talepleri
                @if ($contactCount > 0)
                    <span id="new-contacts-count" class="ml-2 px-2 py-1 rounded text-[#0BA5E9]">
                        {{ $contactCount }}
                    </span>
                @endif
            </a>
        </li>

        <a href="{{ route('admin.workSessions') }}" class="sidebar-item flex items-center text-lg text-gray-600">
            <i class="fa-regular fa-clock mr-3"></i>
            Mesai Takip
        </a>
        </li>

        <li>
            <a href="{{ route('admin.reports.index') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                <i class="fa-regular fa-copy mr-3"></i> Raporlar
            </a>
        </li>
    </ul>

    <div class="mt-auto border-t border-gray-300 pt-4">
        <a href="{{ route('profile') }}"
            class="flex items-center gap-3 pl-4 py-2 rounded-md hover:bg-sky-100 transition-colors duration-300 group">
            <i class="fas fa-cog text-lg text-gray-500 group-hover:text-sky-700"></i>
            <span class="font-medium text-gray-700 group-hover:text-sky-700">Ayarlar</span>
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="flex items-center gap-3 pl-4 py-2 w-full rounded-md hover:bg-red-100 transition-colors duration-300 group">
                <i class="fas fa-sign-out-alt text-lg text-gray-500 group-hover:text-red-700"></i>
                <span class="font-medium text-gray-700 group-hover:text-red-700">Çıkış Yap</span>
            </button>
        </form>
    </div>





</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.querySelector('.hamburger-menu'); // Değişti
        const sidebarItems = document.querySelectorAll('.sidebar-item');

        // Hamburger menüye tıklanınca sidebar aç/kapan
        sidebarToggle.addEventListener('click', function(event) {
            event.stopPropagation();
            sidebar.classList.toggle('open');
        });

        // Sayfanın herhangi bir yerine tıklanınca sidebar kapanacak (mobilde)
        document.addEventListener('click', function(event) {
            if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        });

        // Sidebar içindeki bir öğeye tıklanınca sidebar kapanacak (mobilde)
        sidebarItems.forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth < 768) { // Mobil kontrolü
                    sidebar.classList.remove('open');
                }
            });
        });
    });
</script>
