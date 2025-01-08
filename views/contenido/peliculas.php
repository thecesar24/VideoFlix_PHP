<?php
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;

$peliculas = $data["peliculas"]??NULL;
$favoritos = $data["favoritos"]??NULL;

unset($_SESSION['mensaje']);
if (isset($_SESSION['mensaje'])) {
    echo "<div id='mensaje-temporal' >{$_SESSION['mensaje']}</div>";
    unset($_SESSION['mensaje']);
}

?>

<div class="container container-lista-peliculas">
            <h2>Todas las Peliculas:</h2>
            <div class="listar-todas-cards">
            <?php if (!empty($peliculas)){ ?>
                <?php 
                $favoritos_ids = [];
                if (Authentication::isUserLogged()) {
                    $userEntity = $_SESSION['user'];
                    $idUsuario = $userEntity->getId();
                    
                    foreach ($favoritos as $favorito) {
                        if ($favorito['id_usuario'] == $idUsuario) {
                            $favoritos_ids[$favorito['id_contenido']] = true;
                        }
                    }
                }
                foreach ($peliculas as $pelicula) { ?>
                    <div class="card-listar card">
                        <?php if (Authentication::isUserLogged()) { 
                            $isFavorito = isset($favoritos_ids[$pelicula->id]); ?>
                            <div class="favorito <?= $isFavorito ? 'clicked' : '' ?>" data-id="<?= htmlspecialchars($pelicula->id) ?>">
                                <span class="material-symbols-outlined">favorite</span>
                            </div>
                        <?php } ?>
                        
                        <a href="<?= htmlspecialchars(Parameters::$BASE_URL . "Contenido/verInfo?slug=" . $pelicula->slug) ?>" class="card-link">
                        <?php if (isset($pelicula->portada)) { ?>
                            <img class="card-img" src="<?= htmlspecialchars(Parameters::$BASE_URL . 'assets/img/Portadas/' . $pelicula->portada) ?>" alt="<?= htmlspecialchars($pelicula->titulo) ?>">
                        <?php }else { ?>
                            <img class="card-img" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/Default_Portada.png' ?>" alt="<?=$pelicula->titulo ?>">
                        <?php } ?>
                            <div class="card-overlay">
                                <div class="card-title-lista">
                                    <?= htmlspecialchars($pelicula->titulo) ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
                <?php }else{ ?>
                    <p>No hay películas disponibles en este momento.</p>
                <?php }; ?>
            </div>