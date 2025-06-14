<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Acceso no permitido.'); window.location.href='../index.php';</script>";
    exit();
}
include_once "../../php/conexion.php";
// Verificar que el formulario fue enviado por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoger datos
    $nombre = $_POST['nombre_eds'] ?? '';
    $lat = $_POST['lat'] ?? '';
    $lon = $_POST['lon'] ?? '';
    $gasolina = $_POST['gasolina'] ?? '';
    $extra = $_POST['extra'] ?? '';
    $diesel = $_POST['diesel'] ?? '';
    $gas = $_POST['gas'] ?? '';
    $tienda = isset($_POST['tienda']) ? 1 : 0;
    $hospedaje = isset($_POST['hospedaje']) ? 1 : 0;
    $banos = isset($_POST['banos']) ? 1 : 0;

    $taller = isset($_POST['taller']) ? 1 : 0;
    $lavado = isset($_POST['lavado']) ? 1 : 0;
    $restaurante = isset($_POST['restaurante']) ? 1 : 0;

    $carga = isset($_POST['carga']) ? 1 : 0;
    $cajero = isset($_POST['cajero']) ? 1 : 0;
    $llanteria = isset($_POST['llanteria']) ? 1 : 0;

    $image = $_FILES['imagen'] ?? null; // Verificar si se subió una imagen
    echo $image['name'];
    $numero = Registro_Eds($conn, $nombre, $lat, $lon, $image);
    Servicios($conn, $numero, $tienda, $hospedaje, $banos, $taller, $lavado, $restaurante, $carga, $cajero, $llanteria);
    Combustibles($conn, $numero, $gasolina, $extra, $diesel, $gas);

    echo "<script>window.location.href='../dashboard/estaciones.php?echo=1';</script>";
} else {
    echo "<script>alert('Acceso no permitido.'); window.location.href='../dashboard/estaciones.php';</script>";
}
function Registro_Eds($conn, $name, $lat, $lon,  $image)
{
    $img = "";
    $sql = $conn->prepare("INSERT INTO eds (nombre, lat, lon) VALUES (?, ?, ?)");
    $sql->bind_param("sdd", $name, $lat, $lon);

    if ($sql->execute()) {
        // Obtener el ID insertado
        $id = $conn->insert_id;
        // Guardar los servicios
        // Mover la imagen a la carpeta de destino con el nombre del ID
        if ($image && $image['error'] === UPLOAD_ERR_OK) { // Verificar si se subió una imagen sin errores
            $targetDir = "../../img/photo/"; // Ruta de destino para las imágenes

            // Asegúrate de que la carpeta exista
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            // Obtener extensión del archivo original
            $imageFileType = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
            $targetFile = $targetDir . $id . '.' . $imageFileType;

            // Mover el archivo
            if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
                echo "<script>alert('Registro guardado pero error al subir la imagen.'); window.location.href='index.php';</script>";
                exit();
            }
            //direccion donde fue guardar la imagen
            $img = "img/photo/" . $id . '.' . $imageFileType; // ejemplo: img/photo/123.jpg
            // Guardar la imagen en la base de datos
            GuardarImagen($conn, $id, $img);
        }
        return $id; // Retornar el ID de la estación de servicio
    }

    $sql->close();
}

//INSERT INTO `servicios`(`id`, `tienda`, `hospedaje`, `banos`, `mecanica`, `lavadero`, `restaurante`, `carga`, `cajero`, `montallanta`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]')
function Servicios($conn, $id, $tienda, $hospedaje, $banos, $taller, $lavado, $restaurante, $carga, $cajero, $llanteria)
{
    // Preparar la consulta SQL
    $sql = $conn->prepare("INSERT INTO servicios (id, tienda, hospedaje, banos, mecanica, lavadero, restaurante, carga, cajero, montallanta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("iiiiiiiiii", $id, $tienda, $hospedaje, $banos, $taller, $lavado, $restaurante, $carga, $cajero, $llanteria);

    // Ejecutar la consulta
    if ($sql->execute()) {
        return true;
    } else {
        return false;
    }

    // Cerrar la consulta
    $sql->close();
}

//INSERT INTO `combustibles`(`id`, `gasolina`, `extra`, `deisel`, `gas`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
function Combustibles($conn, $id, $gasolina, $extra, $diesel, $gas)
{
    // Preparar la consulta SQL
    $sql = $conn->prepare("INSERT INTO combustibles (id, gasolina, extra, deisel, gas) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("idddd", $id, $gasolina, $extra, $diesel, $gas);

    // Ejecutar la consulta
    if ($sql->execute()) {
        return true;
    } else {
        return false;
    }

    // Cerrar la consulta
    $sql->close();
}

//Guardar Ruta de la imagen en la base de datos, UPDATE `eds` SET `img`='[value-5]' WHERE 1
function GuardarImagen($conn, $id, $img)
{
    // Preparar la consulta SQL
    $sql = $conn->prepare("UPDATE eds SET img = ? WHERE id = ?");
    $sql->bind_param("si", $img, $id);

    // Ejecutar la consulta
    if ($sql->execute()) {
        return true;
    } else {
        return false;
    }

    // Cerrar la consulta
    $sql->close();
}
