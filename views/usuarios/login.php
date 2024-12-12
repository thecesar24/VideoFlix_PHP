<?php
	use cesar\ProyectoTest\Config\Parameters;
	use cesar\ProyectoTest\Helpers\ErrorHelpers;

    $dataPOST = $data["dataPOST"]??NULL;
    $validationsError = $data["validationsError"]??NULL;
    
    if (isset($_SESSION['errores'])) {
        echo "<div class='error-container'>";
            foreach ($_SESSION['errores'] as $error) {
                echo "<p class='error'>$error</p>"; 
            }
        echo "</div>";
        unset($_SESSION['errores']);
    }
?>

<div class="container container-iniciar-sesion">
            <form class="formulario-iniciar-sesion" action="<?=Parameters::$BASE_URL?>Usuario/loginsave" method="post">
                <h2>Iniciar Sesión</h2>
                <p>
                    <label for="idLoginUsername">Nombre de Usuario:</label>
                    <input type='text' name='username' id='idLoginUsername' <?php if(isset($_SESSION['errores-span']) && isset($_SESSION['errores-span']['username'])){echo "class='error-input'";} ?>/>
                    <span class="error-span">
                    <?php if(isset($_SESSION['errores-span']) && isset($_SESSION['errores-span']['username'])) {
                        echo $_SESSION['errores-span']['username'];
                    } ?>
                    </span>
                </p>
                <p>
                    <label for="idLoginPassword">Contraseña:</label>
                    <input type='password' name='password' id='idLoginPassword' <?php if(isset($_SESSION['errores-span']) && isset($_SESSION['errores-span']['password'])){echo "class='error-input'";} ?>/>
                    <span class="error-span">
                    <?php if(isset($_SESSION['errores-span']) && isset($_SESSION['errores-span']['password'])) {
                        echo $_SESSION['errores-span']['password'];
                    } ?>
                    </span>
                </p>
                <button type="submit" name='btnLogin' value="Entrar">Iniciar Sesión</button>
            </form>      
<?php
        unset($_SESSION['errores-span']);
		ErrorHelpers::clearAll();
?>