<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request) {
        // Pass from the login to the homepage
        $projects = Project::query()->where('user_id', $request->user_id)->orderBy('id')->paginate(10);

        // dd($projects);

        return view("objetivos.nodes", ['projects' => $projects]);
    }

    public function formCreateProject() {
        return view('objetivos.formCreateNode');
    }

    public function createProject(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'user_id' => ['required', 'integer']
        ]);

        $data['user_id'] = $request->user_id;
        $projects = Project::create($data);

        return to_route('project.index', $projects)->with('message', 'Project was created');
    }

    public function deleteProject($id) {
        $project = Project::find($id); 
        $project->delete();
        
        return to_route('project.index')->with('message', 'Note was deleted');
    }
}
    