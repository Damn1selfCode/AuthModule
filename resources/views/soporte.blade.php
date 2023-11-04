@extends('adminlte::page')

@section('title', 'Dashboard')
@section('content')

<div class="content-wrapper" style="max-width: 100%; margin: 0 auto;">


    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="content">
                <div class="row">
                    <div class="cold-md-3">
                        @include('soporte.botones')

                    </div>
                    <div class="cold-md-9">

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

@stop

@section('js')
<script src="{{ asset('soportejs/ckeditor.js') }}"></script>
<script src="{{ asset('soportejs/soporte.js') }}"></script>
@stop
@section('scripts')

@endsection