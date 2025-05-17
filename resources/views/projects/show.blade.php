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
            /* Ensure the toggle button is above other content */
        }
    }
</style>

<body>



    @if (auth()->user()->is_admin == 1)
    <div id="sidebar"
            class="sidebar fixed w-64 bg-white h-screen p-5 text-gray-600 rounded-xl md:w-1/4 lg:w-1/5 xl:w-1/6 ">

            <div class="flex items-center justify-center mb-10 border-b border-gray-200 w-full">
                <a href="{{ url('admin') }}" class="flex items-center">
                    <div class="logo-box rounded-full mt-4" >
                        <img src="{{ asset('images/deneme1.png') }}" alt="logo" />
                    </div>
                </a>
            </div>

            <ul id="sidebar-menu" class="space-y-4">
                <li>
                    <a href="{{ route('admin') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                        <i class="fas fa-th-large mr-3"></i>
                        Admin Paneli
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.show') }}"
                        class="sidebar-item flex items-center text-lg text-gray-600">
                        <i class="fa-regular fa-id-card mr-3"></i>
                        Kullanıcılar
                    </a>
                </li>
                <li>
                    <a href="{{ route('projects.index') }}"
                        class="sidebar-item flex items-center text-lg text-gray-600">
                        <i class="fa-regular fa-file-code mr-4"></i>
                        Projeler
                    </a>
                </li>
                <li>
                    <a href="{{ route('mission.index') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                        <i class="fa-solid fa-layer-group mr-3"></i> Görevler
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.offdays.index') }}"
                        class="sidebar-item flex items-center text-lg text-gray-600">
                        <i class="fa-regular fa-pen-to-square mr-3"></i>
                        İzin Takip
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.contacts.index') }}"
                        class="sidebar-item flex items-center text-lg text-gray-600">
                        <i class="fa-solid fa-life-ring mr-3"></i>
                        Destek Talepleri
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.index') }}"
                        class="sidebar-item flex items-center text-lg text-gray-600">
                        <i class="fa-regular fa-copy mr-3"></i>
                        Raporlar
                    </a>
                </li>
            </ul>

            <div class="">
                <div class="flex flex-col justify-center mt-auto gap-4 border-t border-gray-300 pt-4">
                    <a href="{{ route('profile') }}"
                        class="flex items-center gap-3 pl-4 py-2 rounded-md hover:bg-sky-100 transition-colors duration-300 group">
                        <i class="fas fa-cog text-lg text-gray-500 group-hover:text-sky-700"></i>
                        <span class=" font-medium text-gray-700 group-hover:text-sky-700">Ayarlar</span>
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
    @else
        @include('components.userNavbar')
    @endif


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



<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Task Monitor</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.0/dist/alpine.min.js" defer></script>
<style>
    .dragging {
        opacity: 0.5;
    }
</style>
</head>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Board</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            box-sizing: border-box;

        }

        .container {
            margin-left: 10%;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 20px;
        }

        .header button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s;
        }

        .header button:hover {
            background-color: #0056b3;
        }

        .board {
            display: flex;
            gap: 5px;
            overflow-x: auto;
            padding: 20px 0;
            flex-wrap: nowrap;
        }

        .column {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 250px;
            min-height: 500px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            flex-shrink: 0;
        }

        .column h2 {
            font-size: 18px;
            margin: 0 0 20px;
            color: #333;
        }

        .task-card {
    background: #F5F5F5; /* Daha açık bir arka plan */
    border-radius: 12px; /* Daha yumuşak köşeler */
    margin: 24px 0; /* Kartlar arasında boşluk */
    padding: 24px; /* İçeriğe geniş alan */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08); /* Daha hafif ve yumuşak gölge */
    cursor: grab;
    transition: all 0.3s ease-in-out;
    font-size: 18px; /* Okunabilir font büyüklüğü */
    line-height: 1.6; /* Daha rahat okuma için satır yüksekliği */
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-width: 600px; /* İçeriğin geniş olmasını sağla ama aşırı büyütme */
    border: 1px solid #ddd; /* Hafif çerçeve efekti */
}

.task-card:hover {
    background: #f9f9f9; /* Hover'da hafif renk değişimi */
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12); /* Daha belirgin gölge */
    transform: translateY(-3px); /* Hafifçe yukarı kalkma efekti */
}


        .task-card .task-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .task-card .task-info {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        .task-card .task-info:last-child {
            margin-bottom: 0;
        }

        .dragging {
            opacity: 0.5;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .header button {
                font-size: 14px;
                padding: 8px 16px;
            }

            .board {
                flex-direction: column;
                overflow-x: visible;
            }

            .column {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body class="">
    <div class="container ">

        <div class="header py-4 flex gap-4 ml-40">


            @if (auth()->user()->is_admin == 1)
            <button onclick="window.location.href='{{ route('projects.index') }}'"
                    class="bg-green-500 text-white px-4 py-2 rounded-md flex items-center gap-2 hover:bg-green-600 transition-colors duration-300">
                    <i class="fa-solid fa-diagram-project"></i>
                    <span>Projeler</span>
                </button>

                <button onclick="window.location.href='{{ route('admin.users.assaign') }}'"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md flex items-center gap-2 hover:bg-blue-600 transition-colors duration-300">
                    <i class="fa-solid fa-list-check"></i>
                    <span>Görev Ata</span>
                </button>

                <button onclick="window.location.href='{{ route('mission.index') }}'"
                    class="bg-green-500 text-white px-4 py-2 rounded-md flex items-center gap-2 hover:bg-green-600 transition-colors duration-300">
                    <i class="fa-regular fa-paste"></i>
                    <span>Tüm Tasklar</span>
                </button>
            @else
                <div class="mb-6">
                    <a href="{{ route('user.projects.index') }}"
                        class="text-sky-500 hover:text-blue-800 transition-colors duration-200">
                        <i class="fa-solid fa-chevron-left"></i> Geri Dön
                    </a>
                </div>
            @endif






        </div>

        <div class="board ml-40">

            <div class="column" data-status="Atandı" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                <h2 class="text-red-600">Atandı</h2>
                @foreach ($project->tasks()->where('status', 'Atandı')->get() as $task)
                    <div class="task-card bg-red-100" draggable="true" data-task-id="{{ $task->id }}"
                        ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                        <div class="task-title">{{ $task->title }}</div>
                        <div class="task-info">Kime: {{ $task->assignedUser->name }}</div>
                        <div class="task-info">Atanma Tarihi: {{ $task->start_date }}</div>
                        <div class="task-info">Son Teslim Tarihi: {{ $task->due_date }}</div>
                        <div class="task-info">Görev İçeriği: {{ $task->description }}</div>
                        <div class="task-info">Proje İsmi: {{ $project->name }}</div>
                        <div class="task-info">
                            Ek Materyaller: @if ($task->attachments)
                                Var
                            @else
                                Yok
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="column" data-status="Devam Ediyor" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                <h2 class="text-yellow-600">Devam Ediyor</h2>
                @foreach ($project->tasks()->where('status', 'Devam Ediyor')->get() as $task)
                    <div class="task-card bg-yellow-100" draggable="true" data-task-id="{{ $task->id }}"
                        ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                        <div class="task-title">{{ $task->title }}</div>
                        <div class="task-info">Kime: {{ $task->assignedUser->name }}</div>
                        <div class="task-info">Atanma Tarihi: {{ $task->start_date }}</div>
                        <div class="task-info">Son Teslim Tarihi: {{ $task->due_date }}</div>
                        <div class="task-info">Görev İçeriği: {{ $task->description }}</div>
                        <div class="task-info">Proje İsmi: {{ $project->name }}</div>
                        <div class="task-info">
                            Ek Materyaller: @if ($task->attachments)
                                Var
                            @else
                                Yok
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="column" data-status="Revize" ondragover="event.preventDefault()"
                ondrop="handleDrop(event)">
                <h2 class="text-blue-600">Revize</h2>
                @foreach ($project->tasks()->where('status', 'Revize')->get() as $task)
                    <div class="task-card bg-blue-100" draggable="true" data-task-id="{{ $task->id }}"
                        ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                        <div class="task-title">{{ $task->title }}</div>
                        <div class="task-info">Kime: {{ $task->assignedUser->name }}</div>
                        <div class="task-info">Atanma Tarihi: {{ $task->start_date }}</div>
                        <div class="task-info">Son Teslim Tarihi: {{ $task->due_date }}</div>
                        <div class="task-info">Görev İçeriği: {{ $task->description }}</div>
                        <div class="task-info">Proje İsmi: {{ $project->name }}</div>
                        <div class="task-info">
                            Ek Materyaller: @if ($task->attachments)
                                Var
                            @else
                                Yok
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="column" data-status="Onay Bekliyor" ondragover="event.preventDefault()"
                ondrop="handleDrop(event)">
                <h2 class="text-orange-600">Onay Bekliyor</h2>
                @foreach ($project->tasks()->where('status', 'Onay Bekliyor')->get() as $task)
                    <div class="task-card bg-orange-100" draggable="true" data-task-id="{{ $task->id }}"
                        ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                        <div class="task-title">{{ $task->title }}</div>
                        <div class="task-info">Kime: {{ $task->assignedUser->name }}</div>
                        <div class="task-info">Atanma Tarihi: {{ $task->start_date }}</div>
                        <div class="task-info">Son Teslim Tarihi: {{ $task->due_date }}</div>
                        <div class="task-info">Görev İçeriği: {{ $task->description }}</div>
                        <div class="task-info">Proje İsmi: {{ $project->name }}</div>
                        <div class="task-info">
                            Ek Materyaller: @if ($task->attachments)
                                Var
                            @else
                                Yok
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="column" data-status="Onaylandı" ondragover="event.preventDefault()"
                ondrop="handleDrop(event)">
                <h2 class="text-green-600">Onaylandı</h2>
                @foreach ($project->tasks()->where('status', 'Onaylandı')->get() as $task)
                    <div class="task-card bg-green-100" draggable="true" data-task-id="{{ $task->id }}"
                        ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                        <div class="task-title">{{ $task->title }}</div>
                        <div class="task-info">Kime: {{ $task->assignedUser->name }}</div>
                        <div class="task-info">Atanma Tarihi: {{ $task->start_date }}</div>
                        <div class="task-info">Son Teslim Tarihi: {{ $task->due_date }}</div>
                        <div class="task-info">Görev İçeriği: {{ $task->description }}</div>
                        <div class="task-info">Proje İsmi: {{ $project->name }}</div>
                        <div class="task-info">
                            Ek Materyaller: @if ($task->attachments)
                                Var
                            @else
                                Yok
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        function handleDragStart(event) {
            event.dataTransfer.setData("text/plain", event.target.dataset.taskId);
            event.currentTarget.classList.add("dragging");
        }

        function handleDragEnd(event) {
            event.currentTarget.classList.remove("dragging");
        }

        function handleDrop(event) {
            event.preventDefault();
            const taskId = event.dataTransfer.getData("text/plain");
            const newStatus = event.currentTarget.dataset.status;
            const taskCard = document.querySelector(`[data-task-id='${taskId}']`);
            if (taskCard) {
                updateTaskStatus(taskId, newStatus);
            }
        }

        async function updateTaskStatus(taskId, newStatus) {
            try {
                const response = await fetch(`/tasks/${taskId}/update-status`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                });

                if (response.ok) {
                    console.log("Görev durumu güncellendi.");
                    location.reload();
                } else {
                    console.error("Görev durumu güncellenemedi.");
                    location.reload();
                }
            } catch (error) {
                console.error("Bir hata oluştu:", error);
                location.reload();
            }
        }
    </script>
</body>

</html>
