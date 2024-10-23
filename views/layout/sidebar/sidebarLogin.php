<?php
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;

if (!Authentication::isUserLogged()){
?>
	<div id='login' class='bloque'>
			<h3>Identificate</h3>

		<?php
			if(isset($_SESSION['errorLogin'])){
				echo "<div class='alerta alerta-error'>{$_SESSION['errorLogin']}</div>";
				unset($_SESSION['errorLogin']);
			}
		?>

			<form action='<?=Parameters::$BASE_URL?>Usuario/login' method='post'> 
				<label for='idLoginUsername'>Username</label>
				<input type='text' name='username' id='idLoginUsername' />

				<label for='idLoginPassword'>Contraseña</label>
				<input type='password' name='password' id='idLoginPassword' />

				<input type='submit' value='Entrar' name='btnLogin' />
			</form>
		</div>
<?php
}
?>
