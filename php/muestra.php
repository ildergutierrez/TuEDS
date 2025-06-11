<?php
if(!isset($_GET['callback']) || $_GET['callback'] !== 'estaciones') {
    header("Location: ../index.html");
    exit();
}
include 'conexion.php';
header('Content-Type: application/json; charset=utf-8');

function Valores($conn)
{
    $sql = $conn->prepare("SELECT * FROM eds ORDER BY id DESC ");
    $sql->execute();
    $result = $sql->get_result();
    $data = array();

    while ($row = $result->fetch_assoc()) {
        // Agregar los datos de la EDS como objeto con servicios anidados
        $eds = array(
            "id" => $row['id'],
            "nombre" => $row['nombre'],
            "img" => $row['img'],
            "latitud" => $row['lat'],
            "longitud" => $row['lon'],
            
        );
        $data[] = $eds;
    }

    return $data;
}


// Mostrar el JSON formateado correctamente
echo json_encode(Valores($conn), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

$conn->close();