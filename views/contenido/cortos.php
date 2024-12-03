<?php
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;

$cortos = $data["cortos"]??NULL;
$favoritos = $data["favoritos"]??NULL;
?>

<div class="container container-lista-cortos">
            <h2>Todos los Cortos:</h2>
            <div class="listar-todas-cards">
            <?php if (!empty($cortos)){ ?>
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
                foreach ($cortos as $corto) { ?>
                    <div class="card-listar card">
                        <?php if (Authentication::isUserLogged()) { 
                            $isFavorito = isset($favoritos_ids[$corto->id]); ?>
                            <div class="favorito <?= $isFavorito ? 'clicked' : '' ?>" data-id="<?= htmlspecialchars($corto->id) ?>">
                                <span class="material-symbols-outlined">favorite</span>
                            </div>
                        <?php } ?>
                        
                        <a href="<?= htmlspecialchars(Parameters::$BASE_URL . "ver/" . $corto->slug) ?>" class="card-link">
                            <img class="card-img" src="<?= htmlspecialchars(Parameters::$BASE_URL . 'assets/img/Portadas/' . $corto->portada) ?>" 
                                 alt="<?= htmlspecialchars($corto->titulo) ?>">
                            <div class="card-overlay">
                                <div class="card-title-lista">
                                    <?= htmlspecialchars($corto->titulo) ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
                <?php }else{ ?>
                    <p>No hay cortos disponibles en este momento.</p>
                <?php }; ?>
            </div>