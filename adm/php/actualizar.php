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
    $id = $_POST['ids'] ?? '';
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
    Actualizar_Eds($conn, base64_decode($id), $nombre, $lat, $lon, $image, $id); // Llamar a la función para actualizar o insertar
    Servicios($conn, base64_decode($id), $tienda, $hospedaje, $banos, $taller, $lavado, $restaurante, $carga, $cajero, $llanteria);
    Combustibles($conn, base64_decode($id), $gasolina, $extra, $diesel, $gas);

    echo "<script>window.location.href='../dashboard/visualizar.php?id=$id&res=1';</script>";
} else {
    echo "<script>window.location.href='../dashboard/visualizar.php?id=$id&res=2';</script>";
}
function Actualizar_Eds($conn, $id, $name, $lat, $lon,  $image)
{
    $img = "";
    // $sql = $conn->prepare("INSERT INTO eds (nombre, lat, lon) VALUES (?, ?, ?)");
    $sql = $conn->prepare("SELECT * FROM eds WHERE id = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
    //    echo "UPDATE eds SET nombre = $name, lat = $lat, lon = $lon WHERE id = $id";
    //    die();
        // Si ya existe, actualizamos
        $sql = $conn->prepare("UPDATE `eds` SET nombre = ?, lat = ?, lon = ? WHERE id = ?");
        // die($sql);
        $sql->bind_param("sddi", $name, $lat, $lon, $id);
        // Verificar si se subió una imagen
        if ($sql->execute()) {
            // Si se actualizó correctamente, guardamos la imagen si existe
            if ($image && $image['error'] === UPLOAD_ERR_OK) { // Verificar si se subió una imagen sin errores
                subirImagen($conn, $id, $image); // Llamar a la función para subir la imagen
            }
        } else {
            echo "<script>window.location.href='../dashboard/visualizar.php?id=$id&res=2';</script>";
        }
       
    
    } else {
        echo "<script>window.location.href='../dashboard/visualizar.php?id=$id&res=2';</script>";
    }
    $sql->close();
}

//INSERT INTO `servicios`(`id`, `tienda`, `hospedaje`, `banos`, `mecanica`, `lavadero`, `restaurante`, `carga`, `cajero`, `montallanta`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]')
function Servicios($conn, $id, $tienda, $hospedaje, $banos, $taller, $lavado, $restaurante, $carga, $cajero, $llanteria)
{
    // Preparar la consulta SQL
    $sql = $conn->prepare("UPDATE servicios SET tienda = ?, hospedaje = ?, banos = ?, mecanica = ?, lavadero = ?, restaurante = ?, carga = ?, cajero = ?, montallanta = ? WHERE id = ?");
    $sql->bind_param("iiiiiiiiii", $tienda, $hospedaje, $banos, $taller, $lavado, $restaurante, $carga, $cajero, $llanteria, $id);
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
    $sql = $conn->prepare("UPDATE combustibles SET gasolina = ?, extra = ?, deisel = ?, gas = ? WHERE id = ?");
    $sql->bind_param("ddddi", $gasolina, $extra, $diesel, $gas, $id);
    // Ejecutar la consulta
    if ($sql->execute()) {
        return true;
    } else {
        return false;
    }

    // Cerrar la consulta
    $sql->close();
    $conn->close();
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


// Subir imagen al servidor y devolver la ruta
function subirImagen($conn, $id, $image)
{
    // Obtener el ID insertado
    $img = ""; // Inicializar la variable de imagen
    // Guardar los servicios
    // Mover la imagen a la carpeta de destino con el nombre del ID

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
        echo "<script>window.location.href='../dashboard/visualizar.php?id=$id&res=2';</script>";
        exit();
    }

    //direccion donde fue guardar la imagen
    $img = "img/photo/" . $id . '.' . $imageFileType; // ejemplo: img/photo/123.jpg
    // Guardar la imagen en la base de datos

    GuardarImagen($conn, $id, $img);
}
