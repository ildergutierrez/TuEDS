<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Acceso no permitido.'); window.location.href='../index.php';</script>";
    exit();
}
include_once "../../php/conexion.php";
$conexion = $conn;
$id = $_SESSION['iduser'] ?? '';
if (isset($_GET['ser']) && $_GET['ser'] == 1) {//
    // Verificar que el formulario fue enviado por POST

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Recoger datos
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $telefono = $_POST['tel'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        $Correo = strtolower( $_POST['email'] ?? ''); // Convertir a minúsculas y asignar un valor por defecto
        actualizarPersona($conexion, $id, $nombre, $apellido, $telefono, $direccion, $Correo);
        ActalizarCorreo($conexion, $id, $Correo);
        echo "<script>window.location.href='../dashboard/configuracion.php?echo=1';</script>";
    } else {
        echo "<script>alert('Acceso no permitido.'); window.location.href='../dashboard/configuracion.php';</script>";
    }
}

if (isset($_GET['pass']) && $_GET['pass'] == 1) {
    // Verificar que el formulario fue enviado por POST
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Recoger datos
        $contrasena = $_POST['pass'] ?? '';
        ActualizarPass($conexion, $id, $contrasena);
        echo "<script>window.location.href='../dashboard/configuracion.php?echo=3';</script>";
    } else {
        echo "<script>alert('Acceso no permitido.'); window.location.href='../dashboard/configuracion.php?echo=4';</script>";
    }
}

echo "---";
//Agregar perdsonas a la base de datos INSERT INTO `persona`(`id_persona`, `nombre`, `apellido`, `telefono`, `direccion`, `correo`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]')
function actualizarPersona($conexion, $id, $nombre, $apellido, $telefono, $direccion, $correo)
{
    $sql = "UPDATE persona SET nombre = ?, apellido = ?, telefono = ?, direccion = ?, correo = ? WHERE id_persona = ?";
    $stmt = $conexion->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssssi", $nombre, $apellido, $telefono, $direccion, $correo, $id);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al insertar persona: " . $stmt->error;
            return false;
        }
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
        return false;
    }
}


function ActalizarCorreo($conexion, $id, $correo)
{
    $sql = $conexion->prepare("UPDATE usuario SET correo = ? WHERE id_usuario = ?");
    $sql->bind_param("si", $correo, $id);
    if ($sql->execute()) {
        return true;
    } else {
        echo "Error al insertar usuario: " . $sql->error;
        return false;
    }
}


//insitar usuario, INSERT INTO `usuario`(`id_usuario`, `correo`, `contrasena`, `fecha_registro`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')
function ActualizarPass($conexion, $id, $contrasena)
{
    $contrasena = password_hash($contrasena, PASSWORD_DEFAULT); // Encriptar la contraseña
    // die("Contrasena: " . $contrasena);
    $sql = $conexion->prepare("UPDATE usuario SET contrasena = ? WHERE id_usuario = ?");
    $sql->bind_param("si", $contrasena, $id);
    if ($sql->execute()) {
        return true;
    } else {
        echo "Error al insertar usuario: " . $sql->error;
        return false;
    }
}
