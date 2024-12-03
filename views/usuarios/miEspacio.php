<?php 
    use cesar\ProyectoTest\Config\Parameters;
    use cesar\ProyectoTest\Helpers\Authentication;

    $contenidos = $data["contenidos"] ?? NULL;
    $userEntity = $data["userEntity"] ?? NULL;
    $favoritos = $data["favoritos"] ?? NULL;
?>

    <div class="container container-dashboard">
        <h1>Bienvenido, <?= htmlspecialchars($userEntity->getNombre()) ?>!</h1>
        <p>Aquí están los videos que has estado viendo:</p>

        <section class="seguir-viendo">
            <?php if (!empty($contenidos)){ ?>
                <ul class="video-list">
                <div class="slider-container">
                    <?php foreach ($contenidos as $contenido){ ?>
                        <div class="card">
                            <img class="card-img-top" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $contenido->portada ?>" alt="<?=$contenido->titulo ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?=$contenido->titulo ?></h5>
                                <a href="<?= Parameters::$BASE_URL . 'contenido/' . $contenido->id ?>" class="btn btn-primary">Ver detalles</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                </ul>
            <?php }else{ ?>
                <p>No has visto ningún video recientemente.</p>
            <?php } ?>
        </section>
        <section>
            <h2>Contenido Favorito:</h2>
            <?php if (!empty($favoritos)) { ?>    
                <ul class="video-list">
                    <div class="slider-container">
                    <?php
                        $favoritos_ids = [];
                        if (Authentication::isUserLogged()) {
                            foreach ($favoritos as $favorito) {
                                $favoritos_ids[$favorito->id_contenido] = true;
                            }
                        }
                        foreach($favoritos as $favorito) { ?>
                            <div class="card">
                                <?php if (Authentication::isUserLogged()) { 
                                    $isFavorito = isset($favoritos_ids[$favorito->id]); ?>
                                    <div class="favorito <?= $isFavorito ? 'clicked' : '' ?>" data-id="<?= htmlspecialchars($favorito->id) ?>">
                                        <span class="material-symbols-outlined">favorite</span>
                                    </div>
                                <?php } ?>
                                <img class="card-img-top" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $favorito->portada ?>" alt="<?=$favorito->titulo ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?=$favorito->titulo ?></h5>
                                    <a href="<?= Parameters::$BASE_URL . 'ver/' . $favorito->slug ?>" class="btn btn-primary">Ver detalles</a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </ul>
            <?php } else {
                echo 'No tienes contenidos favoritos';
            } ?>
        </section>