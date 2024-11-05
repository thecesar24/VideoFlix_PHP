<?php

use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Config\Parameters;

if (!Authentication::isUserLogged()) {
    header("Location: " . Parameters::$BASE_URL . "Usuario/login");
    exit();
}

// Obtén la información del usuario desde la sesión
$userEntity = $_SESSION['user'];
$validationsError = $data['validationsError'];

?>

<?php if (!empty($validationsError)): ?>
    <div class="error-messages">
        <?php foreach ($validationsError as $error): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

    <div class="container container-datos">
        <div class="datos">
            <form action="<?=Parameters::$BASE_URL . "Usuario/updateDatos"?>" method="post">
                <h1>Datos del Usuario</h1>
                <p>
                    <strong>Nombre:</strong>
                    <input type="text" name="" id="" value="<?= $userEntity->getNombre() ?>">
                </p>
                <p>
                    <strong>Apellidos:</strong>
                    <input type="text" name="" id="" value="<?= $userEntity->getApellidos() ?>">
                </p>
                <p>
                    <strong>Correo Electrónico:</strong>
                    <input type="email" name="" id="" value="<?= $userEntity->getEmail() ?>">
                </p>
                <p>
                    <strong>Teléfono:</strong>
                    <input type="tel" name="" id="" value="<?= $userEntity->getTelefono() ?>">
                </p>
                <p>
                    <strong>Nombre de Usuario:</strong>
                    <input type="text" name="" id="" value="<?= $userEntity->getUsername() ?>">
                </p>
                <input type="submit" value="Editar">
            </form>
            
            <h2>Opciones</h2>
            <div class="datos-opciones">
                <a href="<?= Parameters::$BASE_URL . "Usuario/editDatos" ?>"><button>Editar Datos</button></a>
                <a href="<?= Parameters::$BASE_URL . "Usuario/closeSession" ?>"><button>Cerrar Sesión</button></a>
            </div>
        </div>
