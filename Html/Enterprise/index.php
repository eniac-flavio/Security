<?php
session_start();
include '../../Php/conexao.php';
include '../../Php/enterprise.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Css/style.css">
    <link rel="stylesheet" href="../../Css/Enterprise/index.css">
    <link rel="shortcut icon" href="../../Img/faviconDark.svg" type="image/x-icon">
    <link rel="shortcut icon" href="../../Img/faviconLight.svg" type="image/x-icon" media="(prefers-color-scheme: dark)">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../../Js/Doorman/index.js" defer></script>
    <title>Fm Segurança</title>
</head>

<body class="flexcenter">
    <header class="flexcenter aligncenter">
        <div class="header-content flexbetween aligncenter blur10">
            <div class="logo-container">
                <div class="logo">
                    <a href="index.php">
                        <img src="../../Img/logoDark.svg" alt="Logo">
                        <h1>Fm Segurança</h1>
                    </a>
                </div>
            </div>
            <nav class="flexend aligncenter">
                <a href="../../Php/logout.php"><ion-icon name="exit-outline"></ion-icon></a>
            </nav>
        </div>
    </header>

    <main class="flexbetween aligncenter">
        <!--Limite de 5 tags por notificação-->
        <div class="list-container flexstart aligncenter">
            <div class="list-content-new flexstart aligncenter">
                <div class="list-new flexbetween alignstart">
                    <div class="newc-content">
                        <div class="new-title">Novo</div>
                        <div class="new-info">Escrever uma nova mensagem?</div>
                    </div>
                </div>
            </div>

            <div class="list-content flexstart aligncenter">
                <div class="list-desc flexbetween alignstart">
                    <div class="list-title">Novo visitante</div>
                    <div class="list-tag flexstart aligncenter"><span>Instagram</span><span>Não visto</span></div>
                </div>
            </div>

            <div class="list-content flexstart aligncenter">
                <div class="list-desc flexbetween alignstart">
                    <div class="list-title">Novo visitante</div>
                    <div class="list-tag flexstart aligncenter"><span>Samsung</span><span>Não visto</span></div>
                </div>
            </div>

            <div class="list-content flexstart aligncenter">
                <div class="list-desc flexbetween alignstart">
                    <div class="list-title">Banimento do youtube durante o serviço</div>
                    <div class="list-tag flexstart aligncenter"><span>Matheus T.</span><span>Procastinação</span><span>Visto</span></div>
                </div>
            </div>

            <div class="list-content flexstart aligncenter">
                <div class="list-desc flexbetween alignstart">
                    <div class="list-title">Salários atrasados</div>
                    <div class="list-tag flexstart aligncenter"><span>Kevin Heart</span><span>Pedido de desculpas</span><span>Visto</span></div>
                </div>
            </div>

            <div class="list-content flexstart aligncenter">
                <div class="list-desc flexbetween alignstart">
                    <div class="list-title">Suspeita de envolvimento em apostas</div>
                    <div class="list-tag flexstart aligncenter"><span>Paquetá</span><span>Visto</span></div>
                </div>
            </div>

            <div class="list-content flexstart aligncenter">
                <div class="list-desc flexbetween alignstart">
                    <div class="list-title">Clausulas criminais</div>
                    <div class="list-tag flexstart aligncenter"><span>Gabriel Monteiro</span><span>Prevenções</span><span>Guias</span><span>Visto</span></div>
                </div>
            </div>

            <div class="list-content flexstart aligncenter">
                <div class="list-desc flexbetween alignstart">
                    <div class="list-title">Bem-vindo ao Fm Segurança!</div>
                    <div class="list-tag flexstart aligncenter"><span>Flávio H.</span><span>Guias</span><span>Visto</span></div>
                </div>
            </div>
        </div>

        <div class="message-container flexstart aligncenter">
            <div class="message-sent flexstart aligncenter">
                <div class="message-profile flexcenter aligncenter">
                    <ion-icon name="close-outline"></ion-icon>
                </div>
                <div class="message-info flexbetween alignstart">
                    <div class="message-title">Novo visitante</div>
                    <div class="message-from">- Instagram</div>
                </div>
            </div>
            <div class="message-content">
                <p>
                    Atenção, liberar a entrada de <b>{NOME}</b> para visita na empresa <b>{EMPRESA}</b> às <b>{HORÁRIO}</b> do dia <b>{DIA}</b>.
                    <br><br>
                    Documento: <b>{CPF}</b> ou <b>{PLACA}</b>.
                </p>
            </div>
        </div>
    </main>
    <script>
        const listItems = document.querySelectorAll('.list-content');
        const messageContent = document.querySelector('.message-content');
        const messageFrom = document.querySelector('.message-from');
        const messageTitle = document.querySelector('.message-title');

        function isMobileOrTablet() {
            return window.matchMedia("screen and (max-width: 1024px)").matches;
        }

        function showMessage() {
            if (isMobileOrTablet()) {
                document.querySelector('.list-container').style.display = 'none';
                document.querySelector('.message-container').style.display = 'flex';
                document.querySelector('.message-profile ion-icon').style.display = 'block';
            }
        }

        function showList() {
            if (isMobileOrTablet()) {
                document.querySelector('.list-container').style.display = 'flex';
                document.querySelector('.message-container').style.display = 'none';
            } else {

                document.querySelector('.list-container').style.display = 'flex';
                document.querySelector('.message-container').style.display = 'flex';
                document.querySelector('.message-profile ion-icon').style.display = 'none';
            }
        }

        listItems.forEach(item => {
            item.addEventListener('click', function() {

                const title = this.querySelector('.list-title').innerText;

                let contentText = '';
                if (title === 'Novo visitante') {
                    contentText = 'Um novo visitante aguarda aprovação para entrar.';
                } else if (title === 'Banimento do youtube durante o serviço') {
                    contentText = 'Houve um banimento do Youtube durante o horário de serviço.';
                } else if (title === 'Salários atrasados') {
                    contentText = 'Alguns funcionários relataram salários atrasados.';
                } else if (title === 'Suspeita de envolvimento em apostas') {
                    contentText = 'Suspeita de envolvimento em atividades de apostas.';
                } else if (title === 'Clausulas criminais') {
                    contentText = 'Revisão de cláusulas criminais relacionadas à segurança.';
                } else if (title === 'Bem-vindo ao Fm Segurança!') {
                    contentText = 'Seja bem-vindo ao Fm Segurança!';
                } else {
                    contentText = 'Novo evento registrado.';
                }

                messageContent.innerHTML = `<p>${contentText}</p>`;

                const tags = this.querySelectorAll('.list-tag span:not(:first-child)');
                if (tags.length > 0) {

                    const companyTags = Array.from(tags).map(tag => tag.innerText).join(', ');
                    messageFrom.innerHTML = `- ${companyTags}`;
                } else {

                    messageFrom.innerHTML = '';
                }

                messageTitle.innerText = title;

                showMessage();
            });
        });

        document.querySelector('.message-profile ion-icon').addEventListener('click', showList);

        function adjustVisibility() {
            if (isMobileOrTablet()) {
                showList();
            } else {

                document.querySelector('.list-container').style.display = 'flex';
                document.querySelector('.message-container').style.display = 'flex';
                document.querySelector('.message-profile ion-icon').style.display = 'none';
            }
        }

        window.addEventListener('resize', adjustVisibility);

        adjustVisibility();
    </script>
</body>

</html>