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
    {{-- <div class="btn-group col-1 my-4 -ml-3">
        <a href="{{ route('da.index') }}" class="btn btn-primary d-flex gap-2 p-3">
            <b>&#10554;</b>
            Back
        </a> 
    </div>
    <div class="d-flex gap-2">
        <main class="col-6 border border-black p-0 card">
            <div class="card-header">
                <h3 class="m-0">CONNECT DECISION AREAS</h3>
            </div>
            <ul class="fa-ul list-unstyled d-flex flex-column gap-2 px-2 m-0 p-2 px-4">
                <li class="w-100 d-flex align-items-baseline justify-content-between btn-group" role="group" aria-label="Basic checkbox toggle button group">
                    <input type="checkbox" class="btn-check disabled" id="btncheck{{ $da->id }}" autocomplete="off" checked>
                    <label class="btn btn-outline-primary disabled" for="btncheck{{ $da->id }}">{{ $da->label }}</label>
                </li>
            </ul>
        </main>
        <section class="col-5 border border-black p-0 card">
            <div class="card-header">
                <h3 class="m-0">CONNECT TO</h3>
            </div>
            <ul class="fa-ul list-unstyled d-flex flex-column gap-2 px-2 m-0 p-2 px-4">
                @foreach ($decisionAreas as $da)
                    <li class="w-100 d-flex align-items-baseline justify-content-between btn-group" role="group" aria-label="Basic checkbox toggle button group">
                        <input type="checkbox" class="btn-check" id="btncheck{{ $da->id }}" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btncheck{{ $da->id }}">{{ $da->label }}</label>
                    </li>
                @endforeach
            </ul>
        </section>
        <h1>{{ $da }}</h1>
    </div> --}}
    <div class="btn-group my-2">
        <a href="{{ route('da.index', ['project_id' => $project_id]) }}" class="btn btn-primary d-flex gap-2 p-3">
            <b>&#10554;</b>
            Back
        </a> 
    </div>

    @if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <div class="d-flex gap-2">
        <main class="col-6 border border-black p-0 card">
            <div class="card-header">
                <h3 class="m-0">CONNECT DECISION AREAS</h3>
            </div>
            <ul class="fa-ul list-unstyled d-flex flex-column gap-2 px-2 m-0 p-2 px-4">
                <li class="w-100 d-flex align-items-baseline justify-content-between btn-group" role="group" aria-label="Basic checkbox toggle button group">
                    <input type="checkbox" class="btn-check disabled" id="btncheck{{ $da->id }}" autocomplete="off" checked>
                    <label class="btn btn-outline-primary disabled" for="btncheck{{ $da->id }}">{{ $da->label }}</label>
                </li>
            </ul>
        </main>
        <section class="col-5 border border-black p-0 card">
            <div class="card-header">
                <h3 class="m-0">CONNECT TO</h3>
            </div>
            <ul class="fa-ul list-unstyled d-flex flex-column gap-2 px-2 m-0 p-2 px-4">
                <form action="{{ route('da.connect') }}" method="POST">
                    @csrf
                    <input type="hidden" name="decision_area_id_1" value="{{ $da->id }}">
                    <input type="hidden" name="project_id" value="{{ $project_id }}">
                    @foreach ($availableDecisionAreas as $da)
                        <li class="w-100 d-flex align-items-baseline justify-content-between btn-group" role="group" aria-label="Basic checkbox toggle button group">
                            <input type="checkbox" class="btn-check" id="btncheck{{ $da->id }}" name="decision_area_id_2[]" value="{{ $da->id }}" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btncheck{{ $da->id }}">{{ $da->label }}</label>
                        </li>
                    @endforeach
                    <button type="submit" class="btn btn-primary mt-3">Connect</button>
                </form>
            </ul>
        </section>
    </div>
@stop