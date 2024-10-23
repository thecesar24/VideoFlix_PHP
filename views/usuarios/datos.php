<?php

use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Config\Parameters;

if (!Authentication::isUserLogged()) {
    header("Location: " . Parameters::$BASE_URL . "Usuario/login");
    exit();
}

// Obtén la información del usuario desde la sesión
$userEntity = $_SESSION['user']; // Asegúrate de que la sesión tenga esta variable
?>

    <div class="container container-datos">
        <div class="datos">
            <h1>Datos del Usuario</h1>
            <p><strong>Nombre:</strong> <?= $userEntity->getNombre() ?></p>
            <p><strong>Apellidos:</strong> <?= $userEntity->getApellidos() ?></p>
            <p><strong>Correo Electrónico:</strong> <?= $userEntity->getEmail() ?></p>
            <p><strong>Teléfono:</strong> <?= $userEntity->getTelefono() ?></p>
            <p><strong>Nombre de Usuario:</strong> <?= $userEntity->getUsername() ?></p>
            
            <h2>Opciones</h2>
            <div class="datos-opciones">
                <a href="<?= Parameters::$BASE_URL . "Usuario/edit" ?>"><button>Editar Datos</button></a>
                <a href="<?= Parameters::$BASE_URL . "Usuario/closeSession" ?>"><button>Cerrar Sesión</button></a>
            </div>
        </div>
