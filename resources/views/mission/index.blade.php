@extends(in_array(auth()->user()->is_admin, [0, 2]) ? 'userLayout.app' : 'layout.app')

@section('content')
    <style>
        .content-container {
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }

        <style>.main-content {
            min-height: 100vh;
            margin-right: 2rem;
            padding: 20px;
            box-sizing: border-box;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            z-index: 1000;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.25rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            white-space: nowrap;
            overflow: visible;
        }

        .dropdown-content.show {
            display: block;
        }

        .table-container {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 0.5rem;
            overflow: hidden;
            background-color: #f8f9fa;
        }

        .table-container th,
        .table-container td {
            padding: 0.75rem;
            text-align: left;
            white-space: nowrap;
        }

        .table-container th {
            background-color: #e9ecef;
            font-weight: 600;
        }

        .table-container td {
            border-bottom: 1px solid #dee2e6;
        }

        .table-container tr {
            background-color: #ffffff;
            transition: background-color 0.2s;
        }

        .table-container tr:hover {
            background-color: #f1f3f5;
        }

        .table-container tr:first-child th:first-child,
        .table-container tr:first-child td:first-child {
            border-top-left-radius: 0.75rem;
        }

        .table-container tr:first-child th:last-child,
        .table-container tr:first-child td:last-child {
            border-top-right-radius: 0.75rem;
        }

        .table-container tr:last-child th:first-child,
        .table-container tr:last-child td:first-child {
            border-bottom-left-radius: 0.75rem;
        }

        .table-container tr:last-child th:last-child,
        .table-container tr:last-child td:last-child {
            border-bottom-right-radius: 0.75rem;
        }

        .icon-container {
            display: flex;
            align-items: center;
            background-color: #ffffff;
            padding: 0.5rem;
            border-radius: 0.50rem;
        }

        .icon-container img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-toggle {
            background: none;
            border: none;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            z-index: 1000;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.25rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            white-space: nowrap;
            overflow: visible;
        }

        .dropdown-content.show {
            display: block;
        }

        .dropdown-content a,
        .dropdown-content form {
            display: block;
            padding: 0.5rem 1rem;
            text-decoration: none;
            color: #212529;
        }

        .dropdown-content a:hover,
        .dropdown-content form:hover {
            background-color: #f8f9fa;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .text-sky-500 {
            color: #0ea5e9 !important;
        }
    </style>


    <div class="content-container w-full">
        <div class="container mx-auto p-4">
            <h2 class="text-2xl font-bold mb-4 p-4 bg-[#EFEFEF] rounded-lg flex items-center justify-between ">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-list-check text-blue-600 text-2xl"></i>
                    <span class="text-gray-800">Atanmış Görevler</span>
                </div>
                <a href="{{ route('admin.users.assaign') }}" class="hover:transform hover:scale-105 transition-transform duration-200">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded text-sm flex items-center space-x-2 transition-colors">
                        <i class="fa-solid fa-circle-plus text-sm"></i>
                        <span>Görev Ata</span>
                    </button>
                </a>
            </h2>
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif



            <div class="flex items-center justify-between">

                <div>
                    <form method="GET" action="{{ route('mission.index') }}"
                        class="mb-4 flex space-x-4 justify-between items-center">
                        <div>
                            <select name="owner_id" class="border rounded p-2">
                                <option value="">Tüm Kullanıcılar</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ request('owner_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="project_id" class="border rounded p-2">
                                <option value="">Tüm Projeler</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="status" class="border rounded p-2">
                                <option value="">Tüm Durumlar</option>
                                @foreach ($tasks->unique('status') as $task)
                                    <option value="{{ $task->status }}"
                                        {{ request('status') == $task->status ? 'selected' : '' }}>
                                        {{ $task->status }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="date" name="start_date" placeholder="Başlangıç Zamanı"
                                class="border rounded p-2" value="{{ request('start_date') }}">
                            <input type="date" name="end_date" placeholder="Bitiş Zamanı" class="border rounded p-2"
                                value="{{ request('end_date') }}">

                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fa-solid fa-arrow-down-short-wide mr-2"></i> Filtrele
                            </button>
                        </div>

                    </form>
                </div>



                <div class="flex items-center mr-2 mb-2">
                    <p class="text-lg mr-4"><span class="font-bold">{{ $taskCount }}</span> task görüntüleniyor.</p>

                </div>

            </div>







            <div class="overflow-x-auto">
                <table class="table-container">
                    <thead>
                        <tr>
                            <th>Profil Resmi</th>
                            <th>İsim ve Mail</th>
                            <th>Başlık</th>
                            <th>Proje</th>
                            <th>Başlangıç / Bitiş Tarihi</th>
                            <th>Durum</th>
                            <th>Ekler</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $badgeColors = [
                                'bg-orange-100 text-gray-600',
                                'bg-[#dcedc8] text-gray-600',
                                'bg-sky-100 text-gray-600',
                            ];
                            $today = now()->format('Y-m-d');
                        @endphp
                        @foreach ($tasks as $index => $task)
                            @php
                                $user = $task->user;
                                $badgeColor = $badgeColors[$index % count($badgeColors)];
                                $isOverdue = $task->due_date < $today && $task->status !== 'Tamamlandı';
                            @endphp
                            <tr>
                                <td class="icon-container">
                                    @if ($user && $user->profilePic)
                                        <img src="{{ asset('images/' . $user->profilePic) }}" alt="{{ $user->name }}">
                                    @else
                                        <span class="text-gray-500">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user)
                                        {{ $user->name }}
                                        <p class="text-muted">{{ $user->email }}</p>
                                    @else
                                        <span class="text-gray-500">Unknown User</span>
                                    @endif
                                </td>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->assignedProject->name ?? 'Proje yok' }}</td>
                                <td>
                                    <p>{{ $task->start_date }} / {{ $task->due_date }}</p>
                                </td>
                                <td>
                                    @php
                                        $taskStatus = $isOverdue ? 'Teslim Edilmedi, ' . $task->status : $task->status;
                                    @endphp

                                    <span
                                        class="inline-block rounded-full px-2 py-1 text-sm font-semibold {{ $isOverdue ? 'bg-red-500 text-white animate-pulse' : $badgeColor }}">
                                        {{ $taskStatus }}
                                    </span>
                                </td>
                                <td>
                                    @if ($task->attachments)
                                        <a href="{{ route('attachments.download', ['filename' => basename($task->attachments)]) }}"
                                            class="text-gray-500 hover:text-gray-700 transition" title="İndir">
                                            <i class="fa-solid fa-paperclip"></i>
                                        </a>
                                    @endif
                                </td>


                                <td class="relative">


                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('tasks.show', $task->id) }}"
                                            class="text-blue-500 hover:text-black transition">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </a>
                                    </div>







                                </td>





                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
