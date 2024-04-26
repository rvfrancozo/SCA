<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::query()->orderBy('id')->paginate(10);
        return view("objetivos.nodes", ['projects' => $projects]);
    }

    public function formCreateProject() {
        $project = Project::query()->orderBy('id')->paginate(10);
        return view('objetivos.formCreateNode', ['project' => $project]);
    }

    public function createProject(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string'],
        ]);

        $projects = Project::create($data);

        return to_route('project.index', $projects)->with('message', 'Note was created');
    }
}
