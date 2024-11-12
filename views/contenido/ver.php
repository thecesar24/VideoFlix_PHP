<?php
use cesar\ProyectoTest\Config\Parameters;

$contenido = $data["contenido"]??NULL;
$recomendadas = $data["recomendadas"]??NULL;

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
                <button>Mostrar Comentarios</button>
            </div>
        </div>
        <div class="flex-2">
            <div class="recomendadas">
                <h2>Series Recomendadas</h2>
                <div class="recomendadas-cards">
                    <?php foreach($recomendadas as $recomendada) { ?>
                    <div class="card">
                        <a href="URL_DEL_ENLACE" class="card-link">
                            <img class="card-img" src="<?=Parameters::$BASE_URL . 'assets/img/Portadas/' . $recomendada->portada ?>" alt="Card image">
                            <div class="card-overlay">
                                <div class="card-title"><?=$recomendada->titulo?></div>
                            </div>
                        </a>
                    </div> 
                    <div class="card">
                        <a href="URL_DEL_ENLACE" class="card-link">
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