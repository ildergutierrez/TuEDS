<?php
$mensaje = '';

if (isset($_GET['respuesta'])) {
    if ($_GET['respuesta'] == 1) {
        $mensaje = "<div class='alert alert-success' role='alert'> <div class='modal-header'>
        <span class='material-symbols-outlined'>check_circle</span> Se envió un correo de verificación a tu E-mail.
       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div></div>";
    }
    if ($_GET['respuesta'] == 2) {
        $mensaje = "<div class='alert alert-success' role='alert'> <div class='modal-header'>
        <span class='material-symbols-outlined'>close</span> opss! Algo salió mal, intente de nuevo.
       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div></div>";
    }
    if ($_GET['respuesta'] == 0) {
        $mensaje = "<div class='alert alert-success' role='alert'> <div class='modal-header'>
        <span class='material-symbols-outlined'>mail </span> El correo electrónico no está registrado.
       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div></div>";
    }
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

<body class="body">
    <header>
        <nav class=" navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="login.php"><img src="../img/TUEDS.svg" alt="TUEDS Logo" class="img-fluid" style="max-width: 30px;"> TU EDS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h1>Recuperar Contraseña</h1>
                    <?php
                                    if (isset($_GET['respuesta'])) {
                                        echo $mensaje;
                                    } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
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
                <div class="col-7">
                    <div class="col">
                        <div class="container">
                            <div class="row d-flex justify-content-center">
                                <div class="col-8">
                                    <p class="text-center">Por favor, ingresa tu correo electrónico para recuperar tu contraseña.</p>
                                    

                                    <form action="php/restpassword.php" method="post">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Usuario</label>
                                            <input type="email" class="form-control" id="username" name="username" required>
                                        </div>

                                        <center>
                                            <button type="submit" class="btn btn-dark">Recuperer Contraseña</button>
                                        </center>
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