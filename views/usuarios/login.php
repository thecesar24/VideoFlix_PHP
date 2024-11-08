<?php
	use cesar\ProyectoTest\Config\Parameters;
	use cesar\ProyectoTest\Helpers\ErrorHelpers;

    $dataPOST = $data["dataPOST"]??NULL;
    $validationsError = $data["validationsError"]??NULL;
    
    if (isset($_SESSION['errores'])) {
        echo "<div class='error-container'>";
            foreach ($_SESSION['errores'] as $error) {
                echo "<p class='error'>$error</p>"; // Muestra cada mensaje de error
            }
        echo "</div>";
        unset($_SESSION['errores']); // Limpiar los errores después de mostrarlos
    }
?>

<div class="container container-iniciar-sesion">
            <form class="formulario-iniciar-sesion" action="<?=Parameters::$BASE_URL?>Usuario/loginsave" method="post">
                <h2>Iniciar Sesión</h2>
                <p>
                    <label for="idLoginUsername">Nombre de Usuario:</label>
                    <input type='text' name='username' id='idLoginUsername' required/>
                </p>
                <p>
                    <label for="idLoginPassword">Contraseña:</label>
                    <input type='password' name='password' id='idLoginPassword' required/>
                </p>
                <button type="submit" name='btnLogin' value="Entrar">Iniciar Sesión</button>
            </form>      
<?php
		ErrorHelpers::clearAll();
?>