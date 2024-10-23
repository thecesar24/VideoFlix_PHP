<?php
	use cesar\ProyectoTest\Config\Parameters;
	use cesar\ProyectoTest\Helpers\ErrorHelpers;

    $dataPOST = $data["dataPOST"]??NULL;
    $validationsError = $data["validationsError"]??NULL;
    
    if(isset($_SESSION['errorLogin'])){
        echo "<div class='alerta alerta-error'>{$_SESSION['errorLogin']}</div>";
        unset($_SESSION['errorLogin']);
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