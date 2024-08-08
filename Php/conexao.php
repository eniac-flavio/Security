<?php
$hostname = 'localhost';
$dbname = 'security';
$dbuser = 'root';
$dbpassword = '';

try {
    $dsn = "mysql:host=$hostname;dbname=$dbname";
    $conn = new PDO($dsn, $dbuser, $dbpassword);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('<div class="error-container"><span class="error-message"><b>Erro:</b> ' . $e->getMessage() . '</span></div>');
}
