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
    <div class="d-flex gap-2 row m-auto">
        <div class="col-12">
            <h3 class="mt-4 mb-4">Comparison Matrix</h3>
            <form action="{{ route('comparisons.save') }}" method="POST" class="card">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @csrf
                <input type="hidden" name="project_id" value="{{ $project_id }}">
                @foreach($comparisons as $comparisonIndex => $comparison)
                    <div class="card-header">
                        <h3>Comparison: {{ $comparison['da1']->label }} - {{ $comparison['da2']->label }}</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center mb-5">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center m-auto">DAS</th>
                                    <th colspan="{{ $comparison['da2Options']->count() + 1 }}">{{ $comparison['da1']->label }}</th>
                                </tr>
                                <tr>
                                    <th>Options</th>
                                    @foreach($comparison['da2Options'] as $option)
                                        <th>{{ $option->label }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comparison['da1Options'] as $optionIndex => $option)
                                    <tr>
                                        @if ($loop->first)
                                            <th rowspan="{{ $comparison['da1Options']->count() }}">{{ $comparison['da2']->label }}</th>
                                        @endif
                                        <th scope="row">{{ $option->label }}</th>
                                        @foreach($comparison['da2Options'] as $optIndex => $opt)
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="comparisons[{{ $comparisonIndex }}][{{ $optionIndex }}][{{ $optIndex }}][state]" id="state{{ $comparisonIndex }}_{{ $optionIndex }}_{{ $optIndex }}_compatible" value="compatible">
                                                    <label class="form-check-label" for="state{{ $comparisonIndex }}_{{ $optionIndex }}_{{ $optIndex }}_compatible">&#8226; Compatible</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="comparisons[{{ $comparisonIndex }}][{{ $optionIndex }}][{{ $optIndex }}][state]" id="state{{ $comparisonIndex }}_{{ $optionIndex }}_{{ $optIndex }}_unknown" value="unknown" checked>
                                                    <label class="form-check-label" for="state{{ $comparisonIndex }}_{{ $optionIndex }}_{{ $optIndex }}_unknown">? Unknown</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="comparisons[{{ $comparisonIndex }}][{{ $optionIndex }}][{{ $optIndex }}][state]" id="state{{ $comparisonIndex }}_{{ $optionIndex }}_{{ $optIndex }}_incompatible" value="incompatible">
                                                    <label class="form-check-label" for="state{{ $comparisonIndex }}_{{ $optionIndex }}_{{ $optIndex }}_incompatible">× Incompatible</label>
                                                </div>
                                                <input type="hidden" name="comparisons[{{ $comparisonIndex }}][{{ $optionIndex }}][{{ $optIndex }}][option_id_1]" value="{{ $option->id }}">
                                                <input type="hidden" name="comparisons[{{ $comparisonIndex }}][{{ $optionIndex }}][{{ $optIndex }}][option_id_2]" value="{{ $opt->id }}">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
                <button type="submit" class="btn btn-primary align-self-start ml-4 mb-4">Save Comparisons</button>
            </form>            
        </div>
    </div>
    {{-- <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center m-auto">DAS</th>
                                <th colspan="{{ $firstDaOptions->count() + 1 }}">{{ $firstDa->label }}</th>
                            </tr>
                            <tr>
                                <th>Options</th>
                                @foreach($firstDaOptions as $option)
                                    <th>{{ $option->label }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($das as $da)
                                @foreach($options[$da->id] as $option)
                                    <tr>
                                        @if ($loop->first)
                                            <th rowspan="{{ count($options[$da->id]) }}">{{ $da->label }}</th>
                                        @endif
                                        <th scope="row">{{ $option->label }}</th>
                                        @foreach($firstDaOptions as $opt)
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="state{{ $loop->parent->parent->index + 1 }}_{{ $loop->parent->index + 1 }}" id="state{{ $loop->parent->parent->index + 1 }}_{{ $loop->parent->index + 1 }}_compatible" value="compatible">
                                                    <label class="form-check-label" for="state{{ $loop->parent->parent->index + 1 }}_{{ $loop->parent->index + 1 }}_compatible">&#8226; Compatible</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="state{{ $loop->parent->parent->index + 1 }}_{{ $loop->parent->index + 1 }}" id="state{{ $loop->parent->parent->index + 1 }}_{{ $loop->parent->index + 1 }}_unknown" value="unknown" checked>
                                                    <label class="form-check-label" for="state{{ $loop->parent->parent->index + 1 }}_{{ $loop->parent->index + 1 }}_unknown">? Unknown</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="state{{ $loop->parent->parent->index + 1 }}_{{ $loop->parent->index + 1 }}" id="state{{ $loop->parent->parent->index + 1 }}_{{ $loop->parent->index + 1 }}_incompatible" value="incompatible">
                                                    <label class="form-check-label" for="state{{ $loop->parent->parent->index + 1 }}_{{ $loop->parent->index + 1 }}_incompatible">× Incompatible</label>
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table> --}}
    <div class="btn-group my-3 gap-2">
        <a class="btn btn-info disabled" href="#">COMPARE</a>
		<a class="btn btn-info disabled" href="#">View Options Schema</a>
    </div>
@stop