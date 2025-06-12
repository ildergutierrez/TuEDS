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
    SUM(CASE WHEN tienda = 1 THEN 1 ELSE 0 END) AS total_tiendas,
    SUM(CASE WHEN hospedaje = 1 THEN 1 ELSE 0 END) AS total_hospedajes,
    SUM(CASE WHEN banos = 1 THEN 1 ELSE 0 END) AS total_banos,
    SUM(CASE WHEN mecanica = 1 THEN 1 ELSE 0 END) AS total_mecanicas,
    SUM(CASE WHEN lavadero = 1 THEN 1 ELSE 0 END) AS total_lavaderos,
    SUM(CASE WHEN restaurante = 1 THEN 1 ELSE 0 END) AS total_restaurantes,
    SUM(CASE WHEN carga = 1 THEN 1 ELSE 0 END) AS total_cargas,
    SUM(CASE WHEN cajero = 1 THEN 1 ELSE 0 END) AS total_cajeros,
    SUM(CASE WHEN montallanta = 1 THEN 1 ELSE 0 END) AS total_montallantas
FROM servicios;
");
    $sql->execute();
    $result = $sql->get_result();
    $data = $result->fetch_assoc();
    return $data;
   
    $sql->close();// Cerrar la consulta
    $conn->close();// Cerrar la conexión
}


echo json_encode(Servicios($conn), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);