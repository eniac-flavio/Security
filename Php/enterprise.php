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
            /* permite o acesso */
        } elseif ($acesso === 'staff') {
            header("Location: ../Staff/index.php");
            exit();
        } else {
            header("Location: ../login.php");
            exit();
        }
    }
} else {
    header("Location: ../login.php");
    exit();
}
