@extends(in_array(auth()->user()->is_admin, [0, 2]) ? 'userLayout.app' : 'layout.app')

@section('content')
    <style>
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .content-container {
            min-height: 100vh;
            padding: 20px;
            margin-top: 2rem;
            box-sizing: border-box;
        }

        .dropdown-content {
            display: none;
        }

        .dropdown-content.show {
            display: block;
        }
    </style>

    <div class="container content-container ">
        <div class="flex justify-between items-center mx-auto p-4">
            <h1 class="text-3xl mb-6 mt-3 text-gray-600"><i class="fa-solid fa-code text-sky-500"></i> Projeler</h1>
            <div class="flex justify-end items-center mx-auto p-4">
                <p class="text-md text-gray-600 underline">{{ count($projects) }} proje görüntüleniyor..</p>
            </div>
            <a href="{{ route('projects.create') }}"
                class="inline-block mb-4 px-6 py-2 bg-sky-500 text-white rounded-full hover:bg-blue-500 transition duration-200"><i
                    class="fa-solid fa-circle-plus"></i> Proje Oluştur</a>
        </div>

        @php
            use App\Models\UserProject;
            use App\Models\Project;
            use Illuminate\Support\Facades\Auth;

            $userId = Auth::id();
            $projectIds = UserProject::where('user_id', $userId)->pluck('project_id');
            $projects = Project::whereIn('id', $projectIds)->get();
        @endphp


        @if ($projects && count($projects) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($projects as $index => $project)
                    @php
                        $iconBackgroundColors = ['bg-sky-100', 'bg-[#dcedc8]', 'bg-orange-100'];
                        $iconColors = ['text-sky-500', 'text-green-500', 'text-orange-500'];
                        $iconData = [
                            ['icon' => 'fa-code'],
                            ['icon' => 'fa-project-diagram'],
                            ['icon' => 'fa-tasks'],
                            ['icon' => 'fa-rocket'],
                            ['icon' => 'fa-clipboard-list'],
                            ['icon' => 'fa-chart-pie'],
                            ['icon' => 'fa-code-branch'],
                            ['icon' => 'fa-database'],
                            ['icon' => 'fa-desktop'],
                            ['icon' => 'fa-file-code'],
                            ['icon' => 'fa-folder'],
                            ['icon' => 'fa-laptop-code'],
                            ['icon' => 'fa-microchip'],
                            ['icon' => 'fa-mobile-alt'],
                            ['icon' => 'fa-network-wired'],
                            ['icon' => 'fa-server'],
                            ['icon' => 'fa-shield-alt'],
                            ['icon' => 'fa-tablet-alt'],
                        ];
                        $bgColor = $iconBackgroundColors[$index % count($iconBackgroundColors)];
                        $iconColor = $iconColors[$index % count($iconColors)];
                        $icon = $iconData[$index % count($iconData)];
                    @endphp
                    <div class="card bg-white rounded-xl shadow-sm p-6 transition duration-200 hover:shadow-xl relative">
                        <div class="dropdown absolute top-2 right-2 mr-1 mt-1">
                            <button class="text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300 rounded-full p-2 transition duration-200 dropdown-toggle">
                                <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                            </button>
                            
                            <div
                                class="dropdown-content absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-xl z-10">
                                <ul class="py-2">
                                    <li>
                                        <a href="{{ route('projects.edit', $project->id) }}"
                                            class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 transition rounded-lg">
                                            <i class="fa fa-edit mr-2 text-blue-500"></i> Düzenle
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/projects/files/' . $project->id) }}"
                                            class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 transition rounded-lg">
                                            <i class="fa fa-folder-open mr-2 text-green-500"></i> Dosyaları Görüntüle
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST"
                                            onsubmit="return confirm('Bu projeyi silmek istediğinize emin misiniz?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="flex items-center w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 transition rounded-lg">
                                                <i class="fa fa-trash mr-2"></i> Sil
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <div class="flex items-center mb-4">
                            <div
                                class="w-12 h-12 rounded-full {{ $bgColor }} flex items-center justify-center transform transition-transform duration-200 hover:scale-110">
                                <i class="fa-solid {{ $icon['icon'] }} text-md {{ $iconColor }}"></i>
                            </div>
                            <div class="ml-4">
                                <a href="{{ route('projects.show', $project->id) }}"
                                    class="text-2xl text-gray-600 hover:underline font-semibold mt-2">{{ $project->name }}</a>

                                <p class="flex items-center gap-2 text-gray-600 mb-4">
                                    @if ($project->manager)
                                        <i class="fa-solid fa-user-shield text-sm"></i>
                                        <span>{{ $project->manager->name }}</span>
                                    @else
                                        <i class="fa-solid fa-user-slash text-sm"></i>
                                        <span class="text-gray-500">Proje Müdürü Atanmadı</span>
                                    @endif
                                </p>

                            </div>
                        </div>

                        <p class="text-gray-600 mb-4">{{ $project->description }}</p>


                        @if ($project->users && count($project->users) > 0)
                            @php
                                $printedNames = [];
                            @endphp
                            <div class="mb-4">
                                <ul class="list-disc list-inside">
                                    @foreach ($project->users as $user)
                                        @if (!in_array($user->name, $printedNames))
                                            @php
                                                $printedNames[] = $user->name;
                                            @endphp
                                            <li class="text-gray-600">{{ $user->name }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif




                        <div class="mb-4">
                            <span
                                class="inline-block {{ $bgColor }} text-sm text-gray-600 px-2 py-1 rounded-full">{{ $project->type }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>Henüz proje yok.</p>
        @endif
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.dropdown-toggle').forEach(button => {
            button.addEventListener('click', function(event) {
                event.stopPropagation();
                const dropdownContent = this.nextElementSibling;
                document.querySelectorAll('.dropdown-content').forEach(content => {
                    if (content !== dropdownContent) {
                        content.classList.remove('show');
                    }
                });
                dropdownContent.classList.toggle('show');
            });
        });

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-content').forEach(dropdownContent => {
                    dropdownContent.classList.remove('show');
                });
            }
        });
    });
</script>
