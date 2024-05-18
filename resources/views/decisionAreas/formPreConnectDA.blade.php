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
        <a href="{{ route('da.index', $project_id) }}" class="btn btn-primary d-flex gap-2 p-3">
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
                @foreach ($decisionAreas as $da)
                    <li class="w-100 d-flex align-items-baseline justify-content-between btn-group" role="group" aria-label="Basic checkbox toggle button group">
                        <input type="checkbox" class="btn-check" id="btncheck{{ $da->id }}" autocomplete="off">
                        <a class="btn btn-outline-primary text-center" href="{{ route('da.formConnect', ['project_id' => $project_id, 'da' => $da]) }}"><label class="m-0" for="btncheck{{ $da->id }}">{{ $da->label }}</label></a>

                        {{-- <div class="btn-group">
                            <a href="{{ route('da.formEdit', $da->id) }}" class="btn btn-primary">View</a>
                            <form action="{{ route('da.delete', $da->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button  class="btn btn-danger">Remove</button>
                            </form>
                        </div> --}}
                    </li>
                @endforeach
            </ul>
        </main>
        <section class="col-5 border border-black p-0 card">
            <div class="card-header">
                <h3 class="m-0">CONNECT TO</h3>
            </div>
            <ul class="fa-ul list-unstyled d-flex flex-column gap-2 px-2 m-0 p-2 px-4">
                {{-- @foreach ($decisionAreas as $da)
                    <li class="w-100 d-flex align-items-baseline justify-content-between btn-group" role="group" aria-label="Basic checkbox toggle button group">
                        <input type="checkbox" class="btn-check" id="btncheck{{ $da->id }}" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btncheck{{ $da->id }}">{{ $da->label }}</label>
                    </li>
                @endforeach --}}
            </ul>
        </section>
    </div>
@stop