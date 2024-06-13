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
        <main class="col-5 border border-black p-0 card">
            <div class="card-header">
                <h3 class="m-0">EDIT OPTION TO DA {{ $decision_area_id }}</h3>
            </div>
            <form action="{{ route('option.edit', ['project_id' => $project_id, 'decision_area_id' => $decision_area_id, 'option_id' => $opt->id]) }}" 
                method="POST" class="card-body d-flex flex-column align-items-center justify-content-between gap-2" style="min-height: 40dvh;">
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
                    <input type="text" name="label" id="label" placeholder="Decision Area name" class="form-control py-1" value="{{ $opt->label }}">
                </div>
                <div class="align-self-start btn-group gap-1">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </main>
        <section class="col-5 border border-black p-0 card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="m-0">Options List</h3>
            </div>
            <ul class="fa-ul list-unstyled d-flex flex-column gap-2 px-2 m-0 p-2 px-4">
                @foreach ($options as $option)
                    <li class="w-100 d-flex align-items-baseline justify-content-between">
                        <h4>{{ $option->label }}</h4>
                        <div class="btn-group">
                            <a href="{{ route('option.formEdit', ['project_id' => $project_id, 'decision_area_id' => $decision_area_id, 'option_id' => $option->id]) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('option.delete', ['project_id' => $project_id, 'decision_area_id' => $decision_area_id, 'option_id' => $option->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>
    <div class="btn-group my-3 gap-2">
        <a class="btn btn-info disabled" href="#">COMPARE</a>
		<a class="btn btn-info" href="{{ route('option.formMatrix', ['project_id' => $project_id]) }}">View Options Compatibility</a>
		<a class="btn btn-info disabled" href="#">View Options Schema</a>
    </div>
@stop