<?php
require "./bibliotecas/PHPMailer/Exception.php";
require "./bibliotecas/PHPMailer/OAuth.php";
require "./bibliotecas/PHPMailer/PHPMailer.php";
require "./bibliotecas/PHPMailer/POP3.php";
require "./bibliotecas/PHPMailer/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mensagem {
    private $para = null;
    private $assunto = null;
    private $mensagem = null;

    public function __get($attr) {
       return $this->$attr;
    }

    public function __set($attr, $valor) {
        $this->$attr = $valor;
    }

    public function mensagemValida() {
        //a function nativa do PHP empty() verifica se existe algum valor na variavel
        if(empty($this->para) || empty($this->assunto || empty($this->mensagem))) {
            return false;
        }

        return true;
    }
}

$mensagem = new Mensagem();

$mensagem->__set('para', $_POST['para']);
$mensagem->__set('assunto', $_POST['assunto']);
$mensagem->__set('mensagem', $_POST['mensagem']);

// se a mesnagem não for válida entra no if abaixo, enterrompendo o script
if(!$mensagem->mensagemValida()) {
    echo 'mensagem não é válida';
    die(); //esta function nativa do PHP mata o processamento do script
} 

//Cria uma instância; passando`true` habilitando exceções
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'webcompleto2@gmail.com';                     //SMTP username
    $mail->Password   = '!@#$4321';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       =587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('webcompleto2@gmail.com', 'Web completo remetente');
    $mail->addAddress('webcompleto2@gmail.com', 'Web completo destinatário');     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information'); //contato padrão caso o destinatário deseje responder o remetente
    //$mail->addCC('cc@example.com'); //adiciona destinatário de copia
    //$mail->addBCC('bcc@example.com'); //adiciona copia oculta

    //Attachments / anexos
   // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Olá! eu sou o assunto';
    $mail->Body    = 'Olá! eu sou o conteúdo do <b>e-mail!</b>';
    $mail->AltBody = 'Olá! eu sou o conteúdo do e-mail!';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Não foi possível enviar este e-mail! Por favor tente novamente mais tarde. Detalhes do erro: {$mail->ErrorInfo}";
}
?>