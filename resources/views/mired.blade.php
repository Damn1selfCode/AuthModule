@extends('adminlte::page')

@section('title', 'Dashboard')


@section('content')


    <div class="content-wrapper" style="min-height: 1058.31px;">

        <!-- Mostrar mensajes -->
        @if (session()->has('success'))
            <div class="alert alert-success" id="success-message">
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger" id="error-message">
                {{ session('error') }}
            </div>
        @endif
        @if (session()->has('warning'))
            <div class="alert alert-warning" id="warning-message">
                {{ session('warning') }}
            </div>
        @endif

        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                <div id="summary" class="tree_main">
                    <ul id="organigrama">
                        @if (!empty($tree))
                            @include('red.partials.node', ['node' => $tree])
                        @endif
                    </ul>
                </div>
            </div>

        </section>
        <!-- /.content -->

    </div>

@stop



@section('js')

    <link rel="stylesheet" href="css/jquery.jOrgChart.css" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.jOrgChart.js"></script>
    {{-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script> --}}

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

        // Ocultar mensajes después de 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            hideMessage('success-message', 2500);
            hideMessage('error-message', 2500);
            hideMessage('warning-message', 2500);
        });

        var treeData = {!! json_encode($tree) !!};
        console.log(treeData);
        var orgchartData = {
            'data': treeData
        };

        // Inicializa jOrgChart
        $(document).ready(function() {
            $("#organigrama").jOrgChart({
                chartElement: "#organigrama",
                dragAndDrop: false,
            });
        });
    </script>

@endsection
