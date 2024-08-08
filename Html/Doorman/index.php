<?php
session_start();
include '../../Php/conexao.php';
include '../../Php/doorman.php';

$usuario_id = null;
$veiculo_id = null;
$nome = null;
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER["REQUEST_METHOD"] != '') {
    $ecpf = isset($_POST['ecpf']) ? $_POST['ecpf'] : null;
    $eplaca = isset($_POST['eplaca']) ? $_POST['eplaca'] : null;
    $scpf = isset($_POST['scpf']) ? $_POST['scpf'] : null;
    $splaca = isset($_POST['splaca']) ? $_POST['splaca'] : null;

    if (!empty($ecpf) || !empty($eplaca)) {
        if (!empty($eplaca)) {

            $stmt = $conn->prepare("SELECT id, usuario_id FROM veiculo WHERE placa = ?");
            $stmt->execute([$eplaca]);
            $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($veiculo) {
                $veiculo_id = $veiculo['id'];
                $usuario_id = $veiculo['usuario_id'];

                $stmt = $conn->prepare("SELECT nome FROM usuario WHERE id = ?");
                $stmt->execute([$usuario_id]);
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($usuario) {
                    $nome = $usuario['nome'];
                } else {
                    echo '<div class="error-container"><span class="error-message">Ocorreu um erro</span></div>';
                    $error = true;
                }
            } else {
                echo '<div class="error-container"><span class="error-message">Ocorreu um erro</span></div>';
                $error = true;
            }
        } else if (!empty($ecpf)) {
            $stmt = $conn->prepare("SELECT id FROM usuario WHERE cpf = ?");
            $stmt->execute([$ecpf]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($usuario) {
                $usuario_id = $usuario['id'];
            } else {
                echo '<div class="error-container"><span class="error-message">Ocorreu um erro</span></div>';
                $error = true;
            }
        }

        if (!$error) {

            $stmt = $conn->prepare("INSERT INTO entrada (usuario_id, veiculo_id, horario) VALUES (?, ?, NOW())");
            $stmt->execute([$usuario_id, $veiculo_id]);
        }
    }

    if (!empty($scpf) || !empty($splaca)) {
        if (!empty($splaca)) {
            $stmt = $conn->prepare("SELECT id, usuario_id FROM veiculo WHERE placa = ?");
            $stmt->execute([$splaca]);
            $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($veiculo) {
                $veiculo_id = $veiculo['id'];
                $usuario_id = $veiculo['usuario_id'];

                $stmt = $conn->prepare("SELECT nome FROM usuario WHERE id = ?");
                $stmt->execute([$usuario_id]);
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($usuario) {
                    $nome = $usuario['nome'];
                } else {
                    echo '<div class="error-container"><span class="error-message">Ocorreu um erro</span></div>';
                    $error = true;
                }
            } else {
                echo '<div class="error-container"><span class="error-message">Ocorreu um erro</span></div>';
                $error = true;
            }
        } else if (!empty($scpf)) {
            $stmt = $conn->prepare("SELECT id FROM usuario WHERE cpf = ?");
            $stmt->execute([$scpf]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($usuario) {
                $usuario_id = $usuario['id'];
            } else {
                echo '<div class="error-container"><span class="error-message">Ocorreu um erro</span></div>';
                $error = true;
            }
        }

        if (!$error) {

            $stmt = $conn->prepare("INSERT INTO saida (usuario_id, veiculo_id, horario) VALUES (?, ?, NOW())");
            $stmt->execute([$usuario_id, $veiculo_id]);
        }
    }
}

$stmt = $conn->prepare("
        SELECT entrada.*, usuario.nome, veiculo.placa 
        FROM entrada 
        LEFT JOIN usuario ON entrada.usuario_id = usuario.id 
        LEFT JOIN veiculo ON entrada.veiculo_id = veiculo.id
        WHERE DATE(horario) = CURDATE()
    ");
$stmt->execute();
$entradas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("
        SELECT saida.*, usuario.nome, veiculo.placa 
        FROM saida 
        LEFT JOIN usuario ON saida.usuario_id = usuario.id 
        LEFT JOIN veiculo ON saida.veiculo_id = veiculo.id
        WHERE DATE(horario) = CURDATE()
    ");
$stmt->execute();
$saidas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Css/style.css">
    <link rel="stylesheet" href="../../Css/Doorman/index.css">
    <link rel="shortcut icon" href="../../Img/faviconDark.svg" type="image/x-icon">
    <link rel="shortcut icon" href="../../Img/faviconLight.svg" type="image/x-icon" media="(prefers-color-scheme: dark)">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../../Js/Doorman/index.js" defer></script>
    <title>Fm Segurança</title>
</head>

<body class="flexbetween aligncenter">
    <header class="flexcenter aligncenter">
        <div class="header-content flexbetween aligncenter blur10">
            <div class="logo-container">
                <div class="logo">
                    <img src="../../Img/logoDark.svg" alt="Logo">
                    <h1>Fm Segurança</h1>
                </div>
            </div>
            <nav class="flexend aligncenter">
                <a href="historico.php"><ion-icon name="calendar-outline"></ion-icon></a>
                <a href="entrada.php" class="ion-notify"><ion-icon name="file-tray-outline"></ion-icon></a>
                <a href="../../Php/logout.php"><ion-icon name="exit-outline"></ion-icon></a>
            </nav>
        </div>
    </header>

    <main class="flexstart aligncenter">
        <!--Tabber-->
        <div class="tabber-container flexbetween aligncenter">
            <div class="tabber-nav flexevenly aligncenter">
                <button class="tabber-nav-link" id="defaultOpen" onclick="openEnterExit(event, 'entrada')">Entrada</button>
                <button class="tabber-nav-link" onclick="openEnterExit(event, 'saida')">Saída</button>
            </div>
            <div class="main-content flexbetween aligncenter">
                <div class="tabber-content flexcenter aligncenter" id="entrada">
                    <div class="tabber-line" id="line-fixed">
                        <span><strong>Nome</strong></span>
                        <span><strong>Dados</strong></span>
                        <span><strong>Horário</strong></span>
                    </div>
                    <?php
                    foreach ($entradas as $entrada) {
                        if (!empty($entrada['veiculo_id'])) {
                            $stmt = $conn->prepare("SELECT id, placa FROM veiculo WHERE id = ?");
                            $stmt->execute([$entrada['veiculo_id']]);
                            $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo '<div class="tabber-line"><span>' . $entrada['nome'] . '</span><span>' . $entrada['placa'] . '</span><span>' . $entrada['horario'] . '</span></div>';
                        } else if (!empty($entrada['usuario_id'])) {
                            $stmt = $conn->prepare("SELECT nome, cpf FROM usuario WHERE id = ?");
                            $stmt->execute([$entrada['usuario_id']]);
                            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo '<div class="tabber-line"><span>' . $usuario['nome'] . '</span><span>' . $usuario['cpf'] . '</span><span>' . $entrada['horario'] . '</span></div>';
                        }
                    }
                    ?>
                </div>
                <div class="tabber-content" id="saida">
                    <div class="tabber-line" id="line-fixed">
                        <span><strong>Nome</strong></span>
                        <span><strong>Dados</strong></span>
                        <span><strong>Horário</strong></span>
                    </div>
                    <?php
                    foreach ($saidas as $saida) {
                        if (!empty($saida['veiculo_id'])) {
                            $stmt = $conn->prepare("SELECT id, placa FROM veiculo WHERE id = ?");
                            $stmt->execute([$saida['veiculo_id']]);
                            $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo '<div class="tabber-line"><span>' . $saida['nome'] . '</span><span>' . $saida['placa'] . '</span><span>' . $saida['horario'] . '</span></div>';
                        } else if (!empty($saida['usuario_id'])) {
                            $stmt = $conn->prepare("SELECT nome, cpf FROM usuario WHERE id = ?");
                            $stmt->execute([$saida['usuario_id']]);
                            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo '<div class="tabber-line"><span>' . $usuario['nome'] . '</span><span>' . $usuario['cpf'] . '</span><span>' . $saida['horario'] . '</span></div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="tabber-inputs flexbetween aligncenter">
                <div class="input-area input-top input-entrada">
                    <div class="input-radio flexcenter aligncenter">
                        <input type="radio" name="radioentrada" id="eveiculo" checked class="displaynone">
                        <label for="eveiculo"><span class="onlypc">Veículo</span><span class="onlycell"><ion-icon name="car-outline"></ion-icon></span></label>
                        <input type="radio" name="radioentrada" id="epessoa" class="displaynone">
                        <label for="epessoa"><span class="onlypc">Pessoa</span><span class="onlycell"><ion-icon name="person-outline"></ion-icon></span></label>
                    </div>
                </div>
                <div class="input-area input-bottom input-entrada">
                    <form action="index.php" method="post" name="form-entrada" class="flexbetween aligncenter">
                        <input type="text" name="eplaca" id="eplaca" placeholder="Placa">
                        <input type="text" name="ecpf" id="ecpf" placeholder="CPF">
                        <input type="submit" value="Registrar" class="safety" id="esubmit">
                    </form>
                </div>

                <div class="input-area input-top input-saida">
                    <div class="input-radio flexcenter aligncenter">
                        <input type="radio" name="radiosaida" id="sveiculo" checked class="displaynone">
                        <label for="sveiculo"><span class="onlypc">Veículo</span><span class="onlycell"><ion-icon name="car-outline"></ion-icon></span></label>
                        <input type="radio" name="radiosaida" id="spessoa" class="displaynone">
                        <label for="spessoa"><span class="onlypc">Pessoa</span><span class="onlycell"><ion-icon name="person-outline"></ion-icon></span></label>
                    </div>
                </div>
                <div class="input-area input-bottom input-saida">
                    <form action="index.php" method="post" name="form-entrada" class="flexbetween aligncenter">
                        <input type="text" name="splaca" id="splaca" placeholder="Placa">
                        <input type="text" name="scpf" id="scpf" placeholder="CPF">
                        <input type="submit" value="Registrar" class="safety" id="ssubmit">
                    </form>
                </div>
            </div>
        </div>
        <!--Tabber-->
    </main>
</body>

</html>