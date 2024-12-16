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
    <link rel="shortcut icon" href="<?=Parameters::$BASE_URL?>assets/img/logo.ico" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css"/>

    <link rel="stylesheet" href="<?=Parameters::$BASE_URL?>assets/css/style.css">
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
                    <ul class="navbar-nav mr-auto paginas-buttons">
                        <li class="nav-item">
                            <a class="nav-link" id="inicio" href="<?=Parameters::$BASE_URL . "Inicio/index" ?>">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="series" href="<?= Parameters::$BASE_URL . 'Contenido/Series' ?>">Series</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="peliculas" href="<?= Parameters::$BASE_URL . 'Contenido/Peliculas' ?>">Películas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="cortos" href="<?= Parameters::$BASE_URL . 'Contenido/Cortos' ?>">Cortos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="documentales" href="<?= Parameters::$BASE_URL . 'Contenido/Documentales' ?>">Documentales</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <?php if (!Authentication::isUserLogged()) { ?>
                        <li class="nav-item">
                            <a class="nav-link register" id="registro" href="<?= Parameters::$BASE_URL . "Usuario/register" ?>">
                                <span class="nav-link material-symbols-outlined" id="iniciar-sesion">person_add</span>
                                <p>Registro</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link login" id="iniciar-sesion" href="<?= Parameters::$BASE_URL . "Usuario/login" ?>">
                                <span class="nav-link material-symbols-outlined" id="iniciar-sesion">login</span>
                                <p>Iniciar Sesión</p>
                            </a>
                        </li>
                        <?php }; ?>
                        <?php if (Authentication::isAdminLogged()) { ?>
                            <li class="nav-item">
                                <a href="<?=Parameters::$BASE_URL . 'Usuario/GestionarUsers'?>" class="nav-link">Usuarios</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?=Parameters::$BASE_URL . 'Contenido/GestionarContenido'?>" class="nav-link">Contenido</a>
                            </li>
                        <?php }; ?>
                        <?php if (Authentication::isUserLogged()) { ?>
                        <li class="nav-item user-icon">
                            <div class="tooltip-container" id="tooltip-container">
                                <div class="material-symbols-outlined">account_circle</div>
                                <div class="tooltip" id="tooltip">
                                    <a class="nav-link" id="iniciar-sesion" href="<?= Parameters::$BASE_URL . "Usuario/datos" ?>">Datos Usuario</a>
                                    <a class="nav-link" id="iniciar-sesion" href="<?= Parameters::$BASE_URL . "SeguirViendo/miEspacio" ?>">Mi Espacio</a>
                                    <a class="nav-link" id="iniciar-sesion" href="<?= Parameters::$BASE_URL . "Usuario/closeSession" ?>">Cerrar Sesion</a>
                                </div>
                            </div>
                        </li>
                        <?php }; ?>

                        <li class="nav-item buscador">
                            <form class="form-inline my-2 my-lg-0 search-container" action="<?=Parameters::$BASE_URL . "Contenido/buscarContenido"?>" method="post">
                                <input class="form-control mr-sm-2" type="search" name="busqueda" placeholder="Buscar..." aria-label="Buscar">
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
	<main>
        