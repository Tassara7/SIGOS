<?php
$pagina = "usuarios";
require "config/verifica_login.php";
require "config/conexao.php";

# Apenas admin pode acessar
if($_SESSION["usuario_tipo"] != "admin"){
    header("Location: dashboard.php");
    exit;
}


$id = $_GET["id"];
$sql = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

include "includes/header.php";
include "includes/menu.php";
?>

<div class="container mt-5">

    <h2>Editar Usuário</h2>

    <form id="form-usuario" action="atualizar_usuario.php" method="POST">
        
        <input type="hidden" name="id" value="<?= $usuario["id"] ?>">

        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" value="<?= $usuario["nome"] ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $usuario["email"] ?>" required>
        </div>

        <div class="mb-3">
            <label>Tipo</label>
            <select name="tipo" class="form-control">
                <option value="usuario" <?= $usuario["tipo"] == "usuario" ? "selected" : "" ?>>Usuário</option>
                <option value="tecnico" <?= $usuario["tipo"] == "tecnico" ? "selected" : "" ?>>Técnico</option>
                <option value="admin" <?= $usuario["tipo"] == "admin" ? "selected" : "" ?>>Administrador</option>
            </select>
        </div>

        <button class="btn btn-primary">Salvar Alterações</button>
        <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>

    </form>

</div>

<?php include "includes/footer.php"; ?>