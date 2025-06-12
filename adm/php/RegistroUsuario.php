<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Acceso no permitido.'); window.location.href='../index.php';</script>";
    exit();
}
include_once "../../php/conexion.php";
$conexion = $conn;
// Verificar que el formulario fue enviado por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoger datos
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $telefono = $_POST['tel'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $Correo = $_POST['email'] ?? '';
    $pass = $_POST['pass'] ?? '';

    // echo $nombre."<br>";
    // echo $apellido."<br>";
    // echo $telefono."<br>";
    // echo $direccion."<br>";
    // echo $Correo."<br>";
    // echo $pass."<br>";

    if (validarCorreo($conexion, $Correo)) {
        agregarPersona($conexion, $nombre, $apellido, $telefono, $direccion, $Correo);
        insertarUsuario($conexion, $Correo, $pass);
    }

    echo "<script>window.location.href='../dashboard/usuarios.php?echo=1';</script>";
} else {
    echo "<script>alert('Acceso no permitido.'); window.location.href='../dashboard/usuarios.php';</script>";
}

//Agregar perdsonas a la base de datos INSERT INTO `persona`(`id_persona`, `nombre`, `apellido`, `telefono`, `direccion`, `correo`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]')
function agregarPersona($conexion, $nombre, $apellido, $telefono, $direccion, $correo)
{
    $sql = "INSERT INTO persona (nombre, apellido, telefono, direccion, correo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssss", $nombre, $apellido, $telefono, $direccion, $correo);
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

//validar si existe correo
function validarCorreo($conexion, $correo)
{
    $sql = "SELECT * FROM persona WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0; // Retorna true si el correo ya existe
    } else {
        return false;
    }
}

//insitar usuario, INSERT INTO `usuario`(`id_usuario`, `correo`, `contrasena`, `fecha_registro`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')
function insertarUsuario($conexion, $correo, $contrasena)
{
    $contrasena = password_hash($contrasena, PASSWORD_DEFAULT); // Encriptar la contraseña
    $sql = "INSERT INTO usuario (correo, contrasena, fecha_registro) VALUES (?, ?, NOW())";
    $stmt = $conexion->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $correo, $contrasena);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
