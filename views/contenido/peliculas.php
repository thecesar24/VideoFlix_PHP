<?php
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;

$peliculas = $data["peliculas"]??NULL;

?>

<div class="container container-lista-peliculas">
            <h2>Todas las Peliculas:</h2>
            <div class="listar-todas-cards">
            <?php if (!empty($peliculas)){ ?>
                    <?php foreach ($peliculas as $pelicula){ ?>
                        <div class="card-listar card">
                            <?php if(Authentication::isUserLogged()){ ?>
                            <div class="favorito" data-id= "<?=$pelicula->id?>">
                                <span class="material-symbols-outlined">favorite</span>
                            </div>
                            <?php } ?>
                            
                            <a href="<?=Parameters::$BASE_URL . "ver/" . "$pelicula->slug"?>" class="card-link">
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