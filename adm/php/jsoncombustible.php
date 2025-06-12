<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../../index.html");
    exit();
}
header('Content-Type: application/json');
require_once '../../php/conexion.php';

function Servicios($conn)
{
    $data = [];
    $conn->set_charset("utf8mb4"); // Establecer el conjunto de caracteres a UTF-8
    $sql = $conn->prepare("SELECT 
  COUNT(*) AS total_registros,
  SUM(CASE WHEN gasolina != 0 THEN 1 ELSE 0 END) AS total_gasolina,
  SUM(CASE WHEN extra != 0 THEN 1 ELSE 0 END) AS total_extra,
  SUM(CASE WHEN deisel != 0 THEN 1 ELSE 0 END) AS total_deisel,
  SUM(CASE WHEN gas != 0 THEN 1 ELSE 0 END) AS total_gas
FROM combustibles;");
    $sql->execute();
    $result = $sql->get_result();
    $data = $result->fetch_assoc();
    return $data;
   
    $sql->close();// Cerrar la consulta
    $conn->close();// Cerrar la conexión
}


echo json_encode(Servicios($conn), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);