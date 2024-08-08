<?php
include "../../Php/conexao.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM usuario WHERE id = :id");
    $stmt->bindParam(':id', $id);

    $stmt->execute();

    header('Location: crud-fun.php');
    exit();
} else {

    header('Location: crud-fun.php');
    exit();
}
