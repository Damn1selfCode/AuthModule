<div class="card card-primary card-outline">

    <div class="card-header">

        <h3 class="card-title">Crear un nuevo Ticket</h3>

    </div>

    <form method="post" action="{{ route('soporte.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card-body">

            <!--=====================================
			PARA QUIÉN VA DIRIGIDO EL TICKET
			======================================-->

            <div class="input-group mb-3">

                <div class="input-group-prepend">
                    <span class="input-group-text">Para:</span>
                </div>

                <input type="hidden" class="form-control" value="" name="receptor">

                <input type="text" class="form-control" value="Academy of life" readonly required>

                <input type="hidden" class="form-control" value="1" name="receptor">

            </div>

            <!--=====================================
			EL ASUNTO DEL TICKET
			======================================-->

            <div class="input-group mb-3">

                <div class="input-group-prepend">
                    <span class="input-group-text">Asunto:</span>
                </div>


                <input type="text" class="form-control" value="" name="asunto" required>




            </div>

            <!--=====================================
			EL MENSAJE DEL TICKET
			======================================-->

            <div class="form-group">

                <textarea id="editor" name="mensaje" style="width: 100%"></textarea>

                <!--=====================================
				LOS ADJUNTOS DEL TICKET
				======================================-->

                <div class="form-group my-2">

                    <div class="btn btn-default btn-file">

                        <i class="fas fa-paperclip"></i> Adjuntar

                        <input type="file" class="subirAdjuntos" multiple>

                        <input type="hidden" name="adjuntos" class="archivosTemporales">

                    </div>

                    <p class="help-block small">Archivos con peso máximo de 32MB</p>

                </div>

            </div>

        </div>

        <div class="card-footer">

            <ul class="mailbox-attachments d-flex align-items-stretch clearfix">

            </ul>

            <div class="float-right">

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-envelope"></i> Enviar
                </button>

            </div>

            <button type="reset" class="btn btn-default">
                <i class="fas fa-times"></i> Descartar
            </button>

        </div>
    </form>

</div>
<div class="modal" id="mensajeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mensaje</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" id="successMessage" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>

