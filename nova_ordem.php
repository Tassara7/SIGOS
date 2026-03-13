<?php

$pagina = "ordens";

require "config/verifica_login.php";

include "includes/header.php";
include "includes/menu.php";

?>

<div class="container mt-5">

<h2>Abrir Ordem de Serviço</h2>

<form id="form-ordem" action="salvar_ordem.php" method="POST">

<div class="mb-3">
<label>Título</label>
<input type="text" name="titulo" class="form-control" required>
</div>

<div class="mb-3">
<label>Descrição</label>
<textarea name="descricao" class="form-control" required></textarea>
</div>

<div class="mb-3">

<label>Prioridade</label>

<select name="prioridade" class="form-control">

<option value="baixa">Baixa</option>
<option value="media">Média</option>
<option value="alta">Alta</option>

</select>

</div>

<button type="submit" class="btn btn-primary">
Registrar Ordem
</button>

</form>

</div>

<?php include "includes/footer.php"; ?>