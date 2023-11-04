<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use App\Http\Controllers\ImageController;
use App\Models\Image; // Aseg?rate de que la ruta y el namespace sean correctos
use App\Models\User; // Ajusta el espacio de nombres seg?n la ubicaci?n correcta
use App\Notifications\DisableUserNotification;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }


    public function editBK(Request $request)
    { //ruta a la vista
        return view('profile.edit')->with([
            'user' => $request->user(),
        ]);
    }
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
public function updateBK(ProfileRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $user = $request->user();

            // Verificar la contrase?a actual
            if (!empty($request->current_password) && !Hash::check($request->current_password, $user->password)) {
                return redirect()
                    ->back()
                    ->withErrors(['current_password' => 'Current password is incorrect.'])
                    ->withInput();
            }

            $user->fill($request->validated());

            // Condici?n del email
            if ($user->isDirty('email')) {
                // Verificaci?n nula
                $user->email_verified_at = null;
                // Nueva verificaci?n
                $user->sendEmailVerificationNotification();
            }

            // Cambiar contrase?a
            if (!empty($request->new_password)) {
                $user->password = Hash::make($request->new_password);

                // Verificaci?n nula para la contrase?a
                $user->email_verified_at = null;

                // Enviar notificaci?n de verificaci?n por correo electr?nico
                $user->sendEmailVerificationNotification();
            }

            // Guardar datos
            $user->save();

            // Verificar si hay un archivo
            if ($request->hasFile('image')) {
                // Obtener la imagen actual del usuario a trav?s de la relaci?n
                $currentImage = $user->image;

                // Verificar si se ha alcanzado el l?mite de cambios de imagen (6 veces)
                if ($currentImage !== null && $currentImage->image_change_count < 6) {
                    // Ya tiene imagen
                    // Borrar imagen anterior
                    Storage::disk('images')->delete($currentImage->path);
                    // Actualizar la imagen existente
                    $currentImage->path = $request->image->store('users', 'images');
                    $currentImage->image_change_count++;
                    $currentImage->save();
                } elseif ($currentImage === null) {
                    // Si no tiene imagen, crear una nueva
                    $user->image()->create([
                        'path' => $request->image->store('users', 'images'),
                        'image_change_count' => 1,
                    ]);
                } else {
                    return redirect()
                        ->back()
                        ->withErrors(['image' => 'You can only change your profile image 6 times.'])
                        ->withInput();
                }
            }

            return redirect()
                ->route('usuarios')
                ->withSuccess('Profile edited');
        }, 5);
    }
    public function deactivate(User $user)
    {
        $user->delete(); // Esto establecer? la fecha y hora de eliminaci?n en 'deleted_at'

        // Puedes agregar redirecciones o respuestas aqu?, por ejemplo:
        return redirect()->back()->with('success', 'Usuario desactivado correctamente.');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
