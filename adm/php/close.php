<?php
session_start();

DestroySession();
function DestroySession()
{
    session_destroy();
    unset($_SESSION['user']);// la sesión se destruye y se eliminan las variables de sesión
    unset($_SESSION['nombre']);// se eliminan las variables de sesión
    unset($_SESSION['iduser']);
    header("Location: ../login.php");
    exit();
}