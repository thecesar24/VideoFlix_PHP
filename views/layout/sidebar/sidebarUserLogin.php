<?php
use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Entities\UserEntity;


    if (Authentication::isUserLogged()){
		echo "<div id='usuario-logueado' class='bloque'>";
		echo "<h3> Bienvenid@, {$_SESSION['user']->getNombreCompleto()} </h3>";
		
		if ($_SESSION['user']->getRol() == Parameters::$ALUMNO) {
			echo "<h3>Rol: Alumn@</h3>";
		}elseif ($_SESSION['user']->getRol() == Parameters::$DOCENTE) {
			echo "<h3>Rol: Docente</h3>";
		}elseif ($_SESSION['user']->getRol() == Parameters::$ADMIN) {
			echo "<h3>Rol: Admin</h3>";
		}else{
			echo "<h3>Rol: Error</h3>";
		}
		
		// Botones del usuario:
		if (Authentication::isUserAlumnoLogged()) {
			echo "<a href='".Parameters::$BASE_URL."Tests/resultados' class='boton boton-azul'>Ver mis resultados globales</a>
			<a href='".Parameters::$BASE_URL."Tests/hacerTest' class='boton boton-verde'>Hacer un TEST</a>";
		}

		if (Authentication::isUserDocenteLogged()){
			echo "<a href='".Parameters::$BASE_URL."Alumno/gestion' class='boton'>Ver alumnos</a>";
			echo "<a href='".Parameters::$BASE_URL."Preguntas/crearPregunta' class='boton boton-verde'>Crear Pregunta</a>";
		}

		if (Authentication::isUserAdminLogged()){
			echo "<a href='".Parameters::$BASE_URL."Usuario/register' class='boton boton-verde'>Alta Usuarios</a>";
			echo "<a href='".Parameters::$BASE_URL."Usuario/gestion' class='boton boton-azul'>Gestionar Usuarios</a>";
		}

		echo "<a href='".Parameters::$BASE_URL."Usuario/closeSession' class='boton boton-rojo'>Cerrar sesión</a>";
		
		echo "</div>";
    }
?>