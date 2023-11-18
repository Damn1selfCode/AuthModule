<div class="card card-primary card-outline">
    <!--=====================================
	Header tickets
	======================================-->

    <div class="card-header pb-3">

        <h3 class="card-title">Tickets  en Papelera</h3>

        <div class="card-tools">

            <div class="mailbox-controls pb-4">

                <button type="button" class="btn btn-default btn-sm checkbox-toggle" id="seleccionarTodo">
                    <i class="far fa-square"></i>
                </button>


                <div class="btn-group">

                    <a href="#" id="btnrecuperarpapelera">
                        <button type="button" class="btn btn-default btn-sm btnPapelera" data-toggle="tooltip" title="Recuperar papelera">
                            <i class="fas fa-recycle"></i>
                        </button>
                    </a>

                </div>

                <a href="" class="btn btn-default btn-sm">

                    <i class="fas fa-sync-alt"></i>

                </a>

            </div>

        </div>

    </div>
    <div class="card-body p-3 mailbox-messages">
        <table class="table table-striped dt-responsive tablaTickets" width="100%">
            <thead>
                <tr>
                    <th>Seleccionar</th>
                    <th>Remitente</th>
                    <th>Receptor</th>
                    <th>Asunto</th>
                    <th>Adjunto</th>
                    <th>Fecha y hora</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ticketsPapelera as $ticket)
                <tr>
                    <td><input type="checkbox" class="checkboxSeleccionar" value="{{ $ticket->id }}"></td>
                    <td>{{ $ticket->remitenteRelacion->name }}</td>
                    <td>{{ $ticket->receptorRelacion->name }}</td>
                    <td>{{ $ticket->asunto }}</td>
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

        // Evento de clic para el botón "Recuperar papelera"
        $('#btnrecuperarpapelera').on('click', function() {
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
                text: 'Esta acción recuperará los tickets de la papelera.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, recuperar',
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
                        url: '/soporte/recuperar-de-papelera', // Asegúrate de que esta URL coincida con tu ruta
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

                            // Recargar la página o actualizar la tabla según tus necesidades
                            location.reload();
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