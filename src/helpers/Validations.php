<?php
	namespace cesar\ProyectoTest\Helpers;
    use cesar\ProyectoTest\Config\Parameters;
    use cesar\ProyectoTest\Models\CursoModel;

	class Validations{

        public static function validateName($nombre):bool{
            return (!empty($nombre) && preg_match("/^[a-zñáéíóú]+([ ][a-zñáéíóú]+)*$/", strtolower($nombre)));
        }

        public static function validateUsername($username): bool {
            return (!empty($username) && preg_match("/^[a-zA-Z0-9._]+$/", $username) && 
                    strlen($username) >= 3 && strlen($username) <= 20 && 
                    !preg_match("/^[_\.]|[_\.]$/", $username) && 
                    preg_match("/[a-zA-Z]/", $username));
        }
        
        public static function validateEmail($email):bool{
            return (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL));
        }

        public static function validateComentario($comentario): bool {
            return (strlen($comentario) <= Parameters::$COMENTARIO_MAX_LENGTH) &&
                   (!empty($comentario) &&
                    preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s.,!?():'\"-]*$/", $comentario));
        }

        public static function validateTitulo($titulo): bool {
            if (empty($titulo)) {
                return false;
            }
        
            $patron = "/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s.,!?():'\"-]+$/";
        
            if (strlen($titulo) > Parameters::$TITULO_MAX_LENGTH) {
                return false;
            }
        
            return preg_match($patron, $titulo);
        }

        public static function validateSinopsis($sinopsis): bool {
            if (empty($sinopsis) || strlen($sinopsis) > Parameters::$SINOPSIS_MAX_LENGTH) {
                return false;
            }
          
            $patron = "/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s.,!?():'\"-]+$/";
            if (!preg_match($patron, $sinopsis)) {
                return false;
            }
        
            return true;
        }        
        
        public static function validateFormatPassword($password): bool {
            // Verificar si la contraseña está vacía
            if (empty($password)) {
                return false;
            }
            
            // Verificar la longitud mínima de la contraseña
            if (strlen($password) < Parameters::$PASSWORD_MIN_LENGTH) {
                return false;
            }
        
            // //Verificar que contenga al menos un carácter alfabético
            // if (!preg_match('/[a-zA-Z]/', $password)) {
            //     return false;
            // }
        
            // //Verificar que contenga al menos una letra mayúscula
            // if (!preg_match('/[A-Z]/', $password)) {
            //     return false;
            // }
        
            // //Verificar que contenga al menos un carácter especial
            // if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            //     return false;
            // }
        
            return true;
        }

        public static function validateYouTubeEmbedUrl($url): bool {
            $pattern = '/^https:\/\/www\.youtube\.com\/embed\/[a-zA-Z0-9_-]+$/';
            return preg_match($pattern, $url);
        }
        
        public static function validateFile($file): bool {
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $maxSize = 2 * 1024 * 1024; // Máximo 2 MB
        
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return false;
            }
        
            if ($file['size'] > $maxSize) {
                return false;
            }
        
            $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                return false;
            }
        
            return true;
        }        
    }