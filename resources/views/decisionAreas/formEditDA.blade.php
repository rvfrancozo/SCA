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
    <div class="btn-group col-1 my-4 -ml-3">
        <a href="{{ route('da.index', ['project_id' => $project_id]) }}" class="btn btn-primary d-flex gap-2 p-3">
            <b>&#10554;</b>
            Back
        </a> 
    </div>
    <div class="d-flex gap-2">
        <main class="col-6 border border-black p-0 card">
            <div class="card-header">
                <h3 class="m-0">ADD DECISION AREA</h3>
            </div>
            <form action="{{ route('da.edit', ['project_id' => $project_id, 'da' => $da]) }}" method="POST" class="card-body d-flex flex-column align-items-center">
                @csrf
                @method('PUT')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif
                <div class="d-flex flex-column row w-100">
                    <label for="label" class="form-label">Label</label>
                    <input type="text" name="label" id="label" placeholder="Decision Area name" class="form-control py-1" value="{{ $da->label }}">
                </div>
                <div class="d-flex flex-column row w-100 my-4">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="6" class="form-control">{{ $da->description }}</textarea>
                </div>
                <div class="d-flex flex-column gap-4 w-75 align-self-start">
                    <div>
                        <label for="importancy" class="form-label">Importancy</label>
                        <span class="d-flex gap-2">0<input type="range" name="importancy" id="importancy" min="0" max="10" class="form-range" value="{{ $da->importancy }}">10</span>
                    </div>

                    <div>
                        <label for="urgency" class="form-label">Urgency</label>
                        <span class="d-flex gap-2">0<input type="range" name="urgency" id="urgency" min="0" max="10" class="form-range" value="{{ $da->urgency }}">10</span>
                        <output for="urgency" onforminput="value = urgency.valueAsNumber;"></output>
                    </div>
                </div>
                <div class="btn-group align-self-start mb-4" role="group" aria-label="Basic checkbox toggle button group">
                    <input type="checkbox" class="btn-check align-self-start" id="isFocused" name="isFocused" autocomplete="off" value="1" {{ $da->isFocused ? 'checked' : '' }}>
                    <label class="btn btn-outline-info align-self-start" for="isFocused">Focus</label>
                </div>
                <div class="align-self-start btn-group gap-1">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </main>
        <section class="col-5 border border-black p-0 card">
            <div class="card-header">
                <h3 class="m-0">List</h3>
            </div>
            <ul class="fa-ul list-unstyled d-flex flex-column gap-2 px-2 m-0 p-2 px-4">
                @foreach ($decisionAreas as $da)
                    <li class="w-100 d-flex align-items-baseline justify-content-between">
                        <h4>{{ $da->label }}</h4>

                        <div class="btn-group">
                            <a href="{{ route('da.formEdit',  ['project_id' => $project_id, 'da' => $da]) }}" class="btn btn-primary">View</a>
                            <form action="{{ route('da.delete', ['project_id' => $project_id, 'da' => $da]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button  class="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>
@stop