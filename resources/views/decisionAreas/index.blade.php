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

	<div class="d-flex flex-wrap gap-5">
		@foreach ($decisionAreas as $da)
			<div class="border rounded-2 dropdown">
				<a href="#" class="btn dropdown-toggle p-4 {{ ($da->isFocused) ? "btn-primary" : "" }}" data-bs-toggle="dropdown" aria-expanded="false">
					<span class="fs-4">{{ $da->label }}</span>
				</a>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="{{ route('da.formEdit', ['project_id' => $project_id, 'da' => $da]) }}">Edit</a></li>
					<li><a class="dropdown-item" href="{{ route('da.formConnect', ['project_id' => $project_id, 'da' => $da]) }}">Connect</a></li>
				</ul>
			</div>
		@endforeach
	</div>
	<div class="btn-group my-5 gap-2">
		<a class="btn btn-info" href="{{ route('da.formCreate', ['project_id' => $project_id]) }}">Add Decision Area</a>
		<a class="btn btn-info" href="{{ route('da.formPreConnect', ['project_id' => $project_id]) }}">Connect Decision Areas</a>
	</div>

	<h3 class="mt-5">Connections</h3>
	<ul class="list-group">
		{{-- @foreach ($connections as $connection)
			<li class="list-group-item">
				@php
					$da1 = $decisionAreas->firstWhere('id', $connection->decision_area_id_1);
					$da2 = $decisionAreas->firstWhere('id', $connection->decision_area_id_2);
				@endphp
				{{ $da1->label }} <span class="text-muted">connected to</span> {{ $da2->label }}
			</li>
		@endforeach --}}

		@foreach ($daConnections as $details)
			<div class="border rounded-2 p-3 my-3">
				<h4 class="mb-3">{{ $details['da']->label }} Connections</h4>
				<ul class="list-group">
					@foreach ($details['connections'] as $connectedDaId)
						@php
							$connectedDa = $decisionAreas->firstWhere('id', $connectedDaId);
						@endphp
						@if ($connectedDa)
							<li class="list-group-item">
								{{ $details['da']->label }} <span class="text-muted">connected to</span> {{ $connectedDa->label }}
							</li>
						@endif
					@endforeach
				</ul>
			</div>
		@endforeach
	</ul>
@stop
