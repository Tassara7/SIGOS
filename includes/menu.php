<nav class="navbar navbar-expand-lg navbar-light bg-light">

<div class="container">

<a class="navbar-brand" href="dashboard.php">SIGOS</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavbar">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="menuNavbar">

<ul class="navbar-nav">

<li class="nav-item">
<a class="nav-link <?= ($pagina == "dashboard") ? "fw-bold text-primary active" : "" ?>" href="dashboard.php">
Dashboard
</a>
</li>

<li class="nav-item">
<a class="nav-link <?= ($pagina == "ordens") ? "fw-bold text-primary active" : "" ?>" href="ordens.php">
Ordens
</a>
</li>

<?php if(isset($_SESSION["usuario_tipo"]) && $_SESSION["usuario_tipo"] == "admin"): ?>

<li class="nav-item">
<a class="nav-link <?= ($pagina == "usuarios") ? "fw-bold text-primary active" : "" ?>" href="usuarios.php">
Usuários
</a>
</li>

<?php endif; ?>

<li class="nav-item">
<a class="nav-link <?= ($pagina == "perfil") ? "fw-bold text-primary active" : "" ?>" href="perfil.php">
Perfil
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="logout.php">
Sair
</a>
</li>

</ul>

</div>

</div>

</nav>