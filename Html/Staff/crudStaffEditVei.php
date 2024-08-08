<?php
session_start();
include '../../Php/conexao.php';
include '../../Php/staff.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("SELECT * FROM veiculo WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT cpf FROM usuario WHERE id = :id");
    $stmt->bindParam(':id', $veiculo['usuario_id']);
    $stmt->execute();
    $cpf = $stmt->fetchColumn();

    if (isset($_POST['editar'])) {
        $cpf = $_POST['usuario_id'];
        $placa = $_POST['placa'];

        $stmt = $conn->prepare("SELECT id FROM usuario WHERE cpf = :cpf");
        $stmt->bindParam(':cpf', $cpf);
        $stmt->execute();
        $usuario_id = $stmt->fetchColumn();

        if ($usuario_id && ($usuario_id != $veiculo['usuario_id'] || $placa != $veiculo['placa'])) {
            $sql = "UPDATE veiculo SET usuario_id = :usuario_id, placa = :placa WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':placa', $placa);
            $stmt->bindParam(':id', $id);

            $stmt->execute();
        }

        header('Location: index.php');
        exit();
    }
} else {
    die("Método de requisição inválido ou ID não fornecido.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Css/style.css">
    <link rel="stylesheet" href="../../Css/crudEdit.css">
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
    </header>

    <main>
        <div class="edit-title">Editar Veículo #<output><?php echo $veiculo['id']; ?></output></div>
        <form action="crudStaffEditVei.php" method="POST" name="editFun">
            <input type="hidden" name="id" value="<?php echo $veiculo['id']; ?>">
            <div class="edit-container flexstart aligncenter">
                <label for="usuario_id">Dono (cpf):</label>
                <input type="text" id="usuario_id" name="usuario_id" value="<?php echo $cpf; ?>">
            </div>
            <div class="edit-container flexstart aligncenter">
                <label for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" value="<?php echo $veiculo['placa']; ?>">
            </div>
            <div class="flexcenter aligncenter">
                <button type="submit" name="editar" class="btn"><ion-icon name="brush"></ion-icon>Editar</button>
                <a href="index.php" class="btn"><ion-icon name="arrow-back-outline"></ion-icon>Voltar</a>
            </div>
        </form>
    </main>
</body>

</html>