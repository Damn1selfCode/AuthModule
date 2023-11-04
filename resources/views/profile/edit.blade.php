@vite('resources/css/app.css')
<div class=" col-12 col-md-4 ">
    <div class="bg-white p-6 rounded-lg shadow-md w-full">
        <div class="text-center">
            <img class="rounded-circle" width="150" height="150" src="{{ asset(Auth::user()->profile_image) }}"
                style="display: block; margin: 0 auto;">
            <!-- Contador de actualizaciones de imagen -->
            @if ($user->image !== null && $user->image->image_change_count < 6)
                <p>{{ 6 - $user->image->image_change_count }} Actualizaciones restantes </p>
            @endif
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                <input id="name" type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    name="name" value="{{ old('name') ?? $user->name }}" required autocomplete="name" autofocus>

                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email"
                    class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    name="email" value="{{ old('email') ?? $user->email }}" required autocomplete="email">

                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="current_password"
                    class="block text-sm font-medium text-gray-700">{{ __('Contraseña Actual') }}</label>
                <input id="current_password" type="password"
                    class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    name="current_password" autocomplete="current-password">
                @error('current_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="new_password"
                    class="block text-sm font-medium text-gray-700">{{ __('Nueva Contraseña') }}</label>
                <input id="new_password" type="password"
                    class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    name="new_password" autocomplete="new-password">
                @error('new_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="new_password_confirmation"
                    class="block text-sm font-medium text-gray-700">{{ __('Confirmar Nueva Contraseña') }}</label>
                <input id="new_password_confirmation" type="password"
                    class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    name="new_password_confirmation" autocomplete="new-password">
            </div>



            <!-- Campo de carga de imagen (mostrado solo si no se alcanza el límite) -->
            @if ($user->image === null || $user->image->image_change_count < 6)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">{{ __('Image') }}</label>
                    <div class="custom-file">
                        <input type="file" accept="image/*"
                            class="custom-file-input mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                            name="image">
                        <label class="custom-file-label"> Profile image----</label>
                    </div>
                </div>
            @endif

<div class="flex items-center justify-end">
    <button type="submit" 
        class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 focus:outline-none focus:bg-indigo-600"
        style="margin-right: 10px;">
        {{ __('Guardar') }}
    </button>

    <button type="button" class="btn btn-danger text-black" data-toggle="modal" data-target="#confirmModal">
        Desactivar Usuario
    </button>
</div>
        </form>


        <div class="modal fade text-black" id="confirmModal" tabindex="-1" role="dialog"
            aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="confirmModalLabel">Confirmar Desactivación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas desactivar este usuario?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-black"
                            data-dismiss="modal">Cancelar</button>
                        <form action="{{ route('profile.deactivate', ['user' => $user]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger text-black">Desactivar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>


{{--
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
--}}
