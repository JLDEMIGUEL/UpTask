<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\TareaController;
use MVC\Router;
$router = new Router();

//Login
$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);
$router->get('/logout',[LoginController::class,'logout']);

//Crear cuenta
$router->get('/crear',[LoginController::class,'crear']);
$router->post('/crear',[LoginController::class,'crear']);


//Formulario olvidar cuenta
$router->get('/passforgot',[LoginController::class,'passforgot']);
$router->post('/passforgot',[LoginController::class,'passforgot']);

//Nuevo password
$router->get('/passrecover',[LoginController::class,'passrecover']);
$router->post('/passrecover',[LoginController::class,'passrecover']);

//Confirmacion cuenta
$router->get('/msgconf',[LoginController::class,'msgconf']);
$router->get('/confirmacion',[LoginController::class,'confirmacion']);


//Zona de proyectos
$router->get('/dashboard',[DashboardController::class,'index']);
$router->get('/crear-proyecto',[DashboardController::class,'crearProyecto']);
$router->post('/crear-proyecto',[DashboardController::class,'crearProyecto']);
$router->get('/proyecto',[DashboardController::class,'proyecto']);
$router->get('/perfil',[DashboardController::class,'perfil']);
$router->post('/perfil',[DashboardController::class,'perfil']);
$router->get('/cambiar-password',[DashboardController::class,'cambiarPassword']);
$router->post('/cambiar-password',[DashboardController::class,'cambiarPassword']);


//API tareas
$router->get('/api/tareas',[TareaController::class,'index']);
$router->post('/api/tarea',[TareaController::class,'crear']);
$router->post('/api/tarea/actualizar',[TareaController::class,'actualizar']);
$router->post('/api/tarea/eliminar',[TareaController::class,'eliminar']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();