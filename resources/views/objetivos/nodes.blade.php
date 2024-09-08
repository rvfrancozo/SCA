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
		<form method="GET" action="/formCreateProject">
			@csrf
			<button style="border:none;background-color:transparent" type="submit" class="nav-link">New Decision Problem</button>
		</form>
	</li>
	@endguest

</ul>
@stop

@section ('conteudo')
<!-- {{ $x = 0 }}  -->
<div>
	<a class="btn btn-primary my-2" href="{{ route('project.formCreateProject') }}">New Project</a>
	<table class="table table-bordered table-striped table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Projects</th>
				<th>Description</th>
				<th>Operations</th>
				<th>Others</th>
			</tr>
		</thead>
		<tbody>
			@foreach($projects as $o)
			<tr>
				<td>{{ ++$x }}</td>
				<td>
					{{ $o['name'] }}
				</td>
				<td>
					{{ substr($o['description'], 0, 30) }}...
					{{-- Add view complete description --}}
				</td>
				<td>
					<div class="btn-group">
						<a href="{{ route('da.index', ['project_id' => $o['id']]) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="">Shape</a>
						&nbsp;<a href="/nodes/{{ $o['id'] }}/alternatives" class="btn btn-sm btn-primary disabled" data-toggle="tooltip" title="teste">Design</a>
						&nbsp;<a href="/nodes/{{ $o['id'] }}/alternatives" class="btn btn-sm btn-primary disabled" data-toggle="tooltip" title="teste">Compare</a>
						&nbsp;<a href="/nodes/{{ $o['id'] }}/alternatives" class="btn btn-sm btn-primary disabled" data-toggle="tooltip" title="teste">Choose</a>
					</div>
				</td>
				<td>
					<div class="btn-group">
						<a class="btn btn-primary btn-sm" href="#">Report</a>
						{{-- <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#excluir_{{$o->id}}">Remove</button> --}}
						<form action="{{ route('project.remove', $o->id) }}" method="POST">
							@csrf
							@method('delete')
							<button class="btn btn-sm btn-danger">Remove</button> 
						</form>
					</div>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@stop