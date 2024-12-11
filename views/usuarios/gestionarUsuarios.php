<?php

use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Controllers\ViewController;
use cesar\ProyectoTest\Config\Parameters;

if (!Authentication::isAdminLogged()) {
    ViewController::showError(403);
    exit();
}

$usuarios = $data['todosUsuarios']??NULL;

if (isset($_SESSION['errores'])) {
    foreach ($_SESSION['errores'] as $error) {
        echo "<p class='error'>$error</p>"; // Muestra cada mensaje de error
    }
    unset($_SESSION['errores']); // Limpiar los errores después de mostrarlos
}


if (isset($_SESSION['mensaje'])) {
    echo "<div id='mensaje-temporal' >{$_SESSION['mensaje']}</div>";
    unset($_SESSION['mensaje']);
}

?>

    <div class="container container-gestion">
    <article class="article-gestion">
        <h2>Todos los Usuarios:</h2>
        <a href="">
            <button class="gestion-buton-add">
                <span class="material-symbols-outlined">add</span>
                <span>
                    Registrar Usuarios
                </span>
            </button>
        </a>
    </article>
    <article class="tabla tabla-todosUsuarios">
        <div class="fila fila1">
            <div class="celda">Nombre</div>
            <div class="celda">Apellidos</div>
            <div class="celda">Email</div>
            <div class="celda">Username</div>
            <div class="celda">Rol</div>
            <div class="celda">Estado</div>
            <div class="celda">Acciones</div>
        </div> 
        <?php foreach ($usuarios as $usuario) { ?>
            <div class="fila fila2 <?php if($usuario->estado == 0){echo 'eliminado';} ?>">
                <div class="celda"><?=$usuario->nombre?></div>
                <div class="celda"><?=$usuario->apellidos?></div>
                <div class="celda"><?=$usuario->email?></div>
                <div class="celda"><?=$usuario->username?></div>
                <div class="celda"><?=$usuario->rol?></div>
                <?php if ($usuario->estado == 1) {
                echo '<div class="celda activo">Activo</div>';  
                } else {
                    echo '<div class="celda baja">Baja</div>';  
                } ?>
                <div class="celda acciones">
                    <a href="<?=Parameters::$BASE_URL . "Usuario/editarUsuario?idUsuario=" . $usuario->id?>">
                        <span class="material-symbols-outlined">edit</span>
                    </a>
                    <?php if ($usuario->estado == 1) { ?>
                        <a href="<?=Parameters::$BASE_URL . "Usuario/cambiarEstadoUsuario?idUsuario=" . $usuario->id?>">
                            <span class="material-symbols-outlined activo">toggle_on</span>
                        </a>
                    <?php } ?>
                    <?php if ($usuario->estado == 0) { ?>
                        <a href="<?=Parameters::$BASE_URL . "Usuario/cambiarEstadoUsuario?idUsuario=" . $usuario->id?>">
                            <span class="material-symbols-outlined baja">toggle_off</span>
                        </a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </article>
