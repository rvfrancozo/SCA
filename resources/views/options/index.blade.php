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
        <a href="{{ route('da.index', ['project_id' => $project_id]) }}" class="btn btn-primary d-flex gap-2 p-3">
            <b>&#10554;</b>
            Back
        </a> 
    </div>
    <div class="d-flex gap-2 row m-auto">
        <main class="col-5 border border-black p-0 card" style="min-height: 40dvh;">
            <div class="card-header">
                <h3 class="m-0">ADD OPTION TO DA</h3>
            </div>
            <div class="text-center m-auto">
				<p class="fs-2 opacity">Select a DA to add options</p>
			</div>
        </main>
        <section class="col-5 border border-black p-0 card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="m-0">DAs List</h3>
				<div class="d-flex flex-column align-content-end m-0">
					<button class="btn border m-0" type="button" data-bs-toggle="collapse" data-bs-target="#info" aria-expanded="false" aria-controls="info">
						?
					</button>
					<div class="collapse m-0" id="info">
						<div class="card card-body m-0">
						  This section shows only focused DAs
						</div>
					</div>
				</div>
            </div>
            <ul class="fa-ul list-unstyled d-flex flex-column gap-2 px-2 m-0 p-2 px-4">
                @foreach ($das as $da)
                    <li class="w-100 d-flex align-items-baseline justify-content-between">
                        <h4>{{ $da->label }}</h4>
						{{-- {{ $da->id }} --}}
                        <div class="btn-group">
                            <a href="{{ route('option.formCreate', ['project_id' => $project_id, 'decision_area_id' => $da->id]) }}" class="btn btn-secondary">Add Options</a>
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