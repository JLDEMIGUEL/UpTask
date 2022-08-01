<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController
{
    public static function index()
    {

        $proyectoId = $_GET['id'];
        if (!$proyectoId) header('Location: /dashboard');

        $proyecto = Proyecto::where('url', $proyectoId);

        session_start();
        if (!$proyecto || $proyecto->usuarioId !== $_SESSION['id']) header('Location: /404');

        $tareas = Tarea::allWhere('proyectoId', $proyecto->id);

        echo json_encode([
            'tareas' => $tareas
        ]);
    }
    public static function crear()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();

            $proyecto = Proyecto::where('url', $_POST['proyectoId']);

            if (!$proyecto || $proyecto->usuarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al agregar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            }

            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $tarea->fecha=date('Y-m-d');
            $resultado = $tarea->guardar();
            $respuesta = [
                'tipo' => 'exito',
                'mensaje' => 'Tarea agregada correctamente',
                'id' => $resultado['id'],
                'proyectoId' => $proyecto->id,
                'fecha'=>$tarea->fecha
            ];
            echo json_encode($respuesta);
        }
    }
    public static function actualizar()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();

            $proyecto = Proyecto::where('url', $_POST['proyectoId']);

            if (!$proyecto || $proyecto->usuarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al agregar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            }

            $tarea = Tarea::find($_POST['id']);
            $tarea->nombre=$_POST['nombre'];
            $tarea->estado=$_POST['estado'];

            $resultado = $tarea->guardar();
            if ($resultado) {
                $respuesta = [
                    'tipo' => 'exito',
                    'id' => $tarea->id,
                    'proyectoId' => $proyecto->id,
                    'mensaje' => 'Tarea actualizada correctamente'
                ];
            }

            echo json_encode(['respuesta' => $respuesta]);
        }
    }

    public static function eliminar()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            session_start();

            $proyecto = Proyecto::where('url', $_POST['proyectoId']);

            if (!$proyecto || $proyecto->usuarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al agregar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            }

            $tarea = new Tarea($_POST);

            $resultado=$tarea->eliminar();

            if ($resultado) {
                $respuesta = [
                    'tipo' => 'exito',
                    'id' => $tarea->id,
                    'proyectoId' => $proyecto->id,
                    'mensaje' => 'Eliminado correctamente'
                ];
            }
            echo json_encode(['respuesta' => $respuesta]);
        }
    }
}
