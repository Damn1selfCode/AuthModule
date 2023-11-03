@extends('adminlte::page')

@section('title', 'Dashboard')
@section('content')

<div class="content-wrapper" style="max-width: 100%; margin: 0 auto;">


    <!-- Main content -->
    <section class="content" >

        <div class="container-fluid"  >
            @include('home.vistasrecuadros')
            @include('home.vistas')

        </div>

    </section>
    <!-- /.content -->

</div>
@stop


@section('css')
<link rel="stylesheet" href="{{ asset('academy_css/style.css') }}">

@stop

@section('js')
<script>
  
</script>
@stop
@section('scripts')
<script src="{{ mix('js/paises.json') }}"></script>
@endsection