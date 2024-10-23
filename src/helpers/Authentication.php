<?php
	namespace cesar\ProyectoTest\Helpers;

use cesar\ProyectoTest\Config\Parameters;

	class Authentication{
    
        public static function isUserLogged(): bool{
            return (isset($_SESSION['user']));
        }

    }