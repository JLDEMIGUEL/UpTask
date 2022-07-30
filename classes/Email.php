<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '2d4af3ba87bfd8';
        $mail->Password = '1aafa1be8167dd';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com');

        $mail->Subject='Confirma tu cuenta';

        $mail->isHTML(TRUE);
        $mail->CharSet='UTF-8';

        $contenido='<html>';
        $contenido.="<p><strong>Hola ".$this->nombre."</strong>, has creado tu cuenta en UpTask. 
        Debes confirmarla accediendo al siguiente enlace</p>";
        $contenido.="<p>Pulse aquí: <a href='http://localhost:3000/confirmacion?token=".$this->token."'>Confirmar cuenta</a></p>";
        $contenido.="<p>Si no creaste esta cuenta, ignora el mensaje.</p>";
        $contenido.='</html>';

        $mail->Body=$contenido;

        $mail->send();

    }

    public function enviarCambioPassword(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '2d4af3ba87bfd8';
        $mail->Password = '1aafa1be8167dd';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com');

        $mail->Subject='Cambia tu password';
        
        $mail->isHTML(TRUE);
        $mail->CharSet='UTF-8';


        $contenido='<html>';
        $contenido.="<p><strong>Hola ".$this->nombre."</strong>, puedes cambiar tu password accediendo al siguiente enlace</p>";
        $contenido.="<p>Pulse aquí: <a href='http://localhost:3000/passrecover?token=".$this->token."'>Cambiar password</a></p>";
        $contenido.="<p>Si pediste cambio de password, ignora el mensaje.</p>";
        $contenido.='</html>';

        $mail->Body=$contenido;

        $mail->send();
    }
}
