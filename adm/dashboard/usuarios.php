<?php
session_start();
$mensaje = "";
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}
//si existe un get echo con valor 1, se muestra un mensaje de éxito
if (isset($_GET['echo']) && $_GET['echo'] == 1) {
    $mensaje = "<div class='alert alert-success' role='alert'> <div class='modal-header'>
        <span class='material-symbols-outlined'>check_circle</span> Administrador registrado correctamente.
       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div></div>";
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
    <title>Usuarios</title>
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
                            <a class="nav-link" href="estaciones.php">Estaciones</a>
                        </li>
                        <li class="list-group-item">
                            <a class="nav-link" href="#">Usuarios</a>
                        </li>
                        <li class="list-group-item">
                            <a class="nav-link" href="configuracion.php">Configuración</a>
                        </li>
                    </ul>

                    <!-- Corrección: formulario de logout que usa POST -->
                    <form class="d-flex" method="POST" action="../php/close.php">
                        <button type="submit" class="btn btn-outline-danger" id="btn-login">
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
                        <li class="list-group-item"><a href="estaciones.php" class="nav-link">Estaciones</a></li>
                        <li class="list-group-item"><a href="#" class="nav-link ">Usuarios</a></li>
                        <li class="list-group-item"><a href="configuracion.php" class="nav-link ">Configuración</a></li>
                        <li class="list-group-item"> <a href="../php/close.php" class="btn btn-light " id="btn-login"> <span class="material-symbols-outlined span">logout</span></a></li>
                </div>

            </div>
        </div>
        <!-- fin del offcanva -->
        <div class="container">
            <?php
            if ($mensaje != "") {
                echo $mensaje; // Mostrar mensaje de éxito si se ha registrado correctamente
            }
            ?>
            <form action="../php/RegistroUsuario.php" method="POST"> <!-- Formulario de registro  que envía los datos a Registro.php por formato POST, la imagen se envía como archivo -->
                <div class="row">
                    <div class="col-12">
                        <h2 class="text-center">Registro de Administrador</h2>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" placeholder="Nombre" name="nombre" required>
                                <label for="floatingInputGrid1">Nombre</label>
                            </div>
                        </div><br>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" placeholder="Apellido" name="apellido" required>
                                <label for="floatingInputGrid6">Apellido</label>
                            </div>
                        </div><br>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" placeholder="Telefono" name="tel" required>
                                <label for="floatingInputGrid5">Telefono</label>
                            </div>
                        </div><br>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" placeholder="Direccion" name="direccion" require>
                                <label for="floatingInputGrid4">Direccion</label>
                            </div>
                        </div>
                        <br>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="email" class="form-control" placeholder="Correo" name="email" require>
                                <label for="floatingInputGrid4">Correo</label>
                            </div>
                        </div>
                        <br>
                        <div class="mb-3">
                            <div class="input-group flex-nowrap">
                                <input id="password" minlength="8" name="pass" type="password" class="form-control" placeholder="Password" aria-label="Username" aria-describedby="addon-wrapping" required>
                                <span onclick="password()" class="input-group-text material-symbols-outlined ojo" id="visible">visibility</span>
                            </div>
                        </div>
                    </div>

                </div>
                <br><br>
                <center>
                    <button type="submit" class="btn btn-dark" disabled id="registro">Registrar Admin</button>
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
    <script src="../js/script.js"></script>
    <script>
        if (document.getElementById('password')) {
            document.getElementById('password').addEventListener('input', function() {
                const mensajeId = 'password-alert';
                let mensajeExistente = document.getElementById(mensajeId);
                const botonRegistro = document.getElementById('registro');

                if (!mensajeExistente) {
                    mensajeExistente = document.createElement('div');
                    mensajeExistente.id = mensajeId;
                    mensajeExistente.className = 'alert alert-success mt-2';
                    mensajeExistente.style.width = '100%';
                    this.closest('.mb-3').appendChild(mensajeExistente);
                }

                // Expresiones regulares
                const mayuscula = /[A-Z]/;
                const minuscula = /[a-z]/;
                const numero = /[0-9]/;
                const especial = /[\'^£$%&*()}.:{@#~?><>,;´¨¿?"°!¡`|=_+¬-]/;

                // Verificaciones
                const cumpleMayuscula = mayuscula.test(this.value);
                const cumpleMinuscula = minuscula.test(this.value);
                const cumpleNumero = numero.test(this.value);
                const cumpleEspecial = especial.test(this.value);
                const cumpleLongitud = this.value.length >= 8;

                // Mostrar los resultados
                mensajeExistente.innerHTML = `
            <ul class="mb-0">
                <li>${cumpleLongitud ? '✔️' : '❌'} Mínimo 8 caracteres</li>
                <li>${cumpleMayuscula ? '✔️' : '❌'} Al menos una mayúscula</li>
                <li>${cumpleMinuscula ? '✔️' : '❌'} Al menos una minúscula</li>
                <li>${cumpleNumero ? '✔️' : '❌'} Al menos un número</li>
                <li>${cumpleEspecial ? '✔️' : '❌'} Al menos un carácter especial</li>
            </ul>
        `;

                // Habilitar botón si cumple todo
                const esValido = cumpleMayuscula && cumpleMinuscula && cumpleNumero && cumpleEspecial && cumpleLongitud;

                if (botonRegistro) {
                    botonRegistro.disabled = !esValido;
                }

                // Si el campo está vacío, quitar mensaje y deshabilitar botón
                if (this.value.length === 0) {
                    mensajeExistente.remove();
                    if (botonRegistro) botonRegistro.disabled = true;
                }
            });
        }
    </script>

</body>

</html>