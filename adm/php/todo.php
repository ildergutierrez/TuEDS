<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../../index.html");
    exit();
}
header('Content-Type: application/json');
require_once '../../php/conexion.php';
$id = $_GET['id'] ?? null;
$id = base64_decode($id);

function Eds($id, $conn) {
    $sql = $conn->prepare("SELECT * FROM `eds` WHERE `id` = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();// retorna el primer resultado
    } else {
        return null;
    }
}

function Servicios($id, $conn) {
    $sql = $conn->prepare("SELECT * FROM `servicios` WHERE `id` = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function Combustibles($id, $conn) {
    $sql = $conn->prepare("SELECT * FROM `combustibles` WHERE `id` = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}


//funcion que reune todo los resiltados
function getEdsData($id, $conn) {
    $eds = Eds($id, $conn);
    if ($eds) {
        $servicios = Servicios($id, $conn);
        $combustibles = Combustibles($id, $conn);
        return [
            'eds' => $eds,
            'servicios' => $servicios,
            'combustibles' => $combustibles
        ];
    } else {
        return null;
    }
}

echo json_encode(getEdsData($id, $conn), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);