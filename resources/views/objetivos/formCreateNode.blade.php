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
		<div class="form-group w-100 d-flex flex-column gap-4">
			<div class="d-flex flex-column">
				<label for="name" class="form-label">Project's name</label>
				<input type="text" name="name" id="name" placeholder="Project's name" class="form-control">
			</div>

			<div class="d-flex flex-column">
				<label for="description" class="form-label">Description</label>
				<textarea id="description" name="description" rows="5" class="form-control" placeholder="Leave a comment here"> </textarea>
			</div>
		</div>
		<div class="btn-group gap-1">
			<button type="submit" class="btn btn-primary">Save</button>
			<a class="btn btn-danger" href="{{ route('project.index')}}">Cancel</a>
		</div>
    </form>
  </div>
</div>
@stop

