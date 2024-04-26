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
<div class="card">
  <div class="card-header">
    <h3>Create new project</h3>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('project.createProject') }}" class="container">
        @csrf
		<div class="form-group w-100">
			<label for="name" class="form-label">Project's name</label>
			<input type="text" name="name" id="name" placeholder="Project's name" class="form-text w-100 py-1">
		</div>
		<div class="btn-group gap-1">
			<button type="submit" class="btn btn-primary">Save</button>
			<a class="btn btn-danger" href="{{ route('project.index')}}">Cancel</a>
		</div>
    </form>
  </div>
</div>
@stop

