<?php
use cesar\ProyectoTest\Config\Parameters;

$resultados = $data["resultados"]??NULL;

?>

<div class="container container-lista-resultadosBusqueda">
            <h2>Resultados:</h2>
            <div class="listar-todas-cards">
            <?php if (!empty($resultados)){ ?>
                    <?php foreach ($resultados as $resultado){ ?>      
                        <div class="card-listar card">
                            <a class="favorito" href="#">
                                <span class="material-symbols-outlined">favorite</span>
                            </a>
                            <a href="<?=Parameters::$BASE_URL . "ver/" . $resultado->slug ?>" class="card-link">
                                <img class="card-img" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $resultado->portada ?>" alt="<?=$resultado->titulo ?>">
                                <div class="card-overlay">
                                    <div class="card-title-lista"><?=$resultado->titulo ?></div>
                                </div>
                            </a>
                        </div>
                        <div class="card-listar card">
                            <a class="favorito" href="#">
                                <span class="material-symbols-outlined">favorite</span>
                            </a>
                            <a href="<?=Parameters::$BASE_URL . "ver/" . $resultado->slug ?>" class="card-link">
                                <img class="card-img" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $resultado->portada ?>" alt="<?=$resultado->titulo ?>">
                                <div class="card-overlay">
                                    <div class="card-title-lista"><?=$resultado->titulo ?></div>
                                </div>
                            </a>
                        </div>
                        <div class="card-listar card">
                            <a class="favorito" href="#">
                                <span class="material-symbols-outlined">favorite</span>
                            </a>
                            <a href="<?=Parameters::$BASE_URL . "ver/" . $resultado->slug ?>" class="card-link">
                                <img class="card-img" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $resultado->portada ?>" alt="<?=$resultado->titulo ?>">
                                <div class="card-overlay">
                                    <div class="card-title-lista"><?=$resultado->titulo ?></div>
                                </div>
                            </a>
                        </div>
                        <div class="card-listar card">
                            <a class="favorito" href="#">
                                <span class="material-symbols-outlined">favorite</span>
                            </a>
                            <a href="<?=Parameters::$BASE_URL . "ver/" . $resultado->slug ?>" class="card-link">
                                <img class="card-img" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $resultado->portada ?>" alt="<?=$resultado->titulo ?>">
                                <div class="card-overlay">
                                    <div class="card-title-lista"><?=$resultado->titulo ?></div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                    <p>No hay resultados.</p>
                <?php }; ?>
            </div>