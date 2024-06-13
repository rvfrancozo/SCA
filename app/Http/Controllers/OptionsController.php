<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DecisionArea;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    public function index(Request $request) {
        $project_id = $request->project_id;
        $das = DecisionArea::where('project_id', $project_id)
                        ->where('isFocused', true)
                        ->get();

        return view('options.index', compact('project_id', 'das'));
    }

    public function formCreateOption(Request $request) {
        $project_id = $request->project_id;
        $decision_area_id = $request->decision_area_id;

        $das = DecisionArea::where('project_id', $project_id)
                        ->where('isFocused', true)
                        ->where('id', '!=', $decision_area_id)
                        ->get();
        $options = Option::where('project_id', $project_id)
                        ->where('decision_area_id', $decision_area_id)
                        ->get();

        return view('options.formCreateOptions', compact('project_id', 'decision_area_id', 'das', 'options'));
    }

    public function formEditOption(Request $request) {
        $project_id = $request->project_id;
        $decision_area_id = $request->decision_area_id;
        $option_id = $request->option_id;
        $opt = Option::where('project_id', $project_id)
                        ->where('decision_area_id', $decision_area_id)
                        ->where('id', $option_id)
                        ->firstOrFail();

        $options = Option::where('project_id', $project_id)
                        ->where('decision_area_id', $decision_area_id)
                        ->get();

        return view('options.formEditOptions', compact('project_id', 'decision_area_id', 'options', 'opt'));
    }

    public function createOption(Request $request) {
        $project_id = $request->project_id;
        $decision_area_id = $request->decision_area_id;
        $das = DecisionArea::where('project_id', $project_id)->where('isFocused', true)->where('id', '!=', $decision_area_id)->get();

        $data = $request->validate([
            'label' => 'required|string|max:50',
        ]);

        $data['decision_area_id'] = $request->decision_area_id;
        $data['$project_id'] = $project_id;

        Option::create([
            'label' => $request->label,
            'decision_area_id' => $request->decision_area_id,
            'project_id' => $request->project_id,
        ]);

        return redirect()->route('option.formCreate', compact('project_id', 'das', 'decision_area_id'))->with('message', 'Option was created');
    }

    public function editOption(Request $request, $option_id) {
        $project_id = $request->project_id;
        $decision_area_id = $request->decision_area_id;
    
        $data = $request->validate([
            'label' => 'required|string|max:50',
        ]);
    
        $opt = Option::where('project_id', $project_id)
                        ->where('decision_area_id', $decision_area_id)
                        ->where('id', $option_id)
                        ->firstOrFail();
    
        $opt->update($data);
    
        return redirect()->route('option.formEdit', ['project_id' => $project_id, 'decision_area_id' => $decision_area_id, 'option_id' => $opt->id])
                         ->with('message', 'Option edited successfully.');
    }

    public function deleteOption(Request $request, $option_id) {
        $project_id = $request->project_id;
        $decision_area_id = $request->decision_area_id;

        $opt = Option::where('project_id', $project_id)
                        ->where('decision_area_id', $decision_area_id)
                        ->where('id', $option_id)
                        ->firstOrFail();

        $opt->delete();

        return redirect()->route('option.formCreate', ['project_id' => $project_id, 'decision_area_id' => $decision_area_id])->with('message', 'Option deleted sucessfully.');
    }

    // public function formCompatibilityMatrix(Request $request) {
    //     $project_id = $request->project_id;

    //     $das = DecisionArea::where('project_id', $project_id)
    //                     ->where('isFocused', true)
    //                     ->get();

    //     $firstDa = $das->shift();
    //     $options = [];
    //     foreach ($das as $da) {
    //         $options[$da->id] = Option::where('decision_area_id', $da->id)
    //                     ->where('project_id', $project_id)
    //                     ->get();
    //     }

    //     $firstDaOptions = Option::where('decision_area_id', $firstDa->id)->get();

    //     // dd($options);
                        
    //     return view('options.formCompatibilityMatrix', [
    //         'project_id' => $project_id, 
    //         'firstDa' => $firstDa,
    //         'firstDaOptions' => $firstDaOptions,
    //         'das' => $das, 
    //         'options' => $options
    //     ]);
    // }

    public function formCompatibilityMatrix(Request $request) {
        $project_id = $request->project_id;
    
        $das = DecisionArea::where('project_id', $project_id)
                        ->where('isFocused', true)
                        ->get();
    
        $comparisons = [];
        foreach ($das as $key1 => $da1) {
            for ($key2 = $key1 + 1; $key2 < $das->count(); $key2++) {
                $da2 = $das[$key2];
                $comparisons[] = [
                    'da1' => $da1,
                    'da1Options' => Option::where('decision_area_id', $da1->id)->get(),
                    'da2' => $da2,
                    'da2Options' => Option::where('decision_area_id', $da2->id)->get()
                ];
            }
        }
                        
        return view('options.formCompatibilityMatrix', [
            'project_id' => $project_id,
            'comparisons' => $comparisons
        ]);
    }
    
}
