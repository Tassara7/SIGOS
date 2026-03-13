<?php
session_start();
require "config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
    
    # Cadastro dos usuários comuns
    $tipo = "usuario";

    $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (:nome, :email, :senha, :tipo)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":senha", $senha);
    $stmt->bindParam(":tipo", $tipo);
    $stmt->execute();

    header("Location: login.php");
    exit;
}

include "includes/header.php";
?>

<div class="container mt-5 col-md-6">

    <h2 class="mb-4">Criar Conta</h2>

    <form id="form-cadastro" action="cadastro.php" method="POST">

        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Senha</label>
            <input type="password" name="senha" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">
            Cadastrar
        </button>
        
        <a href="index.php" class="btn btn-secondary">Voltar</a>

    </form>

</div>

<?php include "includes/footer.php"; ?>