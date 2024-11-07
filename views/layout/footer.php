<?php
	use cesar\ProyectoTest\Config\Parameters;
?>
        </div>
        <div class="clearfix"></div>
    </main>
<footer class="text-white text-center py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?=Parameters::$BASE_URL . "Inicio/index" ?>" class="text-white">Inicio</a></li>
                        <li><a href="#" class="text-white">Series</a></li>
                        <li><a href="#" class="text-white">Películas</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contacto</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Email</a></li>
                        <li><a href="#" class="text-white">Teléfono</a></li>
                        <li>
                            <a href="#"><img class="social-media" src="<?=Parameters::$BASE_URL?>assets/img/Social_Media/instagram.png" alt="#"></a>
                            <a href="#"><img class="social-media" src="<?=Parameters::$BASE_URL?>assets/img/Social_Media/facebook.png" alt="#"></a>
                            <a href="#"><img class="social-media" src="<?=Parameters::$BASE_URL?>assets/img/Social_Media/twitter.png" alt="#"></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Derechos de Autor</h5>
                    <p>&copy; 2024 Mi Sitio. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="<?=Parameters::$BASE_URL?>assets/js/script.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Slick JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
</body>