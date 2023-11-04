<div class="col-12 col-md-4">

	<div class="card card-info card-outline">

		<div class="card-body box-profile">

			<div class="text-center">
				
			 	<img class="profile-user-img img-fluid img-circle" src="vistas/img/usuarios/default/default.png">

			</div>	

			<h3 class="profile-username text-center">
				
				Administrador

			</h3>

			<p class="text-muted text-center">

				info@academyoflife.com

			</p>

			<div class="text-center">
					
			<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cambiarFoto">Cambiar foto</button>
				<button class="btn btn-purple btn-sm" data-toggle="modal" data-target="#cambiarPassword">Cambiar contraseña</button>


			</div>

		</div>

		<div class="card-footer">

			<button class="btn btn-default float-right">Eliminar cuenta</button>

		</div>

	</div>	
	
</div>


<div class="modal" id="cambiarFoto">
  <div class="modal-dialog">
    <div class="modal-content">


	  <form method="post" action="{{ route('actualizar-foto') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <input type="file" class="form-control-file border" name="profile_image" required>
    </div>
	<div>
	        	
	        	<button type="submit" class="btn btn-primary">Enviar</button>

	        </div>
    <!-- Otros campos y botones -->
</form>


    </div>
  </div>
</div>
