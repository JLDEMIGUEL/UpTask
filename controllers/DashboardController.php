<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController
{
    public static function index(Router $router)
    {
        session_start();

        isAuth();

        $id=$_SESSION['id'];

        $proyectos=Proyecto::allWhere('usuarioId',$id);
        

        $router->render('dashboard/index', [
            'titulo'=>'Proyectos',
            'proyectos'=>$proyectos
        ]);
    }

    public static function crearProyecto(Router $router)
    {
        session_start();
        isAuth();

        $alertas=[];

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $proyecto = new Proyecto($_POST);

            $alertas=$proyecto->validarProyecto();

            if(empty($alertas)){
                $proyecto->url=md5(uniqid());

                $proyecto->usuarioId=$_SESSION['id'];

                $proyecto->guardar();

                header('Location: /proyecto?id='.$proyecto->url);
            }
        }

        $router->render('dashboard/crear-proyecto', [
            'titulo'=>'Crear Proyecto',
            'alertas'=>$alertas
        ]);
    }

    public static function proyecto(Router $router)
    {
        session_start();

        isAuth();

        $url=$_GET['id'];
        if(!$url)header('Location: /dashboard');

        $proyecto = Proyecto::where('url',$url);

        if($_SESSION['id'] !== $proyecto->usuarioId) header('Location: /dashboard');

        $router->render('dashboard/proyecto', [
            'titulo'=> $proyecto->proyecto
        ]);
    }

    public static function perfil(Router $router)
    {
        session_start();

        isAuth();

        $alertas=[];

        $usuario=Usuario::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $usuario->sincronizar($_POST);
            $alertas=$usuario->validarPerfil();
            
            if(empty($alertas)){

                $existeUsuario = Usuario::where('email', $usuario->email);
                if ($existeUsuario && $existeUsuario->id!==$usuario->id) {
                    Usuario::setAlerta('error', 'El usuario ya está registrado');
                    $alertas = Usuario::getAlertas();
                }else{
                    $usuario->guardar();

                    $_SESSION['nombre']=$usuario->nombre;
    
                    Usuario::setAlerta('exito','Guardado correctamente');
                    $alertas=Usuario::getAlertas();
                }

            }
        }

        $router->render('dashboard/perfil', [
            'titulo'=>'Perfil',
            'usuario'=>$usuario,
            'alertas'=>$alertas
        ]);
    }


    
    public static function cambiarPassword(Router $router)
    {
        session_start();

        isAuth();

        $alertas=[];


        if($_SERVER['REQUEST_METHOD']==='POST'){
            $usuario=Usuario::find($_SESSION['id']);
            

            $usuario->sincronizar($_POST);

            $alertas=$usuario->validarNuevoPassword();

            if(empty($alertas)){
                if($usuario->comprobarPassword()){
                    $usuario->password=$usuario->password_nuevo;

                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);

                    $usuario->hashPassword();
                    $resultado=$usuario->guardar();

                    if($resultado){
                        Usuario::setAlerta('exito','Password guardado correctamente');
                        $alertas=Usuario::getAlertas();
                    }
                }else{
                    Usuario::setAlerta('error','Password incorrecto');
                    $alertas=Usuario::getAlertas();
                }
            }
        }

        $router->render('dashboard/cambiar-password', [
            'titulo'=>'Cambiar Password',
            'alertas'=>$alertas
        ]);
    }

}
