
<a href="{{ route('soporte') }}" c class="btn btn-primary btn-block mb-3">Crear Ticket</a>
<div class="card">

	<div class="card-header">

		<h3 class="card-title">Tickets</h3>

		<div class="card-tools">

			<button type="button" class="btn btn-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>

		</div>

	</div>

	<div class="card-body p-0">

		<ul class="nav nav-pills flex-column">

			<li class="nav-item">

				<a href="{{ route('soporte.recibidos') }}" class="nav-link" data-section="recibidos">
					<i class="fas fa-inbox"></i> Recibidos
					<span class="badge bg-primary float-right">{{ $totalRecibidos }}</span>
				</a>

			</li>

			<li class="nav-item">
				<a href="{{ route('soporte.enviados') }}" class="nav-link" data-section="enviados">
					<i class="fas fa-inbox"></i> Enviados
					<span class="badge bg-info float-right">{{ $totalEnviados }}</span>
				</a>


			</li>


			<li class="nav-item">

				<a href="{{ route('soporte.papelera') }}" class="nav-link" data-section="papelera">
					<i class="fas fa-inbox"></i> Papelera
					<span class="badge bg-danger float-right">{{ $totalPapelera }}</span>
				</a>


			</li>

		</ul>

	</div>
</div>