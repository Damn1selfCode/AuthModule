@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1 style="text-align: center;">Soporte</h1>
<style>
        .content {
            padding: 50px;
        }

        .content {
            padding-bottom: 145px;
        }
    </style>
@stop

@section('content')

<div class="content-wrapper" style="max-width: 100%; margin: 0 auto;">


    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">

            <div class="content" name="">
                <div class="row">
                    <div class="col-md-3">
                    @include('soporte.botones')
                   

                    </div>
                    <div class="col-md-9">
                    @include('soporte.nuevo-ticket')
                   
                  
                    </div>

                </div>
            </div>

        </div>

    </section>
   

    <!-- /.content -->

</div>
@stop


@section('css')
<link rel="stylesheet" href="{{ asset('academy_css/style.css') }}">
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<!-- DataTables Bootstrap 4 CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

<!-- DataTables Responsive CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">

@stop

@section('js')
<script src="{{ asset('soportejs/ckeditor.js') }}"></script>
<script src="{{ asset('soportejs/soporte.js') }}"></script>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<!-- DataTables Bootstrap 4 JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<!-- DataTables Responsive JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>

<!-- Alertas -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stop
@section('scripts')
@endsection