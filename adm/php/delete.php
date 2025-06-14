<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Acceso no permitido.'); window.location.href='../index.php';</script>";
    exit();
}
include_once "../../php/conexion.php";
$id = base64_decode($_GET['id'] ?? '');
if (empty($id)) {
    echo "<script> window.location.href='../dashboard/listado.php';</script>";
    exit();
}

function Eliminar_Eds($conn, $id)
{
    $sql = $conn->prepare("DELETE FROM eds WHERE id = ?");
    $sql->bind_param("i", $id);
    if ($sql->execute()) {
        $sql->close();
        return true;
    } else {
        $sql->close();
        return false;
    }
}
function Eliminar_Servicios($conn, $id)
{
    $sql = $conn->prepare("DELETE FROM servicios WHERE id = ?");
    $sql->bind_param("i", $id);
    if ($sql->execute()) {
        $sql->close();
        return true;
    } else {
        $sql->close();
        return false;
    }
}
function Eliminar_Combustibles($conn, $id)
{
    $sql = $conn->prepare("DELETE FROM combustibles WHERE id = ?");
    $sql->bind_param("i", $id);
    if ($sql->execute()) {
        $sql->close();
        return true;
    } else {
        $sql->close();
        return false;
    }
}
function eliminarImagen($conn, $id)
{
    $sql = $conn->prepare("SELECT img FROM eds WHERE id = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (!empty($row['img'])) {
            $imgPath = "../../" . $row['img'];
            // echo $imgPath;
            if (file_exists($imgPath) && $row['img'] != "img/servicios.png") {
                unlink($imgPath); // Eliminar la imagen del servidor
            }
            return true;
        }
    }
    $sql->close();
    return false;
}

if (eliminarImagen($conn, $id)) {
    Eliminar_Eds($conn, $id);
    Eliminar_Servicios($conn, $id);
    Eliminar_Combustibles($conn, $id);
    echo "<script> window.location.href='../dashboard/listado.php?res=1';</script>";
} else {
    echo "<script> window.location.href='../dashboard/listado.php?res=0';</script>";
}
