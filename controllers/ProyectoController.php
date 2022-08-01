<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class ProyectoController
{


    public static function actualizar()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();

            $proyecto = Proyecto::where('url', $_POST['id']);

            if (!$proyecto || $proyecto->usuarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al borrar el proyecto'
                ];
                echo json_encode($respuesta);
                return;
            }

            $proyecto->proyecto=$_POST['nombre'];
            $resultado = $proyecto->guardar();
            if ($resultado) {
                $respuesta = [
                    'tipo' => 'exito',
                    'proyectoId' => $proyecto->id,
                    'mensaje' => 'Proyecto actualizado correctamente'
                ];
            }

            echo json_encode(['respuesta' => $respuesta]);
        }
    }

    public static function eliminar()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            session_start();

            $proyecto = Proyecto::where('url', $_POST['id']);

            if (!$proyecto || $proyecto->usuarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al borrar el proyecto'
                ];
                echo json_encode($respuesta);
                return;
            }

            $resultado=$proyecto->eliminar();
            if ($resultado) {
                $respuesta = [
                    'tipo' => 'exito',
                    'proyectoId' => $proyecto->id,
                    'mensaje' => 'Eliminado correctamente'
                ];
            }
            echo json_encode(['respuesta' => $respuesta]);
        }
    }
}