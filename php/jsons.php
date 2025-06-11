<?php
include 'conexion.php';
header('Content-Type: application/json; charset=utf-8');

function Valores($conn)
{
    $sql = $conn->prepare("SELECT * FROM eds");
    $sql->execute();
    $result = $sql->get_result();
    $data = array();

    while ($row = $result->fetch_assoc()) {
        // Agregar los datos de la EDS como objeto con servicios anidados
        $eds = array(
            "id" => $row['id'],
            "nombre" => $row['nombre'],
            "servicios" => Servicios($conn, $row['id'])
        );
        $data[] = $eds;
    }

    return $data;
}

function Servicios($conn, $id)
{
    $data = array();
    $sql = $conn->prepare("SELECT * FROM servicios WHERE eds = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
    }

    return $data;
}

// Mostrar el JSON formateado correctamente
echo json_encode(Valores($conn), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// Cerrar la conexión
$conn->close();
