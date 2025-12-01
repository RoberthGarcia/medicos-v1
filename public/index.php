<?php

// Handle static files for PHP built-in server
if (php_sapi_name() === 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $url;
    if (is_file($file)) {
        return false;
    }
}

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controller\DirectorioController;
use Controller\MedicosController;
use Controller\LoginController;
use Controller\PanelMedicoController;

$router = new Router();

// --- PÚBLICAS ---
$router->get('/', [DirectorioController::class, 'index']);
$router->get('/directorio', [DirectorioController::class, 'index']);
$router->get('/medicos/buscar', [DirectorioController::class, 'buscar']);
$router->get('/medicos/perfil/{id}', [DirectorioController::class, 'perfil']);

// --- ADMIN ---
$router->get('/admin', [LoginController::class, 'login']);
$router->get('/admin/login', [LoginController::class, 'login']);
$router->post('/admin/login', [LoginController::class, 'login']);
$router->get('/admin/logout', [LoginController::class, 'logout']);
$router->get('/admin/dashboard', [MedicosController::class, 'index']);

$router->get('/admin/medicos', [MedicosController::class, 'index']);
$router->get('/admin/medicos/crear', [MedicosController::class, 'crear']);
$router->post('/admin/medicos/crear', [MedicosController::class, 'crear']);
$router->get('/admin/medicos/editar/{id}', [MedicosController::class, 'editar']);
$router->post('/admin/medicos/editar/{id}', [MedicosController::class, 'editar']);
$router->post('/admin/medicos/eliminar', [MedicosController::class, 'eliminar']);
$router->post('/admin/medicos/toggle', [MedicosController::class, 'toggle']);

// --- MEDICO PANEL ---
$router->get('/medicos/login', [PanelMedicoController::class, 'login']);
$router->post('/medicos/login', [PanelMedicoController::class, 'login']);
$router->get('/medicos/logout', [PanelMedicoController::class, 'logout']);
$router->get('/medicos/panel', [PanelMedicoController::class, 'dashboard']);
$router->get('/medicos/perfil/editar', [PanelMedicoController::class, 'editarPerfil']);
$router->post('/medicos/perfil/editar', [PanelMedicoController::class, 'editarPerfil']);

$router->get('/medicos/galeria', [PanelMedicoController::class, 'galeria']);
$router->post('/medicos/galeria/subir', [PanelMedicoController::class, 'subirImagen']);
$router->post('/medicos/galeria/eliminar', [PanelMedicoController::class, 'eliminarImagen']);

$router->get('/medicos/info-premium', [PanelMedicoController::class, 'infoPremium']);
$router->post('/medicos/info-premium', [PanelMedicoController::class, 'infoPremium']);

$router->comprobarRutas();
