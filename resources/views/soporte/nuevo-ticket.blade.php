<div class="card card-primary card-outline">
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif


    <div class="card-header">
        
        <h3 class="card-title">Crear un nuevo Ticket</h3>
    </div>


    <!-- Bloque para mostrar roles -->

    <form method="post" action="{{ url('/soporte') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

            <div class="input-group mb-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Para:</span>
                    </div>

                    @if(auth()->user()->role == 'admin')
                    <select name="receptor" class="form-control" required>
                        <option value="" disabled {{ (!$ticket) ? 'selected' : '' }}>Seleccione un usuario</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ ($ticket && $ticket->receptor == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @else
                    <input type="text" class="form-control" value="Learn Stream Support" readonly required>
                    <input type="hidden" class="form-control" value="9" name="receptor">
                    @endif
                </div>

                <!-- EL ASUNTO DEL TICKET -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Asunto:</span>
                    </div>
                    <input type="text" class="form-control" value="{{ $ticket->asunto ?? '' }}" name="asunto" required>
                </div>

                <!-- EL MENSAJE DEL TICKET -->
                <div class="form-group">
                    <textarea id="editor" name="mensaje" style="width: 100%"></textarea>

                    <!-- LOS ADJUNTOS DEL TICKET -->
                    <div class="form-group my-2">
                        <div class="btn btn-default btn-file">
                            <i class="fas fa-paperclip"></i> Adjuntar
                            <input type="file" name="adjuntos[]" class="subirAdjuntos" multiple>
                            <input type="hidden" name="adjuntos" class="archivosTemporales">
                        </div>
                        <p class="help-block small">Archivos con peso máximo de 32MB</p>
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <ul class="mailbox-attachments d-flex align-items-stretch clearfix"></ul>
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