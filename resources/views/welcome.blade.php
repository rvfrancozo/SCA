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
		<form method="GET" action="/home">
			@csrf
			<button style="border:none;background-color:transparent" type="submit" class="nav-link">My Decision Problems</button>
		</form>
	</li>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<li>
		<form method="POST" action="/formCreateProject">
			@csrf
			<button style="border:none;background-color:transparent" type="submit" class="nav-link">New Decision Problem</button>
		</form>
	</li>
	@endguest

</ul>
@stop

@section('conteudo')
<h3>SCA - Strategic Choice Approach</h3>
<p> SCA was developed by John Kimball Friend and Allen Hickling and described in details in the Planning Under Pressure (2005) book;</p>
<p> SCA is a problem structuring method centered on the management of uncertainty and commitment in strategic situations, </p>
<p> where strategic refers to the advisability of considering particular decisions in the context of others.</p>
<p> SCA-Web is a web-based software to facilitate the use of the SCA..</p>

<!-- <div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="chart-wrapper">
				<canvas id="myChart"></canvas>
			</div>
		</div>
	</div>
</div>


<script>
	const ctx = document.getElementById('myChart');
	const myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
			datasets: [{
				label: '# of Votes',
				data: [1, 19, 3, 5, 2, 3],
				backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(153, 102, 255, 0.2)',
					'rgba(255, 159, 64, 0.2)'
				],
				borderColor: [
					'rgba(255, 99, 132, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(153, 102, 255, 1)',
					'rgba(255, 159, 64, 1)'
				],
				borderWidth: 1
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true
					}
				}]
			}
		}
	});
</script> -->

@stop