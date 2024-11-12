<?php
use cesar\ProyectoTest\Config\Parameters;

$peliculas = $data["peliculas"]??NULL;
?>

<div class="container container-lista-peliculas">
            <h2>Todas las Peliculas:</h2>
            <div class="listar-todas-cards">
            <?php if (!empty($peliculas)){ ?>
                    <?php foreach ($peliculas as $pelicula){ ?>
                        <?php $idCodificado = base64_encode($pelicula->id) ?>
                        
                        <div class="card-listar card">
                            <a class="favorito" href="#">
                                <span class="material-symbols-outlined">favorite</span>
                            </a>
                            <a href="<?=Parameters::$BASE_URL . "contenido/verContenido/" . "$pelicula->slug"?>" class="card-link">
                                <img class="card-img" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $pelicula->portada ?>" alt="<?=$pelicula->titulo ?>">
                                <div class="card-overlay">
                                    <div class="card-title-lista">
                                        <?=$pelicula->titulo ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                    <p>No hay películas disponibles en este momento.</p>
                <?php }; ?>
            </div>