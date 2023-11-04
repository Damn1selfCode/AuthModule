@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1 style="text-align: center;">Material de promoción</h1>
@stop

@section('content')

<div class="content-wrapper" style="max-width: 100%; margin: 0 auto;">


  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">

      @include('promocion.material')

    </div>

  </section>
  <!-- /.content -->

</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('academy_css/style.css') }}">
@stop

@section('js')
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
    <script>
      var elem = document.querySelector(".grid");
      var msnry = new Masonry(elem, {
        // options
        itemSelector: ".white-panel",
        columnWidth: 400,
        gutter: 20,
        isFitWidth: true
      });
    </script>
@stop
@section('scripts')

@endsection