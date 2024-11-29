<?php
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;

$cortos = $data["cortos"]??NULL;
?>

<div class="container container-lista-cortos">
            <h2>Todos los Cortos:</h2>
            <div class="listar-todas-cards">
            <?php if (!empty($cortos)){ ?>
                    <?php foreach ($cortos as $corto){ ?>
                        <?php $idCodificado = base64_encode($corto->id) ?>
                        
                        <div class="card-listar card">
                            <?php if(Authentication::isUserLogged()){ ?>
                            <div class="favorito">
                                <span class="material-symbols-outlined">favorite</span>
                            </div>
                            <?php } ?>
                            <a href="<?=Parameters::$BASE_URL . "contenido/verContenido?idContenido="?><?php echo urlencode($idCodificado) ?>" class="card-link">
                                <img class="card-img" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $corto->portada ?>" alt="<?=$corto->titulo ?>">
                                <div class="card-overlay">
                                    <div class="card-title-lista"><?=$corto->titulo ?></div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                    <p>No hay cortos disponibles en este momento.</p>
                <?php }; ?>
            </div>