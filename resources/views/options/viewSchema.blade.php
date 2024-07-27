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
		<form method="GET" action="/nodes">
			@csrf
			<button style="border:none;background-color:transparent" type="submit" class="nav-link">My Decision Problems</button>
		</form>
	</li>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<li>
		<form method="POST" action="/formCreateNode/0">
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
                    {{-- @foreach($options->where('decision_area_id', $decisionAreas->first()->id) as $option)
                        @php
                            $rowOptions = [$option];
                        @endphp
                        <tr>
                            @foreach($decisionAreas as $index => $da)
                                @php
                                    $nextRowOptions = [];
                                    $cells = [];
                                    foreach ($rowOptions as $rowOption) {
                                        $cells[] = $rowOption->label;
                                        foreach ($options as $opt) {
                                            if ($opt->id !== $rowOption->id && $opt->decision_area_id === $da->id) {
                                                $nextRowOptions[] = $opt;
                                            }
                                        }
                                    }
                                @endphp
                                @if($index === 0)
                                    <td class="text-center align-middle">{{ implode(', ', $cells) }}</td>
                                @else
                                    <td class="text-center align-middle">
                                        @foreach($nextRowOptions as $conn)
                                            @php
                                                $state = $comparisonData[$option->id][$conn->id] ?? null;
                                                $bgColor = '';
                                                if ($state === null) {
                                                    $bgColor = 'background-color: yellow;';
                                                } elseif ($state == 1) {
                                                    $bgColor = 'background-color: green;';
                                                } elseif ($state == 0) {
                                                    $bgColor = 'opacity: 50%;';
                                                }
                                            @endphp
                                            <div style="{{ $bgColor }}">{{ $conn->label }}</div>
                                        @endforeach
                                    </td>
                                @endif
                                @php
                                    $rowOptions = $nextRowOptions;
                                @endphp
                            @endforeach
                        </tr>
                    @endforeach --}}
                    @foreach ($data as $d)
                        <tr>
                            <td>
                                @foreach ($d as $options)
                                    @foreach ($options as $opt)
                                        <div>{{ $opt }}</div>
                                    @endforeach
                                @endforeach
                            </td>
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