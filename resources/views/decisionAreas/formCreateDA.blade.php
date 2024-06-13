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
        <a href="{{ route('project.index') }}" class="btn btn-primary d-flex gap-2 p-3">
            <b>&#10554;</b>
            Back
        </a> 
    </div>
    <div class="d-flex gap-2 row m-auto">
        <main class="col-5 border border-black p-0 card">
            <div class="card-header">
                <h3 class="m-0">ADD DECISION AREA</h3>
            </div>
            <form action="{{ route('da.create', ['project_id' => $project_id]) }}" method="POST" class="card-body d-flex flex-column align-items-center">
                @csrf
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
                    <input type="text" name="label" id="label" placeholder="Decision Area name" class="form-control py-1">
                </div>
                <div class="d-flex flex-column row w-100 my-4">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="6" class="form-control"></textarea>
                </div>
                <div class="d-flex flex-column gap-4 w-75 align-self-start">
                    <div>
                        <label for="importancy" class="form-label">Importancy</label>
                        <span class="d-flex gap-2">0<input type="range" name="importancy" id="importancy" min="0" max="10" class="form-range">10</span>
                    </div>

                    <div>
                        <label for="urgency" class="form-label">Urgency</label>
                        <span class="d-flex gap-2">0<input type="range" name="urgency" id="urgency" min="0" max="10" class="form-range">10</span>
                        <output for="urgency" onforminput="value = urgency.valueAsNumber;"></output>
                    </div>
                </div>
                <div class="btn-group align-self-start mb-4" role="group" aria-label="Basic checkbox toggle button group">
                    <input type="checkbox" class="btn-check align-self-start" id="isFocused" name="isFocused" autocomplete="off" value="1">
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
                @foreach ($das as $da)
                    <li class="w-100 d-flex align-items-baseline justify-content-between">
                        <h4>{{ $da->label }}</h4>

                        <div class="btn-group">
                            <a href="{{ route('da.formConnect', ['project_id' => $project_id, 'da' => $da]) }}" class="btn btn-secondary">Connect</a>
                            <a href="{{ route('da.formEdit', ['project_id' => $project_id, 'da' => $da]) }}" class="btn btn-primary">Edit</a>
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
    <div class="btn-group my-3 gap-2">
		<a class="btn btn-info" href="{{ route('option.index', ['project_id' => $project_id]) }}">DESIGN</a>
		<a class="btn btn-info" href="{{ route('da.viewConnections', ['project_id' => $project_id]) }}">View Connected Areas</a>
	</div>
@stop