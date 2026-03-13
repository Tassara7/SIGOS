<?php include "includes/header.php"; ?>

<div class="container mt-5 col-md-6">

<h2 class="mb-4">Login</h2>

<?php if(isset($_GET["erro"])): ?>

<div class="alert alert-danger">
Email ou senha inválidos
</div>

<?php endif; ?>

<form id="form-login" action="autenticar.php" method="POST">

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Senha</label>
<input type="password" name="senha" class="form-control" required>
</div>

<button type="submit" class="btn btn-primary">
Entrar
</button>

</form>

</div>

<?php include "includes/footer.php"; ?>