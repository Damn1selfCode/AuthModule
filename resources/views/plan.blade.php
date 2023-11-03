@extends('adminlte::page')

@section('title', 'Dashboard')
@section('content')

<div class="content-wrapper" style="max-width: 100%; margin: 0 auto;">
    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            @include('plan.diapo')
            @include('plan.videos')


        </div>

    </section>
    <!-- /.content -->

</div>
@stop




@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            items: 2,
            loop: true,
            autoplay: true,
            autoplayTimeout: 700, // Tiempo de cada diapositiva en milisegundos
            autoplayHoverPause: true, // Pausar en el hover
        });
    });
</script>
@stop
@section('scripts')

@endsection