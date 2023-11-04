@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1 style="text-align: center;">Academia</h1>
@stop

@section('content')

<div class="content-wrapper" style="max-width: 100%; margin: 0 auto;">


  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">


      @include('home.vistas')
      @include('academy.videos')


    </div>

  </section>
  <!-- /.content -->

</div>
@stop


@section('css')
<link rel="stylesheet" href="{{ asset('academy_css/style.css') }}">
@stop

@section('js')

@stop
@section('scripts')

@endsection