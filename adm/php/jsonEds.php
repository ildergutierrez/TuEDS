<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../../index.html");
    exit();
}
header('Content-Type: application/json');
require_once '../../php/conexion.php';

$sql = $conn->prepare("SELECT * FROM `eds` ORDER BY `eds`.`id` ASC");
$sql->execute();
$result = $sql->get_result();
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
$sql->close(); // Cerrar la consulta
$conn->close(); // Cerrar la conexión
echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);