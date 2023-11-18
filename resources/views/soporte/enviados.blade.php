<div class="card card-primary card-outline">

    <!--=====================================
	Header tickets
	======================================-->
    <div class="card-header pb-3">

        <h3 class="card-title">Tickets Enviado</h3>

        <div class="card-tools">

            <div class="mailbox-controls pb-4">

                <button type="button" class="btn btn-default btn-sm checkbox-toggle" id="seleccionarTodo">
                    <i class="far fa-square"></i>
                </button>

                <div class="btn-group">

                    <a href="#" id="btnEnviarPapelera">
                        <button type="button" class="btn btn-default btn-sm btnPapelera" data-toggle="tooltip" title="Enviar a papelera">
                            <i class="fas fa-trash"></i>
                        </button>
                    </a>

                </div>

                <a href="" class="btn btn-default btn-sm">

                    <i class="fas fa-sync-alt"></i>

                </a>

            </div>

        </div>

    </div>

    <!--=====================================
	Body tickets
	======================================-->

    <!-- enviados.blade.php -->

    <div class="card-body p-3 mailbox-messages">

        <input type="hidden" class="tipoTicket" value="enviados">
        <input type="hidden" class="idUsuario" value="{{ auth()->id() }}">

        <table class="table table-striped dt-responsive tablaTickets" width="100%">

            <thead>

                <tr>
                    <th>Seleccionar</th>
                    <th>Receptor</th> <!-- Cambiado a Receptor en lugar de Remitente -->
                    <th>Asunto</th>
                    <th>Adjunto</th>
                    <th>Fecha y hora</th>
                </tr>

            </thead>
            <tbody>
                @foreach ($ticketsEnviados as $ticket)
                <tr>
                    <td><input type="checkbox" class="checkboxSeleccionar" value="{{ $ticket->id }}"></td>
                    <td>
                        <a href="{{ route('soporte.lectura-ticket', ['id' => $ticket->id, 'origen' => 'enviados']) }}" class="ver-ticket" data-origen="enviados" data-id="{{ $ticket->id }}">
                            {{ $ticket->receptorRelacion->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('soporte.lectura-ticket', ['id' => $ticket->id, 'origen' => 'enviados']) }}" class="ver-ticket" data-origen="enviados" data-id="{{ $ticket->id }}">
                            {{ $ticket->asunto }}
                        </a>
                    </td>
                    <td>
                        @if (!empty($ticket->adjuntos) && json_decode($ticket->adjuntos))
                        <i class="fas fa-paperclip"></i>
                        @else
                        <i class="fas fa-times"></i>
                        @endif
                    </td>

                    <td>{{ $ticket->fecha_soporte }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<script>
    $(document).ready(function() {
        // DataTable initialization
        var tabla = $('.tablaTickets').DataTable({
            responsive: true,
            // Otros parámetros y opciones según tus necesidades
        });

        // Evento de clic para el botón "Seleccionar todo"
        $('#seleccionarTodo').on('click', function() {
            // Alternar la selección/deselección de todos los checkboxes en la tabla
            var checkboxes = $('.tablaTickets tbody tr').find('.checkboxSeleccionar');
            checkboxes.prop('checked', !checkboxes.prop('checked'));
        });

        // ...

        // Evento de clic para el botón "Enviar a papelera"
        $('#btnEnviarPapelera').on('click', function() {
            // Obtener los IDs de los tickets seleccionados
            var idsSeleccionados = [];
            $('.tablaTickets tbody tr').each(function() {
                var checkbox = $(this).find('.checkboxSeleccionar');
                if (checkbox.prop('checked')) {
                    idsSeleccionados.push(checkbox.val());
                }
            });

            // Mostrar un cuadro de diálogo de confirmación
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción enviará los tickets seleccionados a la papelera.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, enviar a papelera',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Configurar jQuery para incluir automáticamente el token CSRF en todas las solicitudes AJAX
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // Luego, tus solicitudes AJAX no necesitarán incluir explícitamente el token CSRF
                    $.ajax({
                        method: 'POST',
                        url: '/soporte/enviar-a-papelera',
                        data: {
                            ids: idsSeleccionados
                        },
                        success: function(response) {
                            // Mostrar el mensaje de éxito con SweetAlert2
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: response.message,
                                    timer: 5000,
                                    showConfirmButton: false
                                });
                            }

                            // Redirigir a la vista de soporte
                            window.location.href = '/soporte';
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                }
            });
        });
    });
</script>