<div class="card card-primary card-outline">

    <!--=====================================
	Header tickets
	======================================-->

    <div class="card-header">

        <h3 class="card-title">Leer Ticket</h3>

    </div>

    <!--=====================================
	Body tickets
	======================================-->

    <div class="card-body p-0">
        <div class="mailbox-read-info">

            <h5>Asunto: {{ $ticket->asunto }}</h5>

            <h6>
                <span class="mailbox-read-time">Fecha: {{ $ticket->fecha_soporte }}</span>
            </h6>
            <p>Remitente: {{ $ticket->remitenteRelacion->name }}</p>
            <p>Receptor: {{ $ticket->receptorRelacion->name }}</p>

        </div>
        <div class="mailbox-controls with-border text-center">

            <div class="btn-group">

                <form method="post" action="{{ url('/soporte/lectura-ticket/' . $ticket->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-default btn-sm" name="enviar_papelera" title="Enviar a Papelera">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>

                @if ($origen === 'recibidos')
                <a href="{{ route('soporte', ['responder_id' => $ticket->id]) }}">
                    <button type="button" class="btn btn-default"><i class="fa fa-reply" title="Responder" ></i> </button>
                </a>
                @elseif ($origen === 'enviados')
                <a href="{{ route('soporte', ['reenviar_id' => $ticket->id]) }}">
                    <button type="button" class="btn btn-default"><i class="fa fa-share" title="Reenviar"></i> </button>
                </a>
                @endif

            </div>

        </div>
        <div class="mailbox-read-message p-4">

            {!! html_entity_decode($ticket->mensaje) !!}

        </div>

    </div>
    <div class="card-footer bg-white">

        <ul class="mailbox-attachments clearfix">
            <h5>Adjuntos</h5>
            @if ($ticket->adjuntos)
            @foreach (json_decode($ticket->adjuntos) as $adjunto)
            @php
            $path_parts = pathinfo($adjunto);
            $file_extension = isset($path_parts['extension']) ? $path_parts['extension'] : '';
            $adjunto_path = "storage/{$adjunto}";
            @endphp

            <p>
                Archivo:<a href="{{ asset("storage/tickets/{$ticket->remitente}/{$path_parts['basename']}") }}" download>
                    {{ $path_parts['basename'] }}
                </a>
            </p>
            @endforeach
            @else
            <p>No hay archivos adjuntos.</p>
            @endif

        </ul>
        <!--  <div class="float-right">
            @if ($origen === 'recibidos')
            <a href="#">
                <button type="button" class="btn btn-default"><i class="fa fa-reply"></i> Responder</button>
            </a>
            @elseif ($origen === 'enviados')
            <a href="#">
                <button type="button" class="btn btn-default"><i class="fa fa-share"></i> Reenviar</button>
            </a>
            @endif
        </div>-->
        <div class="float-right">
            @if ($origen === 'recibidos')
            <a href="{{ route('soporte', ['responder_id' => $ticket->id]) }}">
                <button type="button" class="btn btn-default"><i class="fa fa-reply"></i> Responder</button>
            </a>
            @elseif ($origen === 'enviados')
            <a href="{{ route('soporte', ['reenviar_id' => $ticket->id]) }}">
                <button type="button" class="btn btn-default"><i class="fa fa-share"></i> Reenviar</button>
            </a>
            @endif
        </div>



    </div>