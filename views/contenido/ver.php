<?php
use cesar\ProyectoTest\Config\Parameters;

$contenido = $data["contenido"]??NULL;
$recomendadas = $data["recomendadas"]??NULL;
$comentarios = $data["comentarios"]??NULL;

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
                        <div class="comentario">
                            <span>
                                <?=$comentario->id_usuario?>:
                            </span>
                            <?=$comentario->comentario?>
                        </div>
                    <?php } ?>
                    <div class="insertar-comentario">
                        <form action="<?=Parameters::$BASE_URL . "Comentarios/InsertarComentario?slug=" . $contenido->slug?>" method="post">
                            <label for="idComentario">Inserta un comentario:</label>
                            <input type="text" name="comentario" id="idComentario">
                            <input type="submit" value="Confirmar">
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