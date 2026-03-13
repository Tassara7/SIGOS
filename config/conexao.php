<?php

$host = "localhost";
$db   = "sigos";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit;
}

// cria um admin padrao se nao existir nenhum
$totalAdmins = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE tipo = 'admin'")->fetchColumn();

if ($totalAdmins == 0) {
    $senha = password_hash("admin123", PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES ('Administrador', 'admin@gmail.com', :senha, 'admin')");
    $stmt->bindParam(":senha", $senha);
    $stmt->execute();
}

?>