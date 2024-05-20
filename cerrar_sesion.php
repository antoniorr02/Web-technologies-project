<?php
    session_start();

    include "funciones.php";
    registrar_evento("Usuario cerró sesión", $_SESSION['id']);
    session_destroy();
    header("Location: main.php");
    exit();
?>