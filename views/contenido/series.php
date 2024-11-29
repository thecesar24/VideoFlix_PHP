<?php
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;

$series = $data["series"]??NULL;
?>

<div class="container container-lista-series">
            <h2>Todas las Series:</h2>
            <div class="listar-todas-cards">
            <?php if (!empty($series)){ ?>
                    <?php foreach ($series as $serie){ ?>
                        <?php $idCodificado = base64_encode($serie->id) ?>
                        
                        <div class="card-listar card">
                            <?php if(Authentication::isUserLogged()){ ?>
                            <div class="favorito">
                                <span class="material-symbols-outlined">favorite</span>
                            </div>
                            <?php } ?>
                            <a href="<?=Parameters::$BASE_URL . "contenido/verContenido?idContenido="?><?php echo urlencode($idCodificado) ?>" class="card-link">
                                <img class="card-img" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $series->portada ?>" alt="<?=$series->titulo ?>">
                                <div class="card-overlay">
                                    <div class="card-title-lista"><?=$series->titulo ?></div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                    <p>No hay series disponibles en este momento.</p>
                <?php }; ?>
            </div>