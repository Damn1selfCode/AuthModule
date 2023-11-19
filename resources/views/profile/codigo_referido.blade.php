@vite('resources/css/app.css')
@php
    $action = $codRef == null ? route('codigo.generar') : route('codigo.actualizar');
    $botonDescripcion = $codRef == null ? 'Generar' : 'Actualizar';
    $codigopriv = strtoupper(
        implode(
            '',
            array_map(function ($word) {
                return $word[0];
            }, explode(' ', $user->name)),
        ),
    );

@endphp

@if ($suscripcion == 1)
    <div class=" col-12 col-md-12 "style="padding-top: 20px;">
        <div class="bg-white p-6 rounded-lg shadow-md w-full">



            <div class="card-header">

                <h5 class="m-0 text-uppercase text-secondary">

                    <strong>Mi Codigo de Referido</strong>

                </h5>

            </div>

            <div class="card-body">

                <form method="POST" class="flex items-center" method="POST" action="{{ $action }}">
                    @csrf
                    <input type="hidden" name="user" value="{{ $user }}">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="p-2 bg-info rounded-left">
                                http://LearnStream.com/
                            </span>
                            <input type="text" class="form-control" name="codigorefpriv" value="{{ $codigopriv }}"
                                style="width: 150px !important;" readonly>

                        </div>

                        <input type="text" class="form-control" name="codigorefpub"
                            value="{{ $codRef === null ? '' : $codRef->codigopublico }}"
                            placeholder="Ingresa el codigo que deseas usar">

                        <button type="submit" class="btn btn-success text-black">
                            <strong>
                                {{ $botonDescripcion }}
                            </strong>
                        </button>
                    </div>



                </form>

            </div>



        </div>

    </div>
@endif
