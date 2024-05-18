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
	<div class="d-flex flex-wrap gap-5">
		@foreach ($das as $da)
			<div class="border rounded-2 dropdown">
				<a href="#" class="btn dropdown-toggle p-4 {{ ($da->isFocused) ? 'btn-primary' : '' }}" data-bs-toggle="dropdown" aria-expanded="false">
					<span class="fs-4">{{ $da->label }}</span>
				</a>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="{{ route('da.formEdit', ['project_id' => $da->project_id, 'da' => $da->id]) }}">Edit</a></li>
					<li><a class="dropdown-item" href="{{ route('da.formConnect', ['project_id' => $project_id, 'da' => $da]) }}">Connect</a></li>
				</ul>
			</div>
		@endforeach
	</div>
	<div class="btn-group my-5 gap-2">
		<a class="btn btn-info" href="{{ route('da.formCreate') }}">Add Decision Area</a>
		<a class="btn btn-info" href="{{ route('da.formPreConnect', ['project_id' => $project_id]) }}">Connect Decision Areas</a>
	</div>
@stop
