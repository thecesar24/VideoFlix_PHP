<?php
use cesar\ProyectoTest\Config\Parameters;

$peliculas = $data["peliculas"]??NULL;
$series = $data["series"]??NULL;
$cortos = $data["cortos"]??NULL;
$documentales = $data["documentales"]??NULL;

?>
<div id="carouselExample" class="carousel slide" data-ride="carousel" data-interval="3000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?= Parameters::$BASE_URL . 'assets/img/pelis-españolas.jpeg' ?>" class="d-block w-100" alt="Películas Españolas">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>HOLA</h5>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellendus alias eligendi accusantium dignissimos repellat blanditiis tenetur quia omnis ea minus dolorum doloribus maxime quas architecto consectetur, suscipit, quam nemo eveniet!</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="<?= Parameters::$BASE_URL . 'assets/img/pelis-españolas.jpeg' ?>" class="d-block w-100" alt="Películas Españolas">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>HOLA</h5>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellendus alias eligendi accusantium dignissimos repellat blanditiis tenetur quia omnis ea minus dolorum doloribus maxime quas architecto consectetur, suscipit, quam nemo eveniet!</p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="peliculas">
                <h2>Peliculas</h2>
                <div class="slider-container">
                <?php if (!empty($peliculas)){ ?>
                    <?php foreach ($peliculas as $pelicula){ ?>
                        <div class="card">
                            <img class="card-img-top" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $pelicula->portada ?>" alt="<?=$pelicula->titulo ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?=$pelicula->titulo ?></h5>
                                <a href="<?=Parameters::$BASE_URL . 'ver/' . $pelicula->slug?>" class="btn btn-primary">Ver detalles</a>
                            </div>
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                    <p>No hay películas disponibles en este momento.</p>
                <?php }; ?>
                </div>
                <div class="ver-mas-container">
                    <a href="<?= Parameters::$BASE_URL . 'Contenido/Peliculas' ?>"><input type="button" class="ver-mas" value="Ver Mas"></a>
                </div>
            </div>
            <div class="series">
                <h2>Series</h2>
                <div class="slider-container">
                <?php if (!empty($series)){ ?>
                    <?php foreach ($series as $serie){ ?>
                        <div class="card">
                            <img class="card-img-top" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $serie->portada ?>" alt="<?=$serie->titulo ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?=$serie->titulo ?></h5>
                                <a href="<?=Parameters::$BASE_URL . 'ver/' . $serie->slug?>"  class="btn btn-primary">Ver detalles</a>
                            </div>
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                    <p>No hay series disponibles en este momento.</p>
                <?php }; ?>   
                </div>
                <div class="ver-mas-container">
                    <a href="<?= Parameters::$BASE_URL . 'Contenido/Series' ?>"><input type="button" class="ver-mas" value="Ver Mas"></a>
                </div>
            </div>
            <div class="cortos">
                <h2>Cortos</h2>
                <div class="slider-container">
                <?php if (!empty($cortos)){ ?>
                    <?php foreach ($cortos as $corto){ ?>
                        <div class="card">
                            <img class="card-img-top" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $corto->portada ?>" alt="<?=$corto->titulo ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?=$corto->titulo ?></h5>
                                <a href="<?=Parameters::$BASE_URL . 'ver/' . $corto->slug?>" class="btn btn-primary">Ver detalles</a>
                            </div>
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                    <p>No hay cortos disponibles en este momento.</p>
                <?php }; ?>   
                </div>
                <div class="ver-mas-container">
                    <a href="<?= Parameters::$BASE_URL . 'Contenido/Cortos' ?>"><input type="button" class="ver-mas" value="Ver Mas"></a>
                </div>
            </div>
            <div class="documentales">
                <h2>Documentales</h2>
                <div class="slider-container">
                <?php if (!empty($documentales)){ ?>
                    <?php foreach ($documentales as $documental){ ?>
                        <div class="card">
                            <img class="card-img-top" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $documental->portada ?>" alt="<?=$documental->titulo ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?=$documental->titulo ?></h5>
                                <a href="<?=Parameters::$BASE_URL . 'ver/' . $documental->slug?>" class="btn btn-primary">Ver detalles</a>
                            </div>
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                    <p>No hay documentales disponibles en este momento.</p>
                <?php }; ?> 
                </div>
                <div class="ver-mas-container">
                    <a href="<?= Parameters::$BASE_URL . 'Contenido/Documentales' ?>"><input type="button" class="ver-mas" value="Ver Mas"></a>
                </div>
            </div>

