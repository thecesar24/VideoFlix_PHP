<?php
use cesar\ProyectoTest\Config\Parameters;

$peliculas = $data["peliculas"]??NULL;
$series = $data["series"]??NULL;
$cortos = $data["cortos"]??NULL;
$documentales = $data["documentales"]??NULL;

if (isset($_SESSION['errores'])) {
    foreach ($_SESSION['errores'] as $error) {
        echo "<p class='error'>$error</p>"; // Muestra cada mensaje de error
    }
    unset($_SESSION['errores']); // Limpiar los errores después de mostrarlos
}

?>
<div id="carouselExample" class="carousel slide" data-ride="carousel" data-interval="400000">
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
                            <?php if (isset($pelicula->portada)) { ?>
                                <img class="card-img-top" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $pelicula->portada ?>" alt="<?=$pelicula->titulo ?>">
                            <?php }else { ?>
                                <img class="card-img-top" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/Default_Portada.png' ?>" alt="<?=$pelicula->titulo ?>">
                            <?php } ?>
                            <div class="card-body">
                                <h5 class="card-title"><?=$pelicula->titulo ?></h5>
                                <a href="<?=Parameters::$BASE_URL . 'Contenido/verInfo?slug=' . $pelicula->slug?>" class="btn btn-primary">Ver detalles</a>
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
                        <?php if (isset($serie->portada)) { ?>
                            <img class="card-img-top" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $serie->portada ?>" alt="<?=$serie->titulo ?>">
                        <?php }else { ?>
                            <img class="card-img-top" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/Default_Portada.png' ?>" alt="<?=$serie->titulo ?>">
                        <?php } ?>
                            <div class="card-body">
                                <h5 class="card-title"><?=$serie->titulo ?></h5>
                                <a href="<?=Parameters::$BASE_URL . 'Contenido/verInfo?slug=' . $serie->slug?>"  class="btn btn-primary">Ver detalles</a>
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

