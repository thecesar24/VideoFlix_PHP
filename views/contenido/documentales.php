<?php
use cesar\ProyectoTest\Config\Parameters;

$documentales = $data["documentales"]??NULL;
?>

<div class="container container-lista-documentales">
            <h2>Todos los Documentales:</h2>
            <div class="listar-todas-cards">
            <?php if (!empty($documentales)){ ?>
                    <?php foreach ($documentales as $documental){ ?>
                        <div class="card">
                            <a href="ver.html" class="card-link">
                                <img class="card-img" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $documental->portada ?>" alt="<?=$documental->titulo ?>">
                                <div class="card-overlay">
                                    <div class="card-title-lista"><?=$documental->titulo ?></div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                    <p>No hay documentales disponibles en este momento.</p>
                <?php }; ?>
            </div>