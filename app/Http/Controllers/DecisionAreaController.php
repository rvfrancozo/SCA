<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DecisionArea;
use App\Models\DecisionAreaConnection;
use Illuminate\Http\Request;

class DecisionAreaController extends Controller
{
    //
    public function index($project_id) {
        $das = DecisionArea::where('project_id', $project_id)->get();
        return view('decisionAreas.index', compact('das', 'project_id'));
    }


    public function formCreateDA() {
        $das = DecisionArea::query()->orderBy('id')->paginate();

        return view("decisionAreas.formCreateDA", ['das' => $das]);
    }

    public function formEditDA(DecisionArea $da) {
        $decisionAreas = DecisionArea::query()->orderBy('id')->paginate();

        // dd($da);

        return view("decisionAreas.formEditDA", [
            'decisionAreas' => $decisionAreas, 
            'da' => $da
        ]);
    }

    public function createDA(Request $request) {
        $data = $request->validate([
            'label' => ['required', 'string'],
            'description' => ['required', 'string'],
            'importancy' => ['required', 'integer'],
            'urgency' => ['required', 'integer'],
            'isFocused' => ['boolean'],
        ]);

        $data['isFocused'] = $request->filled('isFocused');
        $da = DecisionArea::create($data);

        return redirect()->route('da.formCreate', $da)->with('message', 'Decision Area was created');
    }

    public function editDA(Request $request, DecisionArea $da) {
        $data = $request->validate([
            'label' => ['required', 'string'],
            'description' => ['required', 'string'],
            'importancy' => ['required', 'integer'],
            'urgency' => ['required', 'integer'],
            'isFocused' => ['boolean'],
        ]);

        // $data['isFocused'] = $request->filled('isFocused');
        $da->update($data);

        return redirect()->route('da.index', $da)->with('message', 'Decision Area was updated');
    }

    public function deleteDA($id) {
        $da = DecisionArea::find($id);
        $da->delete();
        
        return redirect()->route('da.formCreate')->with('message', 'Decision Area was deleted');
    }

    public function formPreConnectDA($project_id) {
        $decisionAreas = DecisionArea::where('project_id', $project_id)->get();

        return view("decisionAreas.formPreConnectDA", compact('decisionAreas', 'project_id'));
    }

    public function formConnectDA($project_id, DecisionArea $da) {
        $decisionAreas = DecisionArea::where('id', '!=', $da->id)->where('project_id', $project_id)->get();
        
        return view('decisionAreas.formConnectDA', compact('da', 'decisionAreas', 'project_id'));
    }

    public function connect(Request $request)
    {
        $request->validate([
            'decision_area_id_1' => 'required|exists:decision_areas,id',
            'decision_area_id_2' => 'required|exists:decision_areas,id|different:decision_area_id_1',
            'project_id' => 'required|exists:projects,id',
        ]);

        DecisionAreaConnection::create([
            'decision_area_id_1' => $request->decision_area_id_1,
            'decision_area_id_2' => $request->decision_area_id_2,
            'project_id' => $request->project_id,
        ]);

        return redirect()->route('da.index', ['project_id' => $request->project_id])->with('message', 'Decision Areas connected successfully.');
    }
}
