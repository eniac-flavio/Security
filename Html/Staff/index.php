<?php
session_start();
include '../../Php/conexao.php';
include '../../Php/staff.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Css/style.css">
    <link rel="stylesheet" href="../../Css/Staff/index.css">
    <link rel="shortcut icon" href="../../Img/faviconDark.svg" type="image/x-icon">
    <link rel="shortcut icon" href="../../Img/faviconLight.svg" type="image/x-icon" media="(prefers-color-scheme: dark)">
    <script type="module" src="https://unpkg.com/ionicons@7.3.1/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.3.1/dist/ionicons/ionicons.js"></script>
    <script src="../../Js/Staff/index.js" defer></script>
    <title>Fm Segurança</title>
</head>

<body class="flexcenter aligncenter">
    <div class="body-container flexcenter aligncenter">
        <div class="body-content">
            <div class="staff-container flexstart aligncenter">
                <div class="staff-content">
                    <div class="logo blur5">
                        <img src="../../Img/logoDark.svg" alt="Logo">
                        <h1>Fm Segurança</h1>
                    </div>
                </div>
                <div class="staff-link flexstart aligncenter">
                    <a href="crud-fun.php" class="link-container flexstart aligncenter">
                        <div class="link-icon"><ion-icon name="finger-print-outline"></ion-icon></div>
                        <div class="link-info">Funcionários</div>
                    </a>

                    <a href="crud-emp.php" class="link-container flexstart aligncenter">
                        <div class="link-icon"><ion-icon name="business-outline"></ion-icon></div>
                        <div class="link-info">Empresas</div>
                    </a>

                    <a href="crud-vis.php" class="link-container flexstart aligncenter">
                        <div class="link-icon"><ion-icon name="walk-outline"></ion-icon></div>
                        <div class="link-info">Visitantes</div>
                    </a>

                    <a href="crud-vei.php" class="link-container flexstart aligncenter">
                        <div class="link-icon"><ion-icon name="car-sport-outline"></ion-icon></div>
                        <div class="link-info">Veículo</div>
                    </a>

                    <a href="historico.php" class="link-container flexstart aligncenter">
                        <div class="link-icon"><ion-icon name="calendar-outline"></ion-icon></div>
                        <div class="link-info">Histórico</div>
                    </a>

                    <a href="entrada.php" class="link-container flexstart aligncenter">
                        <div class="link-icon"><ion-icon name="file-tray-outline"></ion-icon></div>
                        <div class="link-info">Caixa de Entrada</div>
                    </a>

                    <aside><a href="../../Php/logout.php">Sair</a></aside>
                </div>
            </div>
        </div>
    </div>
</body>

</html>