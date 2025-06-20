<?php 
// $host = 'sql206.infinityfree.com';         // MYSQLHOST
// $usuario = 'if0_39210269';         // Usuario por defecto
// $contrasena = 'TblpBH3zJgdZ';   // MYSQL_ROOT_PASSWORD
// $base_datos = 'if0_39210269_tuedes';   // MYSQL_DATABASE
// $port = 3306;            // Puerto por defecto de MySQL

$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "tueds";
$port = 3306; // Puerto por defecto de MySQL



// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $base_datos, $port);
// Verificar conexión
// if ($conn->connect_error) {
//     die("Error de conexión: " . $conn->connect_error);
// }
// // Establecer el conjunto de caracteres a UTF-8
// $conn->set_charset("utf8mb4");
// // Verificar si la conexión se realizó correctamente
// if ($conn->ping()) {
//     echo "Conexión exitosa a la base de datos.";
// } else {
//     echo "Error al conectar a la base de datos: " . $conn->error;
// }