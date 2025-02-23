<?php

use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Config\Parameters;

if (!Authentication::isUserLogged()) {
    header("Location: " . Parameters::$BASE_URL . "Usuario/login");
    exit();
}

// Obtén la información del usuario desde la sesión
$userEntity = $_SESSION['user'];

if (isset($_SESSION['errores'])) {
    foreach ($_SESSION['errores'] as $error) {
        echo "<p class='error'>$error</p>"; // Muestra cada mensaje de error
    }
    unset($_SESSION['errores']); // Limpiar los errores después de mostrarlos
}

?>
    <div class="container container-datos">
        <div class="datos editar-datos">
            <form action="<?=Parameters::$BASE_URL . "Usuario/updateDatos"?>" method="post">
                <h1>Datos del Usuario</h1>
                <p>
                    <strong>Nombre:</strong>
                    <input type="text" name="nombre" id="" value="<?= $userEntity->getNombre() ?>">
                </p>
                <p>
                    <strong>Apellidos:</strong>
                    <input type="text" name="apellidos" id="" value="<?= $userEntity->getApellidos() ?>">
                </p>
                <p>
                    <strong>Correo Electrónico:</strong>
                    <input type="email" name="email" id="" value="<?= $userEntity->getEmail() ?>">
                </p>
                <p>
                    <strong>Nombre de Usuario:</strong>
                    <input type="text" name="username" id="" value="<?= $userEntity->getUsername() ?>">
                </p>
                <input id="botonConfirmar" type="submit" value="Confirmar">
            </form>
            
            <h2>Opciones</h2>
            <div class="datos-opciones">
                <a href="<?= Parameters::$BASE_URL . "Usuario/editDatos" ?>"><button>Editar Datos</button></a>
                <a href="<?= Parameters::$BASE_URL . "Usuario/closeSession" ?>"><button>Cerrar Sesión</button></a>
            </div>
        </div>
