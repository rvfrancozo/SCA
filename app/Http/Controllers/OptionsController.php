<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comparison;
use App\Models\DecisionArea;
use App\Models\DecisionAreaConnection;
use App\Models\Option;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function formCompatibilityMatrix(Request $request) {
        $project_id = $request->project_id;

        $das = DecisionArea::where('project_id', $project_id)
            ->where('isFocused', true)
            ->get();

        $optionsByDa = $das->mapWithKeys(function ($da) {
            return [$da->id => $da->options->toArray()];
        });

        $comparisons = [];

        foreach ($das as $da1) {
            foreach ($das as $da2) {
                if ($da1->id < $da2->id) {
                    $da1Options = $optionsByDa[$da1->id];
                    $da2Options = $optionsByDa[$da2->id];

                    $comparisonData = [
                        'da1' => $da1,
                        'da2' => $da2,
                        'da1Options' => $da1Options,
                        'da2Options' => $da2Options,
                        'comparisons' => [],
                    ];

                    foreach ($da1Options as $option1) {
                        foreach ($da2Options as $option2) {
                            $comparison = Comparison::where('project_id', $project_id)
                                ->where(function ($query) use ($option1, $option2) {
                                    $query->where('option_id_1', $option1['id'])
                                        ->where('option_id_2', $option2['id']);
                                })
                                ->orWhere(function ($query) use ($option1, $option2) {
                                    $query->where('option_id_1', $option2['id'])
                                        ->where('option_id_2', $option1['id']);
                                })
                                ->first();

                            $comparisonData['comparisons'][$option1['id']][$option2['id']] = $comparison ? $comparison->state : 'unknown';
                        }
                    }

                    $comparisons[] = $comparisonData;
                }
            }
        }

        // dd($comparisons);

        return view('options.formCompatibilityMatrix', [
            'project_id' => $project_id,
            'das' => $das,
            'optionsByDa' => $optionsByDa,
            'comparisons' => $comparisons,
        ]);
    }
    
    public function saveComparisons(Request $request) {
        Log::info('Form data received', $request->all());

        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'comparisons' => 'required|array',
            'comparisons.*.*.*.option_id_1' => 'required|exists:options,id',
            'comparisons.*.*.*.option_id_2' => 'required|exists:options,id',
            'comparisons.*.*.*.state' => 'required|string|in:compatible,unknown,incompatible',
        ]);

        $project_id = $request->project_id;

        foreach ($request->comparisons as $comparisonGroup) {
            foreach ($comparisonGroup as $comparison) {
                foreach ($comparison as $comp) {
                    $option_id_1 = $comp['option_id_1'];
                    $option_id_2 = $comp['option_id_2'];
                    $state = $comp['state'];
    
                    $stateValue = null;
                    if ($state === 'compatible') {
                        $stateValue = true;
                    } elseif ($state === 'incompatible') {
                        $stateValue = false;
                    }

                    $existingComparison = Comparison::where('project_id', $project_id)
                        ->where(function ($query) use ($option_id_1, $option_id_2) {
                            $query->where('option_id_1', $option_id_1)
                                  ->where('option_id_2', $option_id_2);
                        })
                        ->orWhere(function ($query) use ($option_id_1, $option_id_2) {
                            $query->where('option_id_1', $option_id_2)
                                  ->where('option_id_2', $option_id_1);
                        })
                        ->first();
    
                    if ($existingComparison) {
                        $existingComparison->update(['state' => $stateValue]);
                    } else {
                        Comparison::create([
                            'project_id' => $project_id,
                            'option_id_1' => $option_id_1,
                            'option_id_2' => $option_id_2,
                            'state' => $stateValue,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('option.index', ['project_id' => $project_id])->with('message', 'Comparisons saved successfully.');
    }

    public function showSchemes(Request $request) {
        function querySchema(Request $request, $da_id) {
            $options = Option::where([
                    ['project_id', $request->project_id], 
                    ['decision_area_id', $da_id]
                ])
                ->get();
                
            // dd($connected);

            // returns all options
            // Objetive: Call this function multiple times to get specific options for each da and generate an array
            return $options;
        }
        
        $project_id = $request->project_id;
        $project = Project::findOrFail($project_id);
        $decisionAreas = DecisionArea::where('user_id', $request->user_id)
            ->where('project_id', $project_id)
            ->where('isFocused', true)
            ->get();
            // ->toArray();
        $options = Option::where('project_id', $project_id)->get();
        $comparisons = Comparison::where('project_id', $request->project_id)
            ->distinct()
            ->get();

        $data = collect();
        // $comparisonData = Comparison::select('comparisons.*')
        // ->join('options as opt1', 'comparisons.option_id_1', '=', 'opt1.id')
        // ->join('options as opt2', 'comparisons.option_id_2', '=', 'opt2.id')
        // ->join('decision_areas as da1', 'opt1.decision_area_id', '=', 'da1.id')
        // ->join('decision_areas as da2', 'opt2.decision_area_id', '=', 'da2.id')
        // ->where('da1.project_id', $project_id)
        // ->where('da2.project_id', $project_id)
        // ->where('da1.isFocused', true)
        // ->where('da2.isFocused', true)
        // ->distinct()
        // ->get();

        
        foreach($decisionAreas as $da) {
            $data->push(querySchema($request, $da->id));
        }

        // dd($comparisons);

        return view('options.viewSchema', compact('project', 'decisionAreas', 'options', 'data', 'comparisons', 'project_id'));
    }
}
