<?php

require "verifica_login.php";

if($_SESSION["usuario_tipo"] != "admin"){

    echo "Acesso negado.";
    exit();

}