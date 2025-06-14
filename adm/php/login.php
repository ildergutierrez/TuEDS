<?php

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    die("Invalid request");
    header("Location: ../login.php");
    exit();
}
include_once '../../php/conexion.php';
//menusculas

$username = $_POST['username'];
$username = strtolower(trim($username)); // Convert to lowercase and trim whitespace
$password = $_POST['password'];
// echo password_hash($password, PASSWORD_DEFAULT). "<br>"; // For testing purposes, you can remove this line later

// die();


$inicio = new Login($conn, $username, $password);

class Login
{
    private $conexion;
    private $username;
    private $password;
    public function __construct($conexion, $username, $password)
    {
        $this->conexion = $conexion;
        $this->username = $username;
        $this->password = $password;
        $this->authenticate($username, $password);
    }

    private function authenticate($username, $password)
    {
        $stmt = $this->conexion->prepare("SELECT * FROM usuario WHERE correo = ? ");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            
            $user = $result->fetch_assoc();
            if(password_verify($this->password, $user['contrasena']) === false){
                header("Location: ../login.php?error=invalid_credentials");
                exit();
            }
            $correo = $user['correo'];
            $nombre = $this->NameUser($this->conexion, $correo);
            $id = strval($user['id_usuario']);// Convert to string
            session_start();
            $_SESSION['user'] = $user['correo'];
            $_SESSION['iduser'] = $id;
            $_SESSION['nombre'] = $nombre['nombre'];
            $k=$nombre['id_persona'];
            header("Location: ../dashboard/start.php");
            exit();
        } else {
            header("Location: ../login.php?error=invalid_credentials");
            exit();
        }
    }

    private function NameUser($conn,$correo){
        $stmt = $conn->prepare("SELECT id_persona, nombre FROM persona WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}
