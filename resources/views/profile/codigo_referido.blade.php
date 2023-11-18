@vite('resources/css/app.css')
<div class=" col-12 col-md-4 ">
    <div class="bg-white p-6 rounded-lg shadow-md w-full">



        <div class="card-header">

            <h5 class="m-0 text-uppercase text-secondary">

                <strong>Codigo de Referido</strong>

            </h5>

        </div>

        <div class="card-body">

            <form method="post" action="">

                <div class="form-group">


                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="p-2 bg-info rounded-left">http://LearnStream.com/</span>
                        </div>
                        <input type="text" class="form-control" id="inputAfiliado" value="{{ $user->code }}"
                            readonly>
                    </div>

                    @if ($codRef == null)
                        <form action="{{ route('suscription.desuscribirse') }}" method="POST"
                            class="flex items-center">
                            @csrf
                            <input type="hidden" name="correo" value="{{ $user->email }}">
                            <input type="hidden" name="nombres" value="{{ $user->name }}">
                            <button type="submit"
                                class="btn btn-success text-black"><strong>Desuscribirse</strong></button>
                        </form>
                    @else
                        <form action="{{ route('suscription.desuscribirse') }}" method="POST"
                            class="flex items-center">
                            @csrf
                            <input type="hidden" name="correo" value="{{ $user->email }}">
                            <input type="hidden" name="nombres" value="{{ $user->name }}">
                            <button type="submit"
                                class="btn btn-success text-black"><strong>Desuscribirse</strong></button>
                        </form>
                    @endif

                </div>
            </form>
        </div>



    </div>

</div>
