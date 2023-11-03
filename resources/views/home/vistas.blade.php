<div class="content-wrapper" style="margin: 0 auto;">
    <section class="content">
        <div class="container-fluid">
            @if (isset($categorias))
                @foreach ($categorias as $categoria)
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <a href="{{ route('home') }}" class="text-muted">
                                <i class="{{ $categoria->icono_categoria }} text-info"></i>
                                {{ $categoria->nombre_categoria }}
                            </a>
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="jd-slider slideAcademia">
                            <div class="slide-inner">
                                <ul class="slide-area" style="display: flex; list-style-type: none; padding: 0; overflow-x: auto;">
                                    @foreach ($categoria->videos as $video)
                                    <li style="flex: 0 0 auto; margin-right: 10px; width: 300px;">
                                        <a href="{{ route('usuarios') }}">
                                            <figure class="px-4
                                            @if ($suscripcion == 0)
                                                @if ($video->vista_gratuita == 1)
                                                    activado
                                                @else
                                                    desactivado
                                                @endif
                                            @else
                                                activado
                                            @endif">
                                                <img src="{{ url('img/' . $categoria->ruta_categoria . '/' . $video->imagen_video) }}" style="max-width: 100%; height: auto;">
                                            </figure>
                                            <h6 class="text-center text-secondary">
                                                {{ $video->titulo_video }}
                                            </h6>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                <a class="prev" href="#">
                                    <i class="fas fa-angle-left text-muted"></i>
                                </a>
                                <a class="next" href="#">
                                    <i class="fas fa-angle-right text-muted"></i>
                                </a>
                            </div>
                            <div class="controller">
                                <div class="indicate-area"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </section>
</div>
