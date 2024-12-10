<?php
	namespace cesar\ProyectoTest\Helpers;

	class Authentication{
    
        public static function isUserLogged(): bool{
            return (isset($_SESSION['user']));
        }

        public static function isAdminLogged(): bool{
            return (isset($_SESSION['admin']));
        }

    }