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
        <form action="crud-vis.php" method="get" name="searchForm" class="flexbetween algincenter">
            <input type="text" name="search" id="search" placeholder="Nome do visitante">
            <button type="submit" class="btn flexcenter aligncenter"><ion-icon name="search-outline"></ion-icon>Pesquisar</button>
            <a href="inserir.php" class="btn flexcenter aligncenter"><ion-icon name="add-outline"></ion-icon>Novo</a>
        </form>
    </header>

    <main>
        <table>
            <tr>
                <th>Nome</th>
                <th>CPF / CNPJ</th>
                <th>Ações</th>
            </tr>
            <?php
            session_start();
            include '../../Php/conexao.php';
            include '../../Php/staff.php';

            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $searchTerms = explode(' ', $search);
            $searchQuery = "SELECT id, nome, email, cpf, cnpj FROM usuario WHERE acesso = 'visitor'";
            $bindParams = [];

            if ($search) {
                $searchQuery .= " AND (";
                foreach ($searchTerms as $index => $term) {

                    $regexPattern = implode('.*', array_map('preg_quote', str_split($term)));
                    $searchQuery .= " nome REGEXP ?";
                    $bindParams[] = $regexPattern;
                    if ($index + 1 != count($searchTerms)) {
                        $searchQuery .= " OR";
                    }
                }
                $searchQuery .= ")";
            }

            $stmt = $conn->prepare($searchQuery);
            $stmt->execute($bindParams);
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($usuarios && count($usuarios) > 0) {
                foreach ($usuarios as $usuario) {
                    echo '<tr>';
                    echo '<td>' . $usuario['nome'] . '</td>';
                    if ($usuario['cpf'] == '' and $usuario['cnpj'] == '') {
                        echo '<td>---</td>';
                    } elseif ($usuario['cpf'] != '' and $usuario['cnpj'] !== '') {
                        echo '<td><span class="cpf">CPF:⠀⠀⠀</span>' . $usuario['cpf'] . '</td>';
                    } elseif ($usuario['cnpj'] == '') {
                        echo '<td><span class="cpf">CPF:⠀⠀⠀</span>' . $usuario['cpf'] . '</td>';
                    } elseif ($usuario['cpf'] == '') {
                        echo '<td><span class="cnpj">CNPJ:⠀⠀</span>' . $usuario['cnpj'] . '</td>';
                    }
                    echo '<td>';
                    echo '<form method="POST" action="crudStaffEdit.php">';
                    echo '<input type="hidden" name="id" value="' . $usuario['id'] . '">';
                    echo '<button type="submit" class="btn flexcenter aligncenter"><ion-icon name="brush-outline"></ion-icon>Editar</button>';
                    echo '</form>';
                    echo ' <span>|</span> <form method="POST" action="crudStaffDelete.php">';
                    echo '<input type="hidden" name="id" value="' . $usuario['id'] . '">';
                    echo '<button type="submit" class="btn flexcenter aligncenter" onclick="confirmDelete(' . $usuario['id'] . ')"><ion-icon name="trash-outline"></ion-icon>Excluir</button>';
                    echo '</form>';
                    echo ' <span>|</span> <a class="btn" onclick="showDetails(' . $usuario['id'] . ')"><ion-icon name="eye-outline"></ion-icon>Ver Mais</a>';
                    echo '</td>';
                    echo '</tr>';
                    echo '<tr style="display:none;" class="details" id="details_' . $usuario['id'] . '">';
                    if ($usuario['cpf'] != '' and $usuario['cnpj'] !== '') {
                        echo '<td colspan="3" class="additional-info"><span class="add-id">#' . $usuario['id'] . '</span><span class="add-email">email: </span>' . $usuario['email'] . '<span class="add-cnpj">cnpj: </span>' . $usuario['cnpj'] . '</td>';
                    } else {
                        echo '<td colspan="3" class="additional-info"><span class="add-id">#' . $usuario['id'] . '</span><span class="add-email">email: </span>' . $usuario['email'] . '</td>';
                    }
                    echo '</tr>';
                }
            } else {
                echo "<tr><td colspan='9'>Nenhum visitante encontrado.</td></tr>";
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