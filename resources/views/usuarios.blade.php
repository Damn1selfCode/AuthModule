@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Perfil de Usuario</h1>
@stop

@section('content')

    <div class="content-wrapper" style="min-height: 1058.31px;">


        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">

                <div class="row">

                    @include('profile.edit')
                    @include('profile.form')
                    @include('profile.codigo_referido')
                </div>

            </div>

        </section>
        <!-- /.content -->

    </div>
@stop


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="{{ asset('js/usuarios.js') }}"></script>
@stop
@section('scripts')

@endsection
