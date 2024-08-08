<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Css/style.css">
    <link rel="stylesheet" href="../../Css/crud.css">
    <link rel="shortcut icon" href="../../Img/faviconDark.svg" type="image/x-icon">
    <link rel="shortcut icon" href="../../Img/faviconLight.svg" type="image/x-icon" media="(prefers-color-scheme: dark)">
    <script type="module" src="https://unpkg.com/ionicons@7.3.1/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.3.1/dist/ionicons/ionicons.js"></script>
    <title>Fm Segurança</title>
</head>

<body>
    <header class="flexbetween aligncenter blur30">
        <div class="logo-container">
            <div class="logo">
                <a href="index.php">
                    <img src="../../Img/logoDark.svg" alt="Logo">
                    <h1>Fm Segurança</h1>
                </a>
            </div>
        </div>
        <form action="crud-vei.php" method="get" name="searchForm" class="flexbetween algincenter">
            <input type="text" name="search" id="search" placeholder="Placa do veículo">
            <button type="submit" class="btn flexcenter aligncenter"><ion-icon name="search-outline"></ion-icon>Pesquisar</button>
            <a href="inserir.php" class="btn flexcenter aligncenter"><ion-icon name="add-outline"></ion-icon>Novo</a>
        </form>
    </header>

    <main>
        <table>
            <tr>
                <th>Placa</th>
                <th>Dono</th>
                <th>Ações</th>
            </tr>
            <?php
            session_start();
            include '../../Php/conexao.php';
            include '../../Php/staff.php';

            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $searchQuery = "SELECT veiculo.id, veiculo.placa, usuario.nome FROM veiculo INNER JOIN usuario ON veiculo.usuario_id = usuario.id";
            $bindParams = [];

            if ($search) {
                $searchQuery .= " WHERE placa LIKE ?";
                $bindParams[] = $search . '%';
            }

            $stmt = $conn->prepare($searchQuery);
            $stmt->execute($bindParams);
            $veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($veiculos && count($veiculos) > 0) {
                foreach ($veiculos as $veiculo) {
                    echo '<tr>';
                    echo '<td>' . $veiculo['placa'] . '</td>';
                    echo '<td>' . $veiculo['nome'] . '</td>';
                    echo '<td>';
                    echo '<form method="POST" action="crudStaffEditVei.php">';
                    echo '<input type="hidden" name="id" value="' . $veiculo['id'] . '">';
                    echo '<button type="submit" class="btn flexcenter aligncenter"><ion-icon name="brush-outline"></ion-icon>Editar</button>';
                    echo '</form>';
                    echo ' <span>|</span> <form method="POST" action="crudStaffDelete.php">';
                    echo '<input type="hidden" name="id" value="' . $veiculo['id'] . '">';
                    echo '<button type="submit" class="btn flexcenter aligncenter" onclick="confirmDelete(' . $veiculo['id'] . ')"><ion-icon name="trash-outline"></ion-icon>Excluir</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                    echo '<tr style="display:none;" class="details" id="details_' . $veiculo['id'] . '">';
                    echo '</tr>';
                }
            } else {
                echo "<tr><td colspan='9'>Nenhum carro encontrado.</td></tr>";
            }
            ?>
        </table>
    </main>

    <script>
        function confirmDelete(userId) {
            if (confirm("Você realmente quer deletar este usuário?")) {
                window.location.href = "crudStaffDelete.php?id=" + userId;
            } else {
                event.preventDefault();
            }
        }

        function showDetails(userId) {
            var detailsRow = document.getElementById("details_" + userId);
            if (detailsRow.style.display === "none") {
                detailsRow.style.display = "table-row";
            } else {
                detailsRow.style.display = "none";
            }
        }
    </script>
</body>

</html>