<?php
include('../Php/conexao.php');
require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$etapa1 = true;
$etapa2 = false;
$etapa3 = false;

if (isset($_POST['submit']) && isset($_POST['email'])) {
    $email = $_POST['email'];

    $sql = "SELECT * FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {

        $codigo_seguranca = rand(100000, 999999);

        $assunto = "Código de Segurança para Recuperação de Senha";
        $mensagem = "Seu código de segurança é: " . $codigo_seguranca;

        $mail = new PHPMailer(true);

        try {

            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'flaviohps8@gmail.com';
            $mail->Password = 'flavio280480';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('flaviohps8@gmail.com', 'Mailer');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = $assunto;
            $mail->Body    = $mensagem;

            $mail->send();

            $_SESSION['codigo_seguranca'] = $codigo_seguranca;
            $_SESSION['codigo_seguranca_expiracao'] = time() + 3600;

            $etapa1 = false;
            $etapa2 = true;
        } catch (Exception $e) {

            echo '<div class="error-container"><span class="error-message">Erro ao enviar o e-mail! Mailer Error: ', $mail->ErrorInfo, '</span></div>';
        }
    } else {

        echo '<div class="error-container"><span class="error-message">E-mail não encontrado!</span></div>';
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/style.css">
    <link rel="stylesheet" href="../Css/login.css">
    <link rel="shortcut icon" href="../Img/faviconDark.svg" type="image/x-icon">
    <link rel="shortcut icon" href="../Img/faviconLight.svg" type="image/x-icon" media="(prefers-color-scheme: dark)">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../Js/login.js"></script>
    <title>Fm Segurança</title>
</head>

<body>
    <div class="body-container flexcenter aligncenter">
        <div class="body-content">
            <?php if ($etapa1) : ?>
                <div class="form-container flexstart aligncenter">
                    <div class="form-content">
                        <div class="logo blur5">
                            <img src="../Img/logoDark.svg" alt="Logo">
                            <h1>Fm Segurança</h1>
                        </div>
                    </div>
                    <aside><a href="login.php">Voltar</a></aside>
                    <form method="post" name="reset" class="flexstart aligncenter">
                        <div class="label-container">
                            <abbr title="Preencha este campo.">
                                <input type="email" name="email" id="email" tabindex="1" required>
                                <label for="email">Endereço de E-mail</label>
                            </abbr>
                        </div>
                        <input type="submit" name="submit" id="submit" value="Enviar" tabindex="3">
                    </form>
                </div>
            <?php endif; ?>

            <?php if ($etapa2) : ?>
                <!-- Conteúdo do Passo 2 -->
            <?php endif; ?>

            <?php if ($etapa3) : ?>
                <!-- Conteúdo do Passo 3 -->
            <?php endif; ?>
        </div>
    </div>
</body>

</html>