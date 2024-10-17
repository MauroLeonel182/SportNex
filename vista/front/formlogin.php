<?php include "vista/layouts/header.php";?>
<?php
        if(isset($_SESSION['usuario'])){
           header("location: index.php");
           };
?>
<style>


main {
    width: 100%;
    padding: 20px;
    margin: 10px;
    text-decoration: none;
    margin-top: 200px;
}

.contendor__todo {
    width: 100%;
    max-width: 800px;
    margin: auto;
    position: relative;
}

.caja__trasera {
    width: 100%;
    padding: 10px 20px;
    display: flex;
    justify-content: center;
    backdrop-filter: blur(10px);
    background-color: rgb(0, 0, 0);
    border-radius: 0.5rem;
}

.caja__trasera div {
    margin: 100px 40px;
    color: white;
    transition: all 500ms;
    text-align: center;
}

.caja__trasera div p,
.caja__trasera div button {
    margin-top: 30px;
}

.caja__trasera div h3 {
    font-weight: 400;
    font-size: 26px;
}

.caja__trasera button {
    padding: 10px 40px;
    border: 2px solid #fff;
    background: transparent;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    color: rgb(255, 255, 255);
    border-radius: 0.5rem;
    outline: none;
    transition: all 300ms;
}

.caja__trasera button:hover {
    background: #ff0000;
    color: #ffffff;
    border-color: #ffffff;
}

/* Formularios */
.contenedor__login-register {
    display: flex;
    align-items: center;
    width: 100%;
    max-width: 380px;
    position: relative;
    top: -185px;
    left: 10px;
    transition: left 500ms cubic-bezier(0.175, 0.885, 0.320, 1.275);
}

.contenedor__login-register form {
    width: 100%;
    padding: 80px 20px;
    background-image: radial-gradient(circle, #000000, #000000, #000000, #000000, #000000);
    position: absolute;
    border-radius: 2px;
}

.contenedor__login-register form h2 {
    font-size: 30px;
    text-align: center;
    margin-bottom: 20px;
    color: #ffffff;
}

.contenedor__login-register form input {
    width: 100%;
    margin-top: 20px;
    padding: 10px;
    border: none;
    background: rgb(255, 255, 255);
    font-size: 16px;
    outline: none;
    border-radius: 0.5rem;
}

.contenedor__login-register form button {
    padding: 11px 48px;
    border: 2px solid #fff;
    margin-top: 40px;
    font-size: 14px;
    background-color: rgb(0, 0, 0);
    color: rgb(255, 255, 255);
    cursor: pointer;
    outline: none;
    border-radius: 0.5rem;
}

.contenedor__login-register form button:hover {
    background: #ff0000;
    color: rgb(255, 255, 255);
    border-color: #ffffff;
}

.formulario__login {
    opacity: 1;
    display: block;
}

.formulario__register {
    display: none;
}

/* Responsive Desing*/

@media screen and (max-width: 850px) {

    main {
        margin-top: 50px;
        text-decoration: none;
    }

    .caja__trasera {
        max-width: 350px;
        height: 300px;
        flex-direction: column;
        margin: auto;
    }

    .caja__trasera div {
        margin: 0px;
        position: absolute;
    }

    /*Formularios*/

    .contenedor__login-register {
        top: -10px;
        left: -5px;
        margin: auto;
    }

    .contenedor__login-register form {
        position: relative;
    }
}

/* Estilo para la barra de carga */
.loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

/* Estilo para ocultar el contenido mientras se carga */
.content {
    opacity: 1;
    transition: opacity 0.5s ease;
}

.content.loading {
    opacity: 0.5;
    pointer-events: none;
}
</style>
<!-- Incluir Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body>
    <main>
        <div class="contendor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesion para acceder</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesion</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aun No Tienes una Cuenta?</h3>
                    <p>Registrarme para Acceder</p>
                    <button id="btn__registrarse">Registrarme</button>
                    <button id="btn__recuperacion">Olvide mi Contraseña</button>
                </div>
            </div>

            <!--Formulario de login y Registro-->
            <div class="contenedor__login-register">

                <!--Login-->
                <form action="<?php echo urlsite ?>?page=loginout" method="post" class="formulario__login">
                    <h2>Iniciar Sesion</h2>
                    <input type="text" placeholder="Email" maxlength="30" name="email">
                    <input type="password" placeholder="Password" name="contrasena">
                    <button>Acceder</button>
                    <?php 
                        if (isset($_GET['msg'])) {
                            $msg = '';
                            $type = 'error'; // Tipo de alerta predeterminado
                            switch ($_GET['msg']) {
                                case 'error':
                                    $msg = 'La cuenta no existe o bien la contraseña es incorrecta,Por Favor verifique sus datos.';
                                    $type = 'error';
                                    break;
                            }
                            echo "<script>
                                    Swal.fire({
                                    title: '¡Atención!',
                                    text: '$msg',
                                    icon: '$type',
                                    confirmButtonText: 'Aceptar'
                                    });
                                </script>";
                        }
                    ?>
                </form>

                <!-- Formulario de registro -->
                <form action="?page=register" method="POST" class="formulario__register">
                    <h2>Registrarme</h2>
                    <input type="text" placeholder="Nombre" name="nombre" required
                        value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
                    <input type="text" placeholder="Apellido" name="apellido" required
                        value="<?php echo isset($_POST['apellido']) ? htmlspecialchars($_POST['apellido']) : ''; ?>">
                    <input type="email" placeholder="Email" name="email" required
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    <input type="text" placeholder="DNI" name="dni" maxlength="8" required
                        value="<?php echo isset($_POST['dni']) ? htmlspecialchars($_POST['dni']) : ''; ?>">
                    <input type="text" placeholder="Teléfono" name="telefono" maxlength="10"
                        value="<?php echo isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>">
                    <input type="text" placeholder="Nombre de usuario" name="nombre_usuario" required
                        value="<?php echo isset($_POST['nombre_usuario']) ? htmlspecialchars($_POST['nombre_usuario']) : ''; ?>">
                    <input type="password" placeholder="Contraseña" name="contrasena" required>
                    <input type="text" name="rol" value="cliente" style="display: none;">
                    <button type="submit">Registrarme</button>

                    <?php
                        // Mostrar el mensaje y la alerta con SweetAlert si existe un resultado
                        if (!empty($resultado['mensaje'])) {
                            echo "<script>
                                    Swal.fire({
                                        title: '¡Atención!',
                                        text: '" . $resultado['mensaje'] . "',
                                        icon: '" . $resultado['type'] . "',
                                        confirmButtonText: 'Aceptar'
                                    });
                                </script>";
                        }
                        
                    ?>
                </form>


                <!--Formulario de Recuperación-->
                <form action="<?php echo urlsite ?>?page=recuperar_password" method="POST" class="formulario__recuperar"
                    style="display: none;">
                    <h2>Recuperar Contraseña</h2>
                    <input type="email" placeholder="Email" name="email" required>
                    <button type="submit">Enviar enlace de recuperación</button>
                    <?php
                        // Mostrar el mensaje y la alerta con SweetAlert si existe un resultado
                        if (!empty($resultado['mensaje'])) {
                            echo "<script>
                                    Swal.fire({
                                        title: '¡Atención!',
                                        text: '" . $resultado['mensaje'] . "',
                                        icon: '" . $resultado['type'] . "',
                                        confirmButtonText: 'Aceptar'
                                    });
                                </script>";
                        }
                    ?>
                </form>


            </div>
        </div>
    </main>
    <script>
    document.getElementById("btn__iniciar-sesion").addEventListener("click", iniciarSesion);
    document.getElementById("btn__registrarse").addEventListener("click", register);
    document.getElementById("btn__recuperacion").addEventListener("click", recuperarPassword);
    window.addEventListener("resize", anchoPagina);

    // Declaración de Variables
    var contenedor_login_register = document.querySelector(".contenedor__login-register");
    var formulario_login = document.querySelector(".formulario__login");
    var formulario_register = document.querySelector(".formulario__register");
    var formulario_recuperar = document.querySelector(".formulario__recuperar");
    var caja_trasera_login = document.querySelector(".caja__trasera-login");
    var caja_trasera_register = document.querySelector(".caja__trasera-register");

    function anchoPagina() {
        if (window.innerWidth > 850) {
            caja_trasera_login.style.display = "block";
            caja_trasera_register.style.display = "block";
        } else {
            caja_trasera_register.style.display = "block";
            caja_trasera_register.style.opacity = "1";
            caja_trasera_login.style.display = "none";
            formulario_login.style.display = "block";
            formulario_register.style.display = "none";
            formulario_recuperar.style.display = "none";
            contenedor_login_register.style.left = "0px";
        }
    }
    anchoPagina();

    function iniciarSesion() {
        if (window.innerWidth > 850) {
            formulario_register.style.display = "none";
            formulario_recuperar.style.display = "none";
            contenedor_login_register.style.left = "10px";
            formulario_login.style.display = "block";
            caja_trasera_register.style.opacity = "1";
            caja_trasera_login.style.opacity = "0";
        } else {
            formulario_register.style.display = "none";
            formulario_recuperar.style.display = "none";
            contenedor_login_register.style.left = "0px";
            formulario_login.style.display = "block";
            caja_trasera_register.style.display = "block";
            caja_trasera_login.style.display = "none";
        }
    }

    function register() {
        if (window.innerWidth > 850) {
            formulario_login.style.display = "none";
            formulario_recuperar.style.display = "none";
            formulario_register.style.display = "block";
            contenedor_login_register.style.left = "410px";
            caja_trasera_register.style.opacity = "0";
            caja_trasera_login.style.opacity = "1";
        } else {
            formulario_login.style.display = "none";
            formulario_recuperar.style.display = "none";
            formulario_register.style.display = "block";
            contenedor_login_register.style.left = "0px";
            caja_trasera_register.style.display = "none";
            caja_trasera_login.style.display = "block";
            caja_trasera_login.style.opacity = "1";
        }
    }

    function recuperarPassword() {
        if (window.innerWidth > 850) {
            formulario_login.style.display = "none";
            formulario_register.style.display = "none";
            formulario_recuperar.style.display = "block";
            contenedor_login_register.style.left = "410px"; // Mover el formulario hacia la derecha
            caja_trasera_register.style.opacity = "0"; // Ocultar caja trasera
            caja_trasera_login.style.opacity = "1"; // Mostrar caja trasera de login
        } else {
            formulario_login.style.display = "none";
            formulario_register.style.display = "none";
            formulario_recuperar.style.display = "block";
            contenedor_login_register.style.left = "0px";
            caja_trasera_register.style.display = "block";
            caja_trasera_login.style.display = "none";
        }
    }
    </script>
    <script>
    // Función para permitir solo letras y espacios
    function validarSoloLetras(input) {
        input.value = input.value.replace(/[^A-Za-z\s]/g, '');
    }

    // Función para permitir solo números
    function validarSoloNumeros(input) {
        input.value = input.value.replace(/[^\d]/g, '');
    }

    // Función para permitir solo letras, números y espacios en el nombre de usuario
    function validarSoloLetrasNumeros(input) {
        input.value = input.value.replace(/[^A-Za-z0-9]/g, '');
    }
    </script>


</body>

</html>