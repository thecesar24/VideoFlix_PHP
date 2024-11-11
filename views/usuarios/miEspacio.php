<?php 
    use cesar\ProyectoTest\Config\Parameters;

    $contenidos = $data["contenidos"] ?? NULL;
    $userEntity = $data["userEntity"] ?? NULL;
?>

    <div class="container container-dashboard">
        <h1>Bienvenido, <?= htmlspecialchars($userEntity->getNombre()) ?>!</h1>
        <p>Aquí están los videos que has estado viendo:</p>

        <section class="seguir-viendo">
            <?php if (!empty($contenidos)) : ?>
                <ul class="video-list">
                <div class="slider-container">
                    <?php foreach ($contenidos as $contenido) : ?>
                        <div class="card">
                            <img class="card-img-top" src="<?= Parameters::$BASE_URL . 'assets/img/Portadas/' . $contenido->portada ?>" alt="<?=$contenido->titulo ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?=$contenido->titulo ?></h5>
                                <a href="<?= Parameters::$BASE_URL . 'contenido/' . $contenido->id ?>" class="btn btn-primary">Ver detalles</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                </ul>
            <?php else : ?>
                <p>No has visto ningún video recientemente.</p>
            <?php endif; ?>
        </section>