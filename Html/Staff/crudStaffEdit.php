<?php
session_start();
include '../../Php/conexao.php';
include '../../Php/staff.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['editar'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $cpf = $_POST['cpf'];
        $cnpj = $_POST['cnpj'];
        $acesso = $_POST['acesso'];

        $sql = "UPDATE usuario SET nome = :nome, email = :email, senha = :senha, cpf = :cpf, cnpj = :cnpj, acesso = :acesso WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':acesso', $acesso);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

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
        <div class="edit-title">Editar Usuário #<output><?php echo $usuario['id']; ?></output></div>
        <form action="crudStaffEdit.php" method="POST" name="editFun">
            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>"> <!-- Adicionado -->
            <div class="edit-container flexstart aligncenter">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo $usuario['nome']; ?>">
            </div>
            <div class="edit-container flexstart aligncenter">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $usuario['email']; ?>">
            </div>
            <div class="edit-container flexstart aligncenter">
                <label for="senha">Senha:</label>
                <input type="text" id="senha" name="senha" value="<?php echo $usuario['senha']; ?>">
            </div>
            <div class="edit-container flexstart aligncenter">
                <label for="cpf">CPF:</label>
                <?php
                if ($usuario['cpf'] == '') {
                    echo '<input type="text" name="cpf" placeholder="Sem dados">';
                } else {
                    echo '<input type="text" placeholder="Sem dados" id="cpf" name="cpf" value="' . $usuario['cpf'] . '">';
                }
                ?>
            </div>
            <div class="edit-container flexstart aligncenter">
                <label for="cnpj">CNPJ:</label>
                <?php
                if ($usuario['cnpj'] == '') {
                    echo '<input type="text" name="cnpj" placeholder="Sem dados">';
                } else {
                    echo '<input type="text" placeholder="Sem dados" id="cnpj" name="cnpj" value="' . $usuario['cnpj'] . '">';
                }
                ?>
            </div>
            <div class="edit-container flexstart aligncenter">
                <label for="acesso">Acesso:</label>
                <select id="acesso" name="acesso">
                    <option value="doorman" <?php echo ($usuario['acesso'] == 'doorman') ? 'selected' : ''; ?>>Doorman</option>
                    <option value="staff" <?php echo ($usuario['acesso'] == 'staff') ? 'selected' : ''; ?>>Staff</option>
                    <option value="enterprise" <?php echo ($usuario['acesso'] == 'enterprise') ? 'selected' : ''; ?>>Enterprise</option>
                    <option value="enterprise" <?php echo ($usuario['acesso'] == 'visitor') ? 'selected' : ''; ?>>Visitor</option>
                </select>
            </div>
            <div class="flexcenter aligncenter">
                <button type="submit" name="editar" class="btn"><ion-icon name="brush"></ion-icon>Editar</button>
                <a href="index.php" class="btn"><ion-icon name="arrow-back-outline"></ion-icon>Voltar</a>
            </div>
        </form>
    </main>
</body>

</html>