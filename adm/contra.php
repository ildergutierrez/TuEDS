<?php

if (!isset($_GET['correo'])) {
    header("Location: login.php");
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
    <title>Nueva contraseña</title>
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
                                    <?php
                                    if (isset($_GET['error']) && $_GET['error'] == 'invalid_credentials') {
                                        echo ' <div class="alerts"><p> Verifique el E-mail.<br> Si no tienes una cuenta, por favor contacta al administrador.</p>     </div>';
                                    } ?>

                                    <form action="php/Update.php?recuperar=1" method="post">
                                        <input type="hidden" name="correo" value="<?php echo htmlspecialchars($_GET['correo']); ?>">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Contraseña</label>
                                            <div class="input-group flex-nowrap">
                                                <input id="password" name="password" type="password" class="form-control" placeholder="Password
                                            " aria-label="Username" aria-describedby="addon-wrapping" required>
                                                <span onclick="password()" class="input-group-text material-symbols-outlined ojo" id="visible">visibility</span>
                                            </div>
                                        </div>

                                        <center>
                                            <button type="submit" id="registro" disabled class="btn btn-dark">Recuperer Contraseña</button>
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