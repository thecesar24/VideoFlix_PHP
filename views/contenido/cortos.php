<?php
use cesar\ProyectoTest\Config\Parameters;

$cortos = $data["cortos"]??NULL;
?>

<div class="container container-lista-cortos">
            <h2>Todos los Cortos:</h2>
            <div class="listar-todas-cards">
            <?php if (!empty($cortos)){ ?>
                    <?php foreach ($cortos as $corto){ ?>
                        <div class="card">
                            <a href="ver.html" class="card-link">
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