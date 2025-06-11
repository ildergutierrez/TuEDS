<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: dashboard/start.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="../img/TUEDS.svg" type="image/svg+xml" />
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>

<body>
    <header></header>
    <main>
        <div class="row">
            <div class="col-6">
                <div class="col">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-8">
                                <img src="../img/TUEDS.svg" alt="TUEDS Logo" class="img-fluid">
                                <h2 class="text-center">Bienvenido a TU EDS</h2>
                                <p class="text-center">Sistema de gestión de las Estaciones de Servicio</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="col">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-8">
                                <h1 class="text-center">Iniciar sesión</h1>
                                <p class="text-center">Por favor, ingresa tus credenciales para acceder al sistema.</p>
                                <form action="login.php" method="post">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Usuario</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group flex-nowrap">
                                            <input id="password" type="password" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
                                            <span onclick="password()" class="input-group-text material-symbols-outlined ojo" id="visible">visibility</span>
                                        </div>

                                    </div>
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col  text-center">
                    <img src="../img/TUEDS.svg" alt="logo" class="img-fluid" style="max-width: 30px" />
                    <p>&copy; 2025 Tu EDS.<br /> Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>
     <script src="js/script.js"></script>
        
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>