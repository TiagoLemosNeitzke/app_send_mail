<?php
require "./bibliotecas/PHPMailer/Exception.php";
require "./bibliotecas/PHPMailer/OAuth.php";
require "./bibliotecas/PHPMailer/PHPMailer.php";
require "./bibliotecas/PHPMailer/POP3.php";
require "./bibliotecas/PHPMailer/SMTP.php";

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

//print_r($mensagem);

if($mensagem->mensagemValida()) {
    echo 'mensagem é válida';
} else {
    echo 'mensagem inválida';
}
?>