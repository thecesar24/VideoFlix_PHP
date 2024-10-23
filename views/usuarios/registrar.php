<?php
	use cesar\ProyectoTest\Config\Parameters;
	use cesar\ProyectoTest\Helpers\ErrorHelpers;

    $dataPOST = $data["dataPOST"]??NULL;
    $validationsError = $data["validationsError"]??NULL;
    
    if (isset($data['statusRegister'])){
        if ($data['statusRegister']){
        echo "<div class='alerta'>Registro completado</div>";
		}else{
    	echo "<div class='alerta alerta-error'>Error al registrar</div>";
	}
}
?>
<div class="container container-register">
        	<form class="formulario-register" action="<?=Parameters::$BASE_URL?>Usuario/registerSave" method="post">
            <h2>Registrar Usuario</h2>
            <p>
                <label for="idNombre">Nombre:</label>
                <input type="text" name="nombre" id="idNombre" value="<?=$dataPOST["nombre"]??""?>" required/>
            </p>
            <p>
                <label for="idApellidos">Apellidos:</label>
                <input type="text" name="apellidos" id="idApellidos" value="<?=$dataPOST["apellidos"]??""?>" required/>
            </p>
			<p>
                <label for="idEmail">email:</label>
                <input type="email" name="email" id="idEmail" value="<?=$dataPOST["email"]??""?>" required/>
            </p>
            <p>
                <label for="idTelefono">telefono:</label>
                <input type="tel" name="telefono" id="idTelefono" value="<?=$dataPOST["telefono"]??""?>" required/>
            </p>
            <p>
                <label for="idUsername">Nombre de Usuario:</label>
                <input type="text" name="username" id="idUsername" value="<?=$dataPOST["username"]??""?>" required/>
            </p>
            <p>
				<label for='idPassword'>Contraseña</label>
				<input type='password' name='password' id='idPassword' value='<?=$dataPOST["password"]??""?>' required autocomplete="new-password"/>
				<?=isset($validationsError['password']) ? ErrorHelpers::showError($validationsError, 'password') : '';?>

			</p>
			<p>
				<label for='idPassword2'>Confirmar Contraseña</label>
				<input type='password' name='password2' id='idPassword2' value='<?=$dataPOST["password2"]??""?>' required autocomplete="new-password"/>
				<?=isset($validationsError['password2']) ? ErrorHelpers::showError($validationsError, 'password2') : '';?>
			
			</p>
            <button type='submit' name='btnRegistro' value='Registrar'>Registrar</button>
        	</form>    
<?php
		ErrorHelpers::clearAll();
?>