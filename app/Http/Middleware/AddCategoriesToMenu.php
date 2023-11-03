<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Academy;
use Illuminate\Support\Facades\Config;

class AddCategoriesToMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    //copiar esto
    public function handle(Request $request, Closure $next): Response
    {
        $categoriaModel = new Academy();
        $categorias = $categoriaModel->getCategorias();

        $menu = Config::get('adminlte.menu'); // Obtén la configuración del menú

        foreach ($menu as &$menuItem) {
            if (isset($menuItem['text']) && $menuItem['text'] === 'Academia') {
                foreach ($categorias as $categoria) {
                    $ruta = '/' . $categoria->ruta_categoria;
                    $menuItem['submenu'][] = [
                        'text' => $categoria->nombre_categoria,
                        'url' => route('academy', ['ruta_categoria' => $categoria->ruta_categoria]), // Usa la ruta 'academy' y pasa la ruta de la categoría como parámetro
                        'icon' => $categoria->icono_categoria,
                    ];
                }
                break;
            }
        }

        Config::set('adminlte.menu', $menu); // Actualiza la configuración del menú

        return $next($request);
    }
}
