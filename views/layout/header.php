<?php
	use cesar\ProyectoTest\Config\Parameters;
	use cesar\ProyectoTest\Helpers\Authentication;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideosFlix</title>
    <link rel="stylesheet" href="<?=Parameters::$BASE_URL?>assets/css/style.css">
    <link rel="shortcut icon" href="<?=Parameters::$BASE_URL?>assets/img/logo.ico" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?=Parameters::$BASE_URL . "Inicio/index" ?>">
                    <img class="header-image" alt="header-image" src="<?=Parameters::$BASE_URL?>assets/img/logo.png" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="collapse navbar-collapse navbar-custom" id="navbarResponsive">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" id="inicio" href="<?=Parameters::$BASE_URL . "Inicio/index" ?>">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="series" href="#">Series</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="peliculas" href="#">Películas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="cortos" href="#">Cortos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="documentales" href="#">Documentales</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <?php if (Authentication::isUserLogged() == false) { ?>
                        <li class="nav-item">
                            <a class="nav-link" id="registro" href="<?= Parameters::$BASE_URL . "Usuario/register" ?>">Registro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="iniciar-sesion" href="<?= Parameters::$BASE_URL . "Usuario/login" ?>">Iniciar Sesión</a>
                        </li>
                        <?php }; ?>
                        <?php if (Authentication::isUserLogged() == true) { ?>
                        <li class="nav-item">
                            <a class="nav-link" id="iniciar-sesion" href="<?= Parameters::$BASE_URL . "Usuario/datos" ?>">Datos Usuario</a>
                        </li>
                        <?php }; ?>

                        <li class="nav-item">
                            <form class="form-inline my-2 my-lg-0 search-container">
                                <input class="form-control mr-sm-2" type="search" placeholder="Buscar..." aria-label="Buscar">
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
	<main>
        