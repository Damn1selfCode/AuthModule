@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')

    <div class="content-wrapper" style="min-height: 1058.31px;">

        <!-- Mostrar mensaje de éxito -->
        @if (session('success'))
            <div class="alert alert-success" id="success-message">
                {{ session('success') }}
            </div>
        @endif
        <!-- Mostrar mensaje de error -->
        @if (session('error'))
            <div class="alert alert-danger" id="error-message">
                {{ session('error') }}
            </div>
        @endif

        <!-- Mostrar mensaje de advertencia -->
        @if (session('warning'))
            <div class="alert alert-warning" id="warning-message">
                {{ session('warning') }}
            </div>
        @endif
        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                Hola
                {{-- <div class="row">
                    @include('red.redSubs')
                </div> --}}

            </div>

        </section>
        <!-- /.content -->

    </div>
@stop


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

    <script>
        // Función para ocultar mensajes después de un tiempo
        function hideMessage(messageId, duration) {
            setTimeout(function() {
                var message = document.getElementById(messageId);
                if (message) {
                    message.style.display = 'none';
                }
            }, duration);
        }

        // Ocultar el mensaje de éxito después de 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            hideMessage('success-message', 2500);
            hideMessage('error-message', 2500);
            hideMessage('warning-message', 2500);
        });
    </script>
@stop

@section('scripts')

@endsection
