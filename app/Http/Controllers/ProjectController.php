<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\UserProject;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        $user = Auth::user();

        if ($user && $user->role == 'admin') {
            $projects = Project::all();
        } else {
            $projects = $user ? $user->projects : collect();
        }
        return view('projects.index', compact('projects'));




    }

    public function create()
    {
        $users = User::all();
        return view('projects.create', compact('users'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'description' => 'nullable',
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
            'project_manager' => 'nullable|exists:users,id', // ✅ FIXED: Correct validation rule
        ]);

        // Create project with correct project_manager assignment
        $project = Project::create([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'project_manager' => $request->project_manager, // ✅ FIXED: Assign actual value instead of validation rule
        ]);

        // Attach users to project
        $project->users()->attach($request->input('users'));

        return redirect()->route('projects.index')->with('success', 'Proje başarıyla oluşturuldu.');
    }


    public function getManager($id)
    {
        $project = Project::find($id);
        if ($project && $project->manager) {
            return response()->json([
                'manager' => ['id' => $project->manager->id, 'name' => $project->manager->name]
            ]);
        }
        return response()->json(['manager' => null]);
    }
    
    public function getProjectUsers($id)
    {
        $users = User::all();
        return response()->json($users);
    }
    



    public function show(Project $project)
    {
        $user = Auth::user();


        if ($user && $user->role != 'admin' && !$project->users->contains($user->id)) {
            abort(403, 'Bu projeye erişim izniniz yok.');
        }
        return view('projects.show', compact('project'));
    }
    public function edit(Project $project)
    {
        $users = User::all();
        return view('projects.edit', compact('project', 'users'));
    }


    public function update(Request $request, Project $project)
    {


        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'description' => 'nullable',
            'project_manager' => 'nullable|exists:users,id',


        ]);

        $project->update($request->all());

        return redirect()->route('projects.index')->with('success', 'Proje başarıyla güncellendi.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Proje başarıyla silindi.');
    }




    public function index1()
    {
        $userId = auth()->id();

        $projectIds = UserProject::where('user_id', $userId)
            ->pluck('project_id');

        $projects = Project::whereIn('id', $projectIds)->get();

        return view('projects.indexUser', compact('projects'));






    }







    public function show1(Project $project)
    {
        $user = Auth::user();


        if (
            $user &&
            $user->role == 'admin' &&
            !$project->users->contains($user->id)
        ) {
            abort(403, 'Bu projeye erişim izniniz yok.');
        }


        return view('projects.showUser', compact('project'));
    }


}

