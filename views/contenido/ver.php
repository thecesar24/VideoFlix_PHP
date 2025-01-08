<?php
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;

$contenido = $data["contenido"]??NULL;
$recomendadas = $data["recomendadas"]??NULL;
$comentarios = $data["comentarios"]??NULL;
$capitulos = $data["capitulos"]??NULL;
$idUsuario = 0;

//PARA SERIES:
    $capituloActual = $data["capituloActual"]??NULL;
    $capituloAnterior = $data["capituloAnterior"]??NULL;
    $capituloSiguiente = $data["capituloSiguiente"]??NULL;
    $temporadas = $data["temporadas"]??NULL;
    $capitulosPorTemporada = $data["capitulosPorTemporada"]??NULL;

if (Authentication::isUserLogged()) {
    $idUsuario = $data["idUsuario"]??NULL;
}

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

    <div class="container container-ver-video">
        <div class="flex-1">
            <h1><?=$contenido->titulo?></h1>
            <div class="video-responsive">
                <div class="iframe-container">
                    <iframe id="youtube-iframe" src="<?=$contenido->video . '?enablejsapi=1'?>" frameborder="0" sandbox="allow-scripts allow-same-origin" allowfullscreen></iframe>
                </div>    
                <!-- <a href="<?=Parameters::$BASE_URL?>SeguirViendo/Add?slug=<?=$contenido->slug?>">HOLAAAAAAAAA</a>-->
            </div>     
            <?php if ($contenido->tipo_contenido == 'series') { ?>
            <div class="seccion-episodios">
                <?php 
                    if ($capituloAnterior) {
                        echo '<a href="'. Parameters::$BASE_URL . 'verSerie/' . $contenido->slug . '/'. $capituloAnterior['num_temporada'] . '/'. $capituloAnterior['num_capitulo'].'"><span class="material-symbols-outlined">chevron_left</span></a>';
                    } else {
                        echo '<a href="'. Parameters::$BASE_URL . 'verSerie/' . $contenido->slug . '/'. $capituloActual['num_temporada'] . '/'. $capituloActual['num_capitulo'].'"><span class="material-symbols-outlined">chevron_left</span></a>';
                    } ?>
                    <a id="botonMedioEpisodios" href="<?=Parameters::$BASE_URL . 'Contenido/verInfo?slug=' . $contenido->slug?>"><span class="material-symbols-outlined">menu</span></a>
                    <?php 
                    if ($capituloSiguiente) {
                        echo '<a href="'. Parameters::$BASE_URL . 'verSerie/' . $contenido->slug . '/'. $capituloSiguiente['num_temporada'] . '/'. $capituloSiguiente['num_capitulo'].'"><span class="material-symbols-outlined">chevron_right</span></a>';
                    } else {
                        echo '<a href="'. Parameters::$BASE_URL . 'verSerie/' . $contenido->slug . '/'. $capituloActual['num_temporada'] . '/'. $capituloActual['num_capitulo'].'"><span class="material-symbols-outlined">chevron_right</span></a>';
                    } ?>
            </div>
            <?php } ?>
            <div class="seccion-comentarios">
                <button id="mostrar-comentarios">Mostrar Comentarios</button>
                <div class="comentarios" id="comentarios">
                    <?php foreach($comentarios as $comentario) { ?>
                        <div class="comentario <?php if(($comentario->id_usuario) == ($idUsuario)){echo ' comentarioPropio';}else{echo' comentarioOtro';} ?>">
                            <span>
                                <?=$comentario->username?>:    
                            </span>
                            <span>
                                <?=$comentario->comentario?>
                            </span>
                        </div>
                    <?php } ?>
                    <?php if(empty($comentarios)) {
                        echo '<p class="comentario">No hay comentarios todavia.</p>';
                    } ?>
                    <div class="insertar-comentario">
                        <form action="<?=Parameters::$BASE_URL . "Comentarios/InsertarComentario?slug=" . $contenido->slug?>" method="post">
                            <div class="input-contenedor">
                                <label for="idComentario">Comentar:</label>
                                <div class="input-wrapper">
                                    <small id="contador">0/150</small>
                                    <input type="text" name="comentario" id="idComentario" maxlength="150">
                                </div>
                            </div>
                            <input type="submit" id="insertar-comentario-Confirm" value="Confirmar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-2">
            <div class="recomendadas">
            <?php if ($contenido->tipo_contenido == 'peliculas') { ?>
                <h2>Peliculas Recomendadas</h2>
            <?php }elseif($contenido->tipo_contenido == 'series') { ?>
                <h2>Series Recomendadas</h2>
            <?php }elseif($contenido->tipo_contenido == 'cortos') { ?>
                <h2>Cortos Recomendados</h2>
            <?php }elseif($contenido->tipo_contenido == 'documentales') { ?>
                <h2>Documentales Recomendados</h2>
            <?php } ?>
                <div class="recomendadas-cards">
                    <?php foreach($recomendadas as $recomendada) { ?>
                    <div class="card">
                        <a href="<?=Parameters::$BASE_URL . 'ver/' . $recomendada->slug?>" class="card-link">
                        <?php if (isset($recomendada->portada)) { ?>
                            <img class="card-img" src="<?=Parameters::$BASE_URL . 'assets/img/Portadas/' . $recomendada->portada ?>" alt="Card image">
                        <?php }else { ?>
                            <img class="card-img" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/Default_Portada.png' ?>" alt="<?=$recomendada->titulo ?>">
                        <?php } ?>
                            <div class="card-overlay">
                                <div class="card-title"><?=$recomendada->titulo?></div>
                            </div>
                        </a>
                    </div> 
                    <?php } ?>                                                                                                                                                               
                </div>
            </div>  
        </div>
    </div>

<script>
    const slug = "<?php echo $contenido->slug; ?>";
</script>