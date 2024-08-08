<?php
session_start();
include '../Php/conexao.php';

if (isset($_SESSION["loggedIn"])) {
    echo '<div class="warning-container"><span class="warning-message">Você já está conectado!</span></div>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $dbSenha = $result['senha'];

        if ($senha === $dbSenha) {
            /* variáveis de sessão */
            $_SESSION['loggedIn'] = true;
            $_SESSION['userEmail'] = $email;

            $acesso =  $result['acesso'];
            switch ($acesso) {
                case 'doorman':
                    header("Location: Doorman/index.php");
                    exit();
                case 'enterprise':
                    header("Location: Enterprise/index.php");
                    exit();
                case 'staff':
                    header("Location: Staff/index.php");
                    exit();
            }
        } else {
            echo '<div class="error-container"><span class="error-message">Usuário não encontrado!</span></div>';
        }
    } else {
        echo '<div class="error-container"><span class="error-message">Usuário não encontrado!</span></div>';
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
            <div class="form-container flexstart aligncenter">
                <div class="form-content">
                    <div class="logo blur5">
                        <img src="../Img/logoDark.svg" alt="Logo">
                        <h1>Fm Segurança</h1>
                    </div>
                </div>
                <form action="login.php" method="post" name="login" class="flexstart aligncenter">
                    <div class="label-container">
                        <abbr title="Preencha este campo.">
                            <input type="email" name="email" id="email" tabindex="1" required>
                            <label for="email">Endereço de E-mail</label>
                        </abbr>
                    </div>

                    <div class="label-container">
                        <abbr title="Preencha este campo.">
                            <input type="password" name="senha" id="senha" tabindex="2" required>
                            <label for="senha">Senha</label>
                        </abbr>
                    </div>

                    <input type="submit" name="submit" id="submit" value="Entrar" tabindex="3" class="blocked">
                </form>
                <aside><a href="forgot.php" tabindex="4">Esqueceu a senha?</a></aside>
            </div>
        </div>
    </div>
</body>

</html>