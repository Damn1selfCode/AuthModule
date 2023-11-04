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
<!-- Agrega el enlace CDN a Video.js en tu vista Blade -->
<link href="https://vjs.zencdn.net/7.15.4/video-js.css" rel="stylesheet">
@stop

@section('js')
<!-- Agrega el enlace CDN a Video.js en tu vista Blade -->
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
@stop
@section('scripts')

@endsection