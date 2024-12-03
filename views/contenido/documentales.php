<?php
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;

$documentales = $data["documentales"]??NULL;
$favoritos = $data["favoritos"]??NULL;
?>

<div class="container container-lista-documentales">
            <h2>Todos los Documentales:</h2>
            <div class="listar-todas-cards">
            <?php if (!empty($documentales)){ ?>
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
                    foreach ($documentales as $documental) { ?>
                        <div class="card-listar card">
                            <?php if (Authentication::isUserLogged()) { 
                                $isFavorito = isset($favoritos_ids[$documental->id]); ?>
                                <div class="favorito <?= $isFavorito ? 'clicked' : '' ?>" data-id="<?= htmlspecialchars($documental->id) ?>">
                                    <span class="material-symbols-outlined">favorite</span>
                                </div>
                            <?php } ?>
                        
                        <a href="<?= htmlspecialchars(Parameters::$BASE_URL . "ver/" . $documental->slug) ?>" class="card-link">
                            <img class="card-img" src="<?= htmlspecialchars(Parameters::$BASE_URL . 'assets/img/Portadas/' . $documental->portada) ?>" 
                                 alt="<?= htmlspecialchars($documental->titulo) ?>">
                            <div class="card-overlay">
                                <div class="card-title-lista">
                                    <?= htmlspecialchars($documental->titulo) ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
                <?php }else{ ?>
                    <p>No hay documentales disponibles en este momento.</p>
                <?php }; ?>
            </div>