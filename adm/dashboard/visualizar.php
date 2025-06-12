<?php
session_start();
$mensaje = "";
$id = "";
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}
//si existe un get echo con valor 1, se muestra un mensaje de éxito
if (isset($_GET['echo']) && $_GET['echo'] == 1) {
    $mensaje = "<div class='alert alert-success' role='alert'> <div class='modal-header'>
        <span class='material-symbols-outlined'>check_circle</span> Estación Actualizada correctamente.
       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div></div>";
}
if (isset($_GET['id'])=="" || $_GET['id'] == null) {
    echo "<script>alert('No se ha seleccionado ninguna estación.');  window.location.href='listado.php';</script>";
}else{
    $id= $_GET['id'];
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
    <link rel="icon" href="../../img/TUEDS.svg" />
    <title>Estaciones</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="btn btn-light" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                <img class="logo" src="../../img/TUEDS.svg" alt="Logo" />
            </a>
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
                            <a class="nav-link" href="#">Estaciones</a>
                        </li>
                        <li class="list-group-item">
                            <a class="nav-link" href="usuarios.php">Usuarios</a>
                        </li>
                        <li class="list-group-item">
                            <a class="nav-link" href="configuracion.php">Configuración</a>
                        </li>
                    </ul>

                    <!-- Logout Form with POST -->
                    <form class="d-flex" method="POST" action="../php/close.php">
                        <button type="submit" class="btn btn-outline-danger">
                            <span class="material-symbols-outlined">logout</span>
                        </button>
                    </form>
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
                        <li class="list-group-item"><a href="#" class="nav-link">Estaciones</a></li>
                        <li class="list-group-item"><a href="usuarios.php" class="nav-link ">Usuarios</a></li>
                        <li class="list-group-item"><a href="configuracion.php" class="nav-link ">Configuración</a></li>
                        <li class="list-group-item"> <a href="../php/close.php" class="btn btn-light " id="btn-login"> <span class="material-symbols-outlined span">logout</span></a></li>
                </div>
            </div>
        </div>
        <!-- fin del offcanva -->
        <div style="margin-top: 20px; width: 90%; margin: auto;">
            <div class="row">
                <div class="col-10">
                    <h1 class="text-center">Registro de EDS</h1>
                </div>
                <div class="col-2">
                    <h1 class="d-flex justify-content-end my-4"><a href="listado.php" title="Listado" class="btn btn-dark"><span class="material-symbols-outlined">format_list_numbered</span></a></h1>
                </div>
            </div>
            <?php
            if ($mensaje != "") {
                echo $mensaje; // Mostrar mensaje de éxito si se ha registrado correctamente
            }
            ?>
            <div id="imagen-preview" class="text-center mb-3">
                <img src="../../img/eds.png" alt="Imagen de la EDS" class="img-fluid" style="max-width: 200px; max-height: 200px;">
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>"> <!-- Campo oculto para almacenar el ID de la estación de servicio -->
            <!-- HJADJKAS -->
            <form action="" method="POST" enctype="multipart/form-data"> <!-- Formulario de registro  que envía los datos a Registro.php por formato POST, la imagen se envía como archivo -->
                <div class="row">
                    <div class="col-6">
                        <h2 class="text-center">Datos de la EDS</h2>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" placeholder="Nombre EDS" name="nombre_eds" required>
                                <label for="floatingInputGrid1">EDS</label>
                            </div>
                        </div><br>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" placeholder="Latitud" name="lat" required>
                                <label for="floatingInputGrid6">Latitud</label>
                            </div>
                        </div><br>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" placeholder="Longitud" name="lon" required>
                                <label for="floatingInputGrid5">Longitud</label>
                            </div>
                        </div><br>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="file" class="form-control" name="imagen" placeholder="Imagen" accept="image/*">
                                <label for="floatingInputGrid4">Imagen</label>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="col-6">
                        <h2 class="text-center">Valor Combustible</h2>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" placeholder="Gasolina" name="gasolina" required>
                                <label for="floatingInputGrid3">Gasolina Corriente</label>
                            </div>
                        </div><br>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" placeholder="Gasolina Extra" name="extra" required>
                                <label for="floatingInputGrid2">Gasolina Extra</label>
                            </div>
                        </div><br>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" placeholder="Diesel" name="diesel" required>
                                <label for="floatingInputGrid1">Diesel</label>
                            </div>
                        </div>
                        <br>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" placeholder="Glp" name="gas" required>
                                <label for="floatingInputGrid0">Gas</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Servicios -->
                <div class="row">
                    <h2 class="text-center">Servicos de la EDS</h2>
                    <!-- Tienda - hospedaje - Baños -->
                    <div class="col-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault1" value="0" name="tienda">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Tienda</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault2" value="0" name="hospedaje">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Hospedaje</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault3" value="0" name="banos">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Baños</label>
                        </div>
                    </div>
                    <!-- mecanica -lavadero - Restaurante -->
                    <div class="col-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefaul4t" value="0" name="taller">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Taller</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault5" value="0" name="lavado">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Auto-Lavado</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault6" value="0" name="restaurante">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Restaurante</label>
                        </div>
                    </div>
                    <!-- Carga -Cajero - montallanta -->
                    <div class="col-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault7" value="0" name="carga">
                            <label class="form-check-label" for="flexSwitchCheckDefault">carga EV</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault8" value="0" name="cajero">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Cajero</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault9" value="0" name="llanteria">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Llanteria</label>
                        </div>
                    </div>
                </div>
                <br><br>
                <center>
                    <button type="submit" class="btn btn-dark">Registrar EDS</button>
                    <button type="reset" class="btn btn-secondary">Limpiar</button>
                </center>
            </form>
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
    <script src="../js/visualizar.js"></script>
</body>

</html>