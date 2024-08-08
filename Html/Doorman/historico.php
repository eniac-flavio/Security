<?php
session_start();
include '../../Php/conexao.php';
include '../../Php/doorman.php';

$stmt = $conn->prepare("
        SELECT entrada.*, usuario.nome, usuario.cpf, veiculo.placa 
        FROM entrada 
        LEFT JOIN usuario ON entrada.usuario_id = usuario.id 
        LEFT JOIN veiculo ON entrada.veiculo_id = veiculo.id
    ");
$stmt->execute();
$entradas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("
        SELECT saida.*, usuario.nome, usuario.cpf, veiculo.placa 
        FROM saida 
        LEFT JOIN usuario ON saida.usuario_id = usuario.id 
        LEFT JOIN veiculo ON saida.veiculo_id = veiculo.id
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
    <link rel="stylesheet" href="../../Css/Doorman/historico.css">
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
                <a href="index.php"><ion-icon name="arrow-back"></ion-icon></a>
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
                        <span><strong>Data</strong></span>
                    </div>
                    <?php
                    foreach ($entradas as $entrada) {

                        $dados = isset($entrada['placa']) ? $entrada['placa'] : $entrada['cpf'];
                        echo '<div class="tabber-line"><span>' . $entrada['nome'] . '</span><span>' . $dados . '</span><span>' . $entrada['horario'] . '</span></div>';
                    }
                    ?>
                </div>
                <div class="tabber-content" id="saida">
                    <div class="tabber-line" id="line-fixed">
                        <span><strong>Nome</strong></span>
                        <span><strong>Dados</strong></span>
                        <span><strong>Data</strong></span>
                    </div>
                    <?php
                    foreach ($saidas as $saida) {
                        echo '<div class="tabber-line"><span>' . $saida['nome'] . '</span><span>' . $saida['cpf'] . '</span><span>' . $saida['horario'] . '</span></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <!--Tabber-->
    </main>
</body>

</html>