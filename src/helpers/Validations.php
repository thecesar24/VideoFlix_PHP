<?php
	namespace cesar\ProyectoTest\Helpers;
    use cesar\ProyectoTest\Config\Parameters;
    use cesar\ProyectoTest\Models\CursoModel;

	class Validations{

        public static function validateName($nombre):bool{
            return (!empty($nombre) && preg_match("/^[a-zñáéíóú]+([ ][a-zñáéíóú]+)*$/", strtolower($nombre)));
        }
        
        public static function validateEmail($email):bool{
            return (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL));
        }

        public static function validateTelefono($telefono):bool{
            return (!empty($telefono) && preg_match("/^[0-9]{9}$/", $telefono));
        }

        public static function validateComentario($comentario): bool {
            return (strlen($comentario) <= Parameters::$COMENTARIO_MAX_LENGTH) &&
                   (!empty($comentario) &&
                    preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s.,!?():'\"-]*$/", $comentario));
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
        
            // Verificar que contenga al menos un carácter alfabético
           // if (!preg_match('/[a-zA-Z]/', $password)) {
         //       return false;
          //  }
        
            // Verificar que contenga al menos una letra mayúscula
          //  if (!preg_match('/[A-Z]/', $password)) {
          //      return false;
         //   }
        
            // Verificar que contenga al menos un carácter especial
          //  if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
          //      return false;
         //   }
        
            return true;
        }
        
        
    }