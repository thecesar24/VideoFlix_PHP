<?php
use cesar\ProyectoTest\Config\Parameters;

?>

    <div class="container">
        <h1>Bienvenido a nuestra aplicación</h1>
        <p>
            <?php if (isset($_SESSION['errorLogin'])): ?>
                <div class='alerta alerta-error'><?= $_SESSION['errorLogin'] ?></div>
                <?php unset($_SESSION['errorLogin']); ?>
            <?php endif; ?>
        </p>
        <p>Por favor, <a href="<?= Parameters::$BASE_URL . 'Usuario/login' ?>">inicie sesión</a> para continuar.</p>

