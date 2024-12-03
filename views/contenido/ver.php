<?php
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;

$contenido = $data["contenido"]??NULL;
$recomendadas = $data["recomendadas"]??NULL;
$comentarios = $data["comentarios"]??NULL;
$idUsuario = 0;

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
                    <iframe id="youtube-iframe" src="<?=$contenido->video?>" frameborder="0" sandbox="allow-scripts allow-same-origin" allowfullscreen></iframe>
                </div>       
            </div>     
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
                <h2>Series Recomendadas</h2>
                <div class="recomendadas-cards">
                    <?php foreach($recomendadas as $recomendada) { ?>
                    <div class="card">
                        <a href="<?=Parameters::$BASE_URL . 'ver/' . $recomendada->slug?>" class="card-link">
                            <img class="card-img" src="<?=Parameters::$BASE_URL . 'assets/img/Portadas/' . $recomendada->portada ?>" alt="Card image">
                            <div class="card-overlay">
                                <div class="card-title"><?=$recomendada->titulo?></div>
                            </div>
                        </a>
                    </div> 
                    <div class="card">
                        <a href="<?=Parameters::$BASE_URL . 'ver/' . $recomendada->slug?>" class="card-link">
                            <img class="card-img" src="<?=Parameters::$BASE_URL . 'assets/img/Portadas/' . $recomendada->portada ?>" alt="Card image">
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