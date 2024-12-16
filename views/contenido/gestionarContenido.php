<?php
use cesar\ProyectoTest\Config\Parameters;

$contenidos = $data["contenidos"]??NULL;
$generos = $data["generos"]??NULL;
$idiomas = $data["idiomas"]??NULL;
$directores = $data["directores"]??NULL;

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
    <div class="article-gestion"> 
        <h2>Todos los Contenidos:</h2>
        <a href="<?=Parameters::$BASE_URL . "Contenido/addContenido"?>">
            <button class="gestion-buton-add">
                <span class="material-symbols-outlined">Add</span>
                <span>
                    Añadir Contenido
                </span>
            </button>
        </a>
    </div>
    <article class="tabla tabla-todosContenidos">
        <div class="fila fila1">
            <div class="celda">Titulo</div>
            <div class="celda">Año</div>
            <div class="celda">Tipo</div>
            <div class="celda">Genero</div>
            <div class="celda">Idioma</div>
            <div class="celda">Director</div>
            <div class="celda">Acciones</div>
        </div>
            <?php if (!empty($contenidos)){ ?>
                <?php foreach ($contenidos as $contenido) { ?>
                    <div class="fila fila2 <?php if($contenido['estado'] == Parameters::$ESTADO_BAJA){echo 'eliminado';} if ($contenido['estado'] == Parameters::$ESTADO_PENDIENTE){echo 'pendiente';}?>">
                        <div class="celda"><?=$contenido['titulo']?></div>
                        <div class="celda"><?=$contenido['year']?></div>
                        <div class="celda"><?=$contenido['tipo_contenido']?></div>
                        <?php foreach($generos as $genero) { ?>
                            <?php if($contenido['id_genero'] == $genero['id']) { ?>
                                <div class="celda"><?=$genero['nombre']?></div>
                            <?php } ?>
                        <?php } ?>
                        <?php foreach($idiomas as $idioma) { ?>
                            <?php if($contenido['id_idioma'] == $idioma['id']) { ?>
                                <div class="celda"><?=$idioma['nombre']?></div>
                            <?php } ?>
                        <?php } ?>
                        <?php 
                        $directorEncontrado = false;
                        foreach($directores as $director) { ?>
                            <?php if($contenido['id_director'] == $director['id']) { 
                                $directorEncontrado = true; ?>
                                <div class="celda"><?=$director['nombre'] . ' ' . $director['apellidos']?></div>
                            <?php break; } ?>
                        <?php } if (!$directorEncontrado) { ?>
                            <div class="celda">-</div>
                        <?php } ?>    
                        <div class="celda acciones">
                            <a href="<?=Parameters::$BASE_URL . "Contenido/editarContenido?idContenido=" . $contenido['id']?>">
                                <span class="material-symbols-outlined">edit</span>
                            </a>
                            <?php if ($contenido['estado'] == Parameters::$ESTADO_ALTA) { ?>
                                <a href="<?=Parameters::$BASE_URL . "Contenido/cambiarEstadoContenido?idContenido=" . $contenido['id']?>">
                                    <span class="material-symbols-outlined activo">toggle_on</span>
                                </a>
                            <?php } ?>
                            <?php if ($contenido['estado'] == Parameters::$ESTADO_BAJA) { ?>
                                <a href="<?=Parameters::$BASE_URL . "Contenido/cambiarEstadoContenido?idContenido=" . $contenido['id']?>">
                                    <span class="material-symbols-outlined baja">toggle_off</span>
                                </a>
                            <?php } ?>
                        </div>   
                    </div>
                <?php } ?>
                <?php }else{ ?>
                    <div class="fila fila-sinContenido">
                        <p>No hay contenidos disponibles en este momento.</p>
                    </div>
            <?php }; ?>
    </article>
    <article class="leyenda">
        <p>Pendiente:</p>
        <span class="leyenda-pendiente material-symbols-outlined">radio_button_unchecked</span>
        <p>Baja:</p>
        <span class="leyenda-baja material-symbols-outlined">radio_button_unchecked</span>
    </article>