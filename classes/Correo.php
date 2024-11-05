<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Correo
{
    protected $nombre;
    protected $apellido;
    protected $correo;
    protected $token;

    public function __construct($nombre, $apellido, $correo, $token)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'e41dc0edff6dc5';
        $mail->Password = '3677fc64fc6710';

        $mail->setFrom($this->correo);
        $mail->addAddress('partinicukakarot9155@gmail.com', 'DevWebCamp.com');
        $mail->Subject = 'Confirme su cuenta';

        // Set de HTML.
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p>¡Hola administrador! <b> " . $this->nombre . " " . $this->apellido . " </b> ha solicitado crear su cuenta en DevWebCamp, para confirmarla ingrese al siguiente enlace</p>";
        $contenido .= "<p>Haga clic aquí: <a href='http://localhost:3000/confirmar_cuenta?token=" . $this->token . "'>Confirmar cuenta</a></p>";
        $contenido .= "<p>Si usted no está en acuerdo con la creación de la cuenta, puede ignorar este mensaje.</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // Enviar el email.
        $mail->send();
    }

    public function enviarInstrucciones()
    {
        // Crear el objeto de correo.
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'e41dc0edff6dc5';
        $mail->Password = '3677fc64fc6710';

        $mail->setFrom($this->correo);
        $mail->addAddress('partinicukakarot9155@gmail.com', 'DevWebCamp.com');
        $mail->Subject = 'Reestablezca su contraseña';

        // CUANDO SE MANDA AUTOMÁTICAMENTE EL CORREO AL USUARIO PARA QUE CONFIRME.
        // $mail->setFrom('devwebcamp@no_reply.com');
        // $mail->addAddress($this->correo, $this->nombre);

        // Set de HTML.
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p>¡Hola administrador! <b> " . $this->nombre . " " . $this->apellido . " </b> ha solicitado reestablecer su contraseña en DevWebCamp, para confirmar ingrese al siguiente enlace</p>";
        $contenido .= "<p>Haga clic aquí: <a href='http://localhost:3000/reestablecer?token=" . $this->token . "'>Reestablecer contraseña</a></p>";
        $contenido .= "<p>Si usted no está en acuerdo con la recuperación de la cuenta, puede ignorar este mensaje.</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // Enviar el email.
        $mail->send();
    }
}
