<?php
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;

$series = $data["series"]??NULL;
$favoritos = $data["favoritos"]??NULL;
?>

<div class="container container-lista-series">
            <h2>Todas las Series:</h2>
            <div class="listar-todas-cards">
            <?php if (!empty($series)){ ?>
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
                foreach ($series as $serie) { ?>
                    <div class="card-listar card">
                        <?php if (Authentication::isUserLogged()) { 
                            $isFavorito = isset($favoritos_ids[$serie->id]); ?>
                            <div class="favorito <?= $isFavorito ? 'clicked' : '' ?>" data-id="<?= htmlspecialchars($serie->id) ?>">
                                <span class="material-symbols-outlined">favorite</span>
                            </div>
                        <?php } ?>
                        
                        <a href="<?= htmlspecialchars(Parameters::$BASE_URL . "Contenido/verInfo?slug=" . $serie->slug) ?>" class="card-link">
                        <?php if (isset($serie->portada)) { ?>
                            <img class="card-img" src="<?= htmlspecialchars(Parameters::$BASE_URL . 'assets/img/Portadas/' . $serie->portada) ?>" alt="<?= htmlspecialchars($serie->titulo) ?>">
                        <?php }else { ?>
                            <img class="card-img" src="<?= htmlspecialchars(Parameters::$BASE_URL . 'assets/img/Portadas/Default_Portada.png') ?>" alt="<?= htmlspecialchars($serie->titulo) ?>">
                        <?php } ?>
                            <div class="card-overlay">
                                <div class="card-title-lista">
                                    <?= htmlspecialchars($serie->titulo) ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
                <?php }else{ ?>
                    <p>No hay series disponibles en este momento.</p>
                <?php }; ?>
            </div>