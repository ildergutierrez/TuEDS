<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="icon" href="../../img/TUEDS.svg" type="image/svg+xml" />
    <title>Configuración</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="btn btn-light " data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                <img class="logo" src="../../img/TUEDS.svg" alt="Logo" /></a>
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img class="logo" src="../../img/TUEDS.svg" alt="Logo" /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="list-group-item">
                            <a class="nav-link active" aria-current="page" href="start.php">Inicio</a>
                        </li>
                        <li class="list-group-item">
                            <a class="nav-link" href="estaciones.php">Estaciones</a>
                        </li>
                        <li class="list-group-item">
                            <a class="nav-link" href="usuarios.php">Usuarios</a>
                        </li>
                        <li class="list-group-item">
                            <a class="nav-link" href="#">Configuración</a>
                        </li>

                    </ul>
                    <form class="d-flex" role="search">
                        <a href="../php/close.php" class="nav-item" id="btn-login">
                            <span class="material-symbols-outlined span">logout</span></a>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <!-- Cnva -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Opciones</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="list-group">
                    <ul class="navbar-nav">
                        <li class="list-group-item"><a href="start.php" class="nav-link active" aria-current="page">Inicio</a></li>
                        <li class="list-group-item"><a href="estaciones.php" class="nav-link">Estaciones</a></li>
                        <li class="list-group-item"><a href="usuarios.php" class="nav-link ">Usuarios</a></li>
                        <li class="list-group-item"><a href="#" class="nav-link ">Configuración</a></li>
                        <li class="list-group-item"> <a href="../php/close.php" class="btn btn-light " id="btn-login"> <span class="material-symbols-outlined span">logout</span></a></li>
                </div>

            </div>
        </div>
        <!-- fin del offcanva -->
        <div class="container">
            <h1 class="text-center">Servicios</h1>
            <p class="text-center">Sistema de gestión de estaciones de servicio</p>
            <div class="row">
                <div class="col-md-6 ">

                    <div class="container my-5">
                        <h4 class="mb-4 text-center">Servicios disponibles</h4>
                        <div id="barras-servicios" class="list-group"></div>
                    </div>

                </div>
                <div class="col-6">
                    <div class="container my-5">
                        <h4 class="mb-4 text-center">Distribución de combustibles</h4>
                        <canvas id="graficoCombustibles" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                     <div class="container my-5">
                        <h4 class="mb-4 text-center">Barras (Combustibe) </h4>
                        <div id="barras-Combustibe" class="list-group"></div>
                    </div>
                </div>
                
        </div>

    </main>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col  text-center">
                    <img src="../../img/TUEDS.svg" alt="logo" class="img-fluid" style="max-width: 30px" />
                    <p>&copy; 2025 Tu EDS.<br /> Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="../js/servicios.js"></script>
</body>

</html>