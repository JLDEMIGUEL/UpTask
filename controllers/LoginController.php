<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{

    public static function login(Router $router)
    {

        $alertas=[];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth=new Usuario($_POST);

            $alertas=$auth->validarLogin($auth->email, $auth->password);

            if(empty($alertas)){
                $usuario = Usuario::where('email',$auth->email);

                if(!$usuario){
                    Usuario::setAlerta('error','El usuario no existe');
                }else if($usuario->confirmado === 0){
                    Usuario::setAlerta('error','El usuario no está confirmado');
                }else{
                    if(password_verify($auth->password,$usuario->password)){
                       session_start();
                       $_SESSION['id']=$usuario->id;
                       $_SESSION['nombre']=$usuario->nombre;
                       $_SESSION['email']=$usuario->email;
                       $_SESSION['login']=true;

                       header('Location: /dashboard');
                    }else{
                        Usuario::setAlerta('error','Password incorrecto');
                    }
                }
            }

            $alertas=Usuario::getAlertas();

        }

        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas'=>$alertas
        ]);
    }

    public static function logout(Router $router)
    {
        session_start();
        $_SESSION=[];
        header('Location: /');
    }

    public static function crear(Router $router)
    {

        $usuario = new Usuario;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarCuentasNuevas();

            if (empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);
                if ($existeUsuario) {
                    Usuario::setAlerta('error', 'El usuario ya está registrado');
                    $alertas = Usuario::getAlertas();
                }else{
                    $usuario->hashPassword();

                    //Eliminar password2
                    unset($usuario->password2);

                    $usuario->generarToken();

                    $resultado=$usuario->guardar();

                    //Enviar email
                    $email= new Email($usuario->email,$usuario->nombre,$usuario->token);
                    $email->enviarConfirmacion();

                    if($resultado){
                        header('Location: /msgconf');
                    }
                }
            }
        }

        $router->render('auth/crear', [
            'titulo' => 'Crear Cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function passforgot(Router $router)
    {
        $alertas=[];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario=new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if(empty($alertas)){
                $usuario=Usuario::where('email',$usuario->email);

                if($usuario && $usuario->confirmado==="1"){
                    $usuario->generarToken();
                    unset($usuario->password2);

                    $usuario->guardar();

                    //Enviar email
                    $email= new Email($usuario->email,$usuario->nombre,$usuario->token);
                    $email->enviarCambioPassword();

                    //Imprimir alerta
                    Usuario::setAlerta('exito','Hemos enviado las instrucciones a tu email');
                }else{
                    Usuario::setAlerta('error','El usuario no existe o no está confirmado');
                }
                $alertas=Usuario::getAlertas();
            }
        }

        $router->render('auth/passforgot', [
            'titulo' => 'Olvidé password',
            'alertas'=>$alertas
        ]);
    }

    public static function passrecover(Router $router)
    {
        $mostrar=true;
        $token= s($_GET['token']);

        if(!$token) header('Location: /');

        $usuario= Usuario::where('token',$token);

        if(empty($usuario)){
            Usuario::setAlerta('error','Token no valido');
            $mostrar=false;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario= new Usuario($_POST);
            $alertas=$usuario->validarPassword();
            
            if(empty($alertas)){
                
                $usuario->hashPassword();

                $usuario->token=null;

                $resultado=$usuario->guardar();

                if($resultado){
                    header('Location: /');
                }
            }
        }

        $alertas=Usuario::getAlertas();
        $router->render('auth/passrecover', [
            'titulo' => 'Reestablecer password',
            'alertas'=>$alertas,
            'mostrar'=>$mostrar
        ]);
    }

    public static function msgconf(Router $router)
    {
        $router->render('auth/msgconf', [
            'titulo' => 'Confirma cuenta'
        ]);
    }

    public static function confirmacion(Router $router)
    {

        $token= s($_GET['token']);

        if(!$token) header('Location: /');

        $usuario= Usuario::where('token',$token);

        if(empty($usuario)){
            Usuario::setAlerta('error','Token no valido');
        }else{
            $usuario->confirmado=1;
            unset($usuario->password2);
            $usuario->token=null;

            $usuario->guardar();
            Usuario::setAlerta('exito','Cuenta confirmada correctamente');
        }
        $alertas=Usuario::getAlertas();

        $router->render('auth/confirmacion', [
            'titulo' => 'Cuenta confirmada',
            'alertas'=>$alertas
        ]);
    }
}
