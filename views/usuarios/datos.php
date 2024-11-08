<?php

use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Config\Parameters;

if (!Authentication::isUserLogged()) {
    header("Location: " . Parameters::$BASE_URL . "Usuario/login");
    exit();
}

$userEntity = $_SESSION['user'];
$datos = $data['datos']??NULL;

if (isset($_SESSION['mensaje'])) {
    echo "<div id='mensaje-temporal' >{$_SESSION['mensaje']}</div>";
    unset($_SESSION['mensaje']);
}

?>

    <div class="container container-datos">
        <div class="datos">
            <div class="datos-usuario">
                <h1>Datos del Usuario</h1>  

                <p><strong>Nombre:</strong> <?= $datos->nombre ?></p>
                <p><strong>Apellidos:</strong> <?= $datos->apellidos ?></p>
                <p><strong>Correo Electrónico:</strong> <?= $datos->email ?></p>
                <p><strong>Teléfono:</strong> <?= $datos->telefono ?></p>
                <p><strong>Nombre de Usuario:</strong> <?= $datos->username ?></p>

                <h2>Opciones</h2>
                <div class="datos-opciones">
                    <a href="<?= Parameters::$BASE_URL . "Usuario/editDatos" ?>"><button>Editar Datos</button></a>
                    <a href="<?= Parameters::$BASE_URL . "Usuario/closeSession" ?>"><button>Cerrar Sesión</button></a>
                </div>
            </div>
        </div>
