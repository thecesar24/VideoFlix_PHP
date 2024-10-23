<?php
use cesar\ProyectoTest\Config\Parameters;

$peliculas = $data["peliculas"]??NULL;
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
                            <img class="card-img-top" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $pelicula->portada ?>" alt="<?= htmlspecialchars($pelicula->titulo) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?=$pelicula->titulo ?></h5>
                                <a href="<?= Parameters::$BASE_URL . 'pelicula/' . $pelicula->id ?>" class="btn btn-primary">Ver detalles</a>
                            </div>
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                    <p>No hay películas disponibles en este momento.</p>
                <?php }; ?>
                </div>
                <div class="ver-mas-container">
                    <a href="<?= Parameters::$BASE_URL . '/Contenido/getAllPeliculas' ?>"><input type="button" class="ver-mas" value="Ver Mas"></a>
                </div>
            </div>
            <div class="series">
                <h2>Series</h2>
                <div class="slider-container">
                    
                </div>
                <div class="ver-mas-container">
                    <a href="#"><input type="button" class="ver-mas" value="Ver Mas"></a>
                </div>
