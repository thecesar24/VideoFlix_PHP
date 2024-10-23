<?php 
    use cesar\ProyectoTest\Config\Parameters
?>


    <div class="container container-dashboard">
        <h1>Bienvenido, <?= htmlspecialchars($usuario->getNombre()) ?>!</h1>
        <p>Aquí están los videos que has estado viendo:</p>

        <section class="seguir-viendo">
            <?php if (!empty($videosVistos)) : ?>
                <ul class="video-list">
                    <?php foreach ($videosVistos as $video) : ?>
                        <li class="video-item">
                            <a href="<?= Parameters::$BASE_URL ?>/videos/ver/<?= $video->id ?>">
                                <h3><?= htmlspecialchars($video->titulo) ?></h3>
                                <p>Duración: <?= htmlspecialchars($video->duracion) ?></p>
                                <p>Última visualización: <?= htmlspecialchars($video->fecha_visualizacion) ?></p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>No has visto ningún video recientemente.</p>
            <?php endif; ?>
        </section>