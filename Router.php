<?php

namespace MVC;

class Router
{
    private $rutasGET = [];
    private $rutasPOST = [];

    public function get($url, $callback)
    {
        $this->rutasGET[$url] = $callback;
    }

    public function post($url, $callback)
    {
        $this->rutasPOST[$url] = $callback;
    }

    public function comprobarRutas()
    {
        $metodo = $_SERVER['REQUEST_METHOD'];

        // Robust URL detection:
        // 1. Try PATH_INFO (works for php -S with index.php)
        // 2. Try parsing REQUEST_URI path (works if PATH_INFO is missing)
        // 3. Fallback to /
        $url = $_SERVER['PATH_INFO'] ?? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

        // Ensure no query string remains (just in case)
        if (strpos($url, '?') !== false) {
            $url = explode('?', $url)[0];
        }

        if ($metodo === 'GET') {
            $callback = $this->rutasGET[$url] ?? null;
        } else {
            $callback = $this->rutasPOST[$url] ?? null;
        }

        // Support for dynamic routes
        if (!$callback) {
            foreach (($metodo === 'GET' ? $this->rutasGET : $this->rutasPOST) as $ruta => $fn) {
                if (strpos($ruta, '{') !== false) {
                    $patron = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $ruta);
                    $patron = "@^" . $patron . "$@";

                    if (preg_match($patron, $url, $coincidencias)) {
                        array_shift($coincidencias);
                        $callback = $fn;
                        call_user_func_array($callback, $coincidencias);
                        return;
                    }
                }
            }
        }

        if ($callback) {
            call_user_func($callback, $this);
        } else {
            echo "404 - Página no encontrada";
        }
    }

    public function render($view, $datos = [])
    {
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean();

        include_once __DIR__ . "/views/layout.php";
    }
}
