<?php
if (isset($_SESSION["loggedIn"])) {
    $email = $_SESSION['userEmail'];
    $sql = "SELECT acesso FROM usuario WHERE email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $acesso = $result['acesso'];

        if ($acesso === 'doorman') {
            header("Location: ../Doorman/index.php");
            exit();
        } elseif ($acesso === 'enterprise') {
            header("Location: ../Enterprise/index.php");
            exit();
        } elseif ($acesso === 'staff') {
            /* permite o acesso */
        } else {
            header("Location: ../login.php");
            exit();
        }
    }
} else {
    header("Location: ../login.php");
    exit();
}
