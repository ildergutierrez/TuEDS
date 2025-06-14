<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../../index.html");
    exit();
}
header('Content-Type: application/json');
require_once '../../php/conexion.php';
$id =  $_SESSION['iduser']; // Asegúrate de que este id es el correcto para la consulta

$sql = $conn->prepare("SELECT * FROM persona WHERE id_persona = ?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
$data = array();
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    $data = array("error" => "No user found");
}

echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
