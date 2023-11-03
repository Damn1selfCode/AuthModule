@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Perfil</h1>
@stop

@section('content')
  
<div class="content-wrapper" style="min-height: 1058.31px;">


  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">

      <div class="row">
        
        @include('profile.edit')
        @include('profile.form')
        @include('profile.content')
      

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
 <!-- /.content <script src="{{ asset('forrmjs/paises.json') }}"></script>-->

@stop
@section('scripts')
  
@endsection
