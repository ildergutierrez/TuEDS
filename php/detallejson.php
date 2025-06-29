<?php
if(!isset($_GET['callback']) || $_GET['callback'] !== 'estaciones') {
    header("Location: ../index.html");
    exit();
}
$id = base64_decode($_GET['dt']);

include 'conexion.php';
header('Content-Type: application/json; charset=utf-8');

function Valores($conn, $id)
{
    $sql = $conn->prepare("SELECT * FROM eds WHERE id = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();
    $data = array();

    while ($row = $result->fetch_assoc()) {
        // Agregar los datos de la EDS como objeto con servicios anidados
        $eds = array(
            "nombre" => $row['nombre'],
            "latitud" => $row['lat'],
            "longitud" => $row['lon'],
            "imagen" => $row['img'],
            "servicios" => Servicios($conn, $row['id']),
            "combustibles" => Costos($conn, $row['id'])
        );
        $data[] = $eds;
    }

    return $data;
}

function Servicios($conn, $id)
{
    $data = array();
    $sql = $conn->prepare("SELECT * FROM servicios WHERE id = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
    }

    return $data;
}
function Costos($conn, $id)
{
    $data = array();
    $sql = $conn->prepare("SELECT * FROM combustibles WHERE id = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
    }

    return $data;
}

// Mostrar el JSON formateado correctamente
echo json_encode(Valores($conn, $id), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
// Cerrar la conexión
$conn->close();
