<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DecisionArea;
use App\Models\DecisionAreaConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DecisionAreaController extends Controller {
    public function index(Request $request) {
        $project_id = $request->project_id;
        $decisionAreas = DecisionArea::where('project_id', $project_id)->get();
        $connections = DB::table('decision_area_connections')
            ->where('project_id', $project_id)
            ->get();

        // $connections = DecisionAreaConnection::where('project_id', $project_id)->get();

        // $daConnections = [];
        // foreach ($decisionAreas as $da) {
        //     $daConnections[$da->id] = [
        //         'label' => $da->label,
        //         'connections' => $connections->filter(function($conn) use ($da) {
        //             return $conn->decision_area_id_1 == $da->id || $conn->decision_area_id_2 == $da->id;
        //         })->map(function($conn) use ($da) {
        //             return $conn->decision_area_id_1 == $da->id ? $conn->decision_area_id_2 : $conn->decision_area_id_1;
        //         })
        //     ];
        // }

        $daConnections = [];
        // foreach ($decisionAreas as $da) {
        //     $daConnections[$da->id] = [
        //         'da' => $da,
        //         'connections' => $connections->filter(function($conn) use ($da) {
        //             return $conn->decision_area_id_1 == $da->id || $conn->decision_area_id_2 == $da->id;
        //         })->map(function($conn) use ($da) {
        //             return $conn->decision_area_id_1 == $da->id ? $conn->decision_area_id_2 : $conn->decision_area_id_1;
        //         })
        //     ];
        // }
        foreach ($decisionAreas as $da) {
            $filteredConnections = $connections->filter(function($conn) use ($da) {
                return $conn->decision_area_id_1 == $da->id || $conn->decision_area_id_2 == $da->id;
            })->map(function($conn) use ($da) {
                return $conn->decision_area_id_1 == $da->id ? $conn->decision_area_id_2 : $conn->decision_area_id_1;
            });
    
            if ($filteredConnections->isNotEmpty()) {
                $daConnections[$da->id] = [
                    'da' => $da,
                    'connections' => $filteredConnections
                ];
            }
        }

        return view('decisionAreas.index', compact('decisionAreas', 'daConnections', 'project_id'));
    }

    public function formCreateDA(Request $request) {
        $project_id = $request->project_id;
        $das = DecisionArea::where('project_id', $project_id)->get();

        return view("decisionAreas.formCreateDA", compact('das', 'project_id'));
    }

    public function formEditDA($project_id, DecisionArea $da) {
        $decisionAreas = DecisionArea::query()->orderBy('id')->paginate()->where('project_id', $project_id);

        return view("decisionAreas.formEditDA", compact('da', 'decisionAreas', 'project_id'));
    }

    public function createDA(Request $request, $project_id) {
        $data = $request->validate([
            'label' => ['required', 'string'],
            'description' => ['required', 'string'],
            'importancy' => ['required', 'integer'],
            'urgency' => ['required', 'integer'],
            'isFocused' => ['boolean'],
        ]);

        $data['isFocused'] = $request->filled('isFocused');
        $data['project_id'] = $project_id;
        // dd($data['project_id'], $project_id);
        $da = DecisionArea::create($data);

        return redirect()->route('da.index', $project_id)->with('message', 'Decision Area was created');
    }

    public function editDA(Request $request, $project_id, DecisionArea $da) {
        $data = $request->validate([
            'label' => ['required', 'string'],
            'description' => ['required', 'string'],
            'importancy' => ['required', 'integer'],
            'urgency' => ['required', 'integer'],
            'isFocused' => ['boolean'],
        ]);

        // $data['isFocused'] = $request->filled('isFocused');
        $da->update($data);

        return redirect()->route('da.index', ['project_id' => $project_id, 'da' => $da])->with('message', 'Decision Area was updated');
    }

    public function deleteDA($project_id, DecisionArea $da) {
        $da->delete();
        
        return redirect()->route('da.index', ['project_id' => $project_id, 'da' => $da])->with('message', 'Decision Area was deleted');
    }

    public function formPreConnectDA($project_id) {
        $decisionAreas = DecisionArea::where('project_id', $project_id)->get();

        return view("decisionAreas.formPreConnectDA", compact('decisionAreas', 'project_id'));
    }

    public function formConnectDA($project_id, Request $request, DecisionArea $da) {
        $project_id = $request->project_id;

        $decisionAreas = DecisionArea::where('project_id', $project_id)->get();

        $connectedIds1 = DecisionAreaConnection::where('decision_area_id_1', $da->id)
                                            ->pluck('decision_area_id_2')
                                            ->toArray();
        $connectedIds2 = DecisionAreaConnection::where('decision_area_id_2', $da->id)
                                            ->pluck('decision_area_id_1')
                                            ->toArray();
        $connectedIds = array_merge($connectedIds1, $connectedIds2);

        $availableDecisionAreas = $decisionAreas->whereNotIn('id', $connectedIds)
                                                ->where('id', '!=', $da->id);
        
        return view('decisionAreas.formConnectDA', compact('da', 'availableDecisionAreas', 'project_id'));
    }

    public function showConnections(Request $request) {
        $project_id = $request->project_id;
        $decisionAreas = DecisionArea::where('project_id', $project_id)->get();
        $connections = DB::table('decision_area_connections')
            ->where('project_id', $project_id)
            ->get();

        $daConnections = [];
        foreach ($decisionAreas as $da) {
            $filteredConnections = $connections->filter(function($conn) use ($da) {
                return $conn->decision_area_id_1 == $da->id || $conn->decision_area_id_2 == $da->id;
            })->map(function($conn) use ($da) {
                return $conn->decision_area_id_1 == $da->id ? $conn->decision_area_id_2 : $conn->decision_area_id_1;
            });
    
            if ($filteredConnections->isNotEmpty()) {
                $daConnections[$da->id] = [
                    'da' => $da,
                    'connections' => $filteredConnections
                ];
            }
        }

        return view('decisionAreas.showConnections', compact('decisionAreas', 'daConnections', 'project_id'));
    }

    public function connect(Request $request) {
        $request->validate([
            'decision_area_id_1' => 'required|exists:decision_areas,id',
            'decision_area_id_2' => 'required|array',
            'decision_area_id_2.*' => 'required|exists:decision_areas,id|different:decision_area_id_1',
            'project_id' => 'required|exists:projects,id',
        ]);

        $decision_area_id_1 = $request->decision_area_id_1;
        $project_id = $request->project_id;
        $messages = [];

        foreach($request->decision_area_id_2 as $decision_area_id_2) {
            $connectionExists = DB::table('decision_area_connections')
                ->where(function($query) use ($decision_area_id_1, $decision_area_id_2, $project_id) {
                    $query->where('decision_area_id_1', $decision_area_id_1)
                        ->where('decision_area_id_2', $decision_area_id_2)
                        ->where('project_id', $project_id);
                })->orWhere(function($query) use ($decision_area_id_1, $decision_area_id_2, $project_id) {
                    $query->where('decision_area_id_1', $decision_area_id_2)
                        ->where('decision_area_id_2', $decision_area_id_1)
                        ->where('project_id', $project_id);
                })->exists();

            if(!$connectionExists){
                DB::table('decision_area_connections')->insert([
                    'decision_area_id_1' => $decision_area_id_1,
                    'decision_area_id_2' => $decision_area_id_2,
                    'project_id' => $project_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('da.index', ['project_id' => $project_id])->with('message', 'Decision Areas connected successfully.');
    }

    public function deleteConnection(Request $request) {
        
    }
}