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

    <div class="btn-group">
        <a href="{{ route('da.index', ['project_id' => $project_id]) }}" class="btn btn-primary d-flex gap-2 p-3">
            <b>&#10554;</b>
            Back
        </a> 
    </div>
	<h3 class="mt-3">Connections</h3>
	<ul class="list-group">
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
