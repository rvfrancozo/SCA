@extends ('layouts.index')
@section('menu')
<ul class="navbar-nav mr-auto">

	@guest
	@if (Route::has('login'))
	@endif

	@if (Route::has('register'))
	@endif
	@else

	<li class="nav-item">
		<form method="GET" action="/home">
			@csrf
			<button style="border:none;background-color:transparent" type="submit" class="nav-link">My Decision Problems</button>
		</form>
	</li>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<li>
		<form method="POST" action="/formCreateProject">
			@csrf
			<button style="border:none;background-color:transparent" type="submit" class="nav-link">New Decision Problem</button>
		</form>
	</li>
	@endguest

</ul>
@stop

@section ('conteudo')
    <div class="btn-group mb-3">
        <a href="{{ route('option.index', ['project_id' => $project_id]) }}" class="btn btn-primary d-flex gap-2 p-3">
            <b>&#10554;</b>
            Back
        </a> 
    </div>
    <div class="d-flex flex-column gap-2 mt-5">
        <h1>{{ $project->name }} - Assessment of Schemes</h1>
        <h2 class="text-center">Decision Areas</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-scheme">
                <thead>
                    <tr>
                        @foreach($decisionAreas as $da)
                            <th class="text-center align-middle">{{ $da->label }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        $rowOps = array();
                        $i = 0;
                    @endphp
                    @foreach($data->first() as $option)
                        @php
                            $rowOps[] = $option->id;
                        @endphp
                    @endforeach
                    @foreach($data->first() as $option)
                        <!-- NEED TO IMPROVE ASAP AFTER PROJECT BASIC FEATS ARE FINISHED -->
                        <tr>
                            @php
                                $rowOptions = [$option];
                                // dump($rowOps);
                            @endphp
                            @foreach($decisionAreas as $index => $da)
                                @php
                                    $nextRowOptions = [];
                                    $cells = [];
                                    $addedOptionIds = [];

                                    foreach ($rowOptions as $rowOption) {
                                        $cells[] = $rowOption['label']; // save options labels

                                        if (isset($data[$index])) {  // Checks if data[index] is not null
                                            foreach ($data[$index] as $opt) { // Goto options on the next options array
                                                if ($opt['id'] !== $rowOption['id'] && !isset($addedOptionIds[$opt['id']])) {  // Check if it's not the current option set and if it's already added
                                                    $nextRowOptions[] = $opt; // Add to next row options
                                                    $addedOptionIds[$opt['id']] = true; // Add to the variable that checks later if it's already added
                                                }
                                            }
                                        }
                                    }
                                @endphp
                                @if($index === 0)
                                    <td class="text-center align-middle">{{ implode(', ', $cells) }}</td>
                                @else
                                <td class="text-center align-middle">
                                    @if ($index === 1)
                                        @foreach($nextRowOptions as $optRow)
                                            @php
                                                $state = null;
                                                foreach ($comparisons as $comparison) {
                                                    if (
                                                        ($comparison->option_id_1 == $rowOps[$i] && $comparison->option_id_2 == $optRow->id) ||
                                                        ($comparison->option_id_2 == $rowOps[$i] && $comparison->option_id_1 == $optRow->id)
                                                        ) {
                                                        // dump($rowOps[$i], $optRow->id);
                                                        // dump($comparison->state);
                                                        // dump($rowOptions[$i]->id);
                                                        // dump($i);
                                                        $state = $comparison->state;
                                                        break;
                                                    }
                                                }
                                                $bgColor = '';
                                                if ($state === null) {
                                                    $bgColor = 'background-color: yellow;';
                                                } elseif ($state == 1) {
                                                    $bgColor = 'background-color: green;';
                                                } elseif ($state == 0) {
                                                    $bgColor = 'opacity: 50%;';
                                                }
                                            @endphp
                                            <div style="{{ $bgColor }}">{{ $optRow['label'] }}</div>
                                        @endforeach
                                    @else
                                        @foreach($rowOptions as $prevRowOption) <!-- Sets the length of loop based on previous options -->
                                            @foreach($nextRowOptions as $optRow) <!-- Renders the options -->
                                                <!-- This approach removes the bug where the 2nd col render duplicates --> 
                                                @php
                                                    // Need to create a check where it fetch with the $comparisons and $data
                                                    $state = null;
                                                    $bgColor = '';
                                                    foreach ($comparisons as $comparison) {
                                                        // dump($comparison->option_id_1, $comparison->option_id_2);
                                                        if (
                                                            ($comparison->option_id_1 == $prevRowOption->id && $comparison->option_id_2 == $optRow->id) ||
                                                            ($comparison->option_id_2 == $prevRowOption->id && $comparison->option_id_1 == $optRow->id)
                                                            ){
                                                                $state = $comparison->state;
                                                                break;
                                                            }
                                                    }
                                                    $bgColor = '';
                                                    if ($state === null) {
                                                        $bgColor = 'background-color: yellow;';
                                                    } elseif ($state == 1) {
                                                        $bgColor = 'background-color: green;';
                                                    } elseif ($state == 0) {
                                                        $bgColor = 'opacity: 50%;';
                                                    }
                                                @endphp
                                                <div style="{{ $bgColor }}">{{ $optRow['label'] }}</div>
                                                @php
                                                    $state = null;
                                                @endphp
                                            @endforeach
                                        @endforeach
                                        @php
                                            $i++;
                                        @endphp
                                    @endif
                                    </td>
                                @endif
                                @php
                                    $rowOptions = $nextRowOptions;
                                @endphp
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>    
    <div class="btn-group my-3 gap-2">
        <a class="btn btn-info disabled" href="#">COMPARE</a>
    </div>
@stop