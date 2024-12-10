<?php

use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Controllers\ViewController;
use cesar\ProyectoTest\Config\Parameters;

if (!Authentication::isAdminLogged()) {
    ViewController::showError(403);
    exit();
}

$usuarios = $data['todosUsuarios']??NULL;

?>

    <div class="container container-gestionUsers">
    <article>
        <h2>Todos los Usuarios:</h2>
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
            <div class="fila fila2">
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
