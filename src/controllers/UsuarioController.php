<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Models\UsuarioModel;
use cesar\ProyectoTest\Helpers\Validations;
use cesar\ProyectoTest\Entities\UserEntity;
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;

class UsuarioController {
    public function index()
    {
    }

    public function register(){

        ViewController::show('views/usuarios/registrar.php');
    }

    public function registerSave(): void {
        if (isset($_POST['btnRegistro'])) {
            $errores = [];
    
            // Obtener los valores del formulario
            $nombre = $_POST['nombre'] ?? '';
            $apellidos = $_POST['apellidos'] ?? '';
            $password = $_POST['password'] ?? '';
            $password2 = $_POST['password2'] ?? '';
            
            // Validaciones
            if (!Validations::validateName($nombre) || !Validations::validateName($apellidos)) {
                $errores['nombre'] = "Formato incorrecto";
            }
    
            if (!Validations::validateFormatPassword($password)) {
                $errores['password'] = "Formato Contraseña no válido. Debe ser una cadena de mínimo " . Parameters::$PASSWORD_MIN_LENGTH . " caracteres, Contener una letra Mayuscula y un caracter especial.";
            }
    
            if ($password !== $password2) {
                $errores['password2'] = "El campo 'Contraseña' y 'Confirmar Contraseña' deben coincidir";
            }
    
            // Crear instancias de modelos
            $usuarioModel = new UsuarioModel();
            
            // Comprobar si hay errores antes de continuar
            if (empty($errores)) {
                $userEntity = new UserEntity();
                $userEntity->setNombre($nombre)
                           ->setApellidos($apellidos)
                           ->setTelefono($_POST["telefono"])
                           ->setEmail($_POST["email"])
                           ->setUsername($_POST["username"])
                           ->setPassword($password);

                // Registrar usuario y verificar el estado
                $statusRegister = $usuarioModel->register($userEntity);

                // Mostrar la vista con el resultado del registro
                ViewController::show('views/usuarios/registrar.php', ['statusRegister' => $statusRegister]);
            } else {
                // Si hay errores, mostrar el formulario nuevamente con los errores
                ViewController::show('views/usuarios/registrar.php', ['dataPOST' => $_POST, 'validationsError' => $errores]);
            }
        }
    }    
    

    public function login() {
        ViewController::show('views/usuarios/login.php');
    }
   
    public function loginsave(): void {
        // Verificar si el formulario ha sido enviado
        if (isset($_POST['btnLogin'])) {
            // Recoger datos del formulario
            $username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
            $password = $_POST["password"] ?? "";
    
            // Validar que los campos no estén vacíos
            if (empty($username) || empty($password)) {
                $_SESSION['errorLogin'] = "Por favor, ingrese su nombre de usuario y contraseña.";
                header("Location: " . Parameters::$BASE_URL . "/Usuario/login");
                exit();
            }
    
            // Cargar modelo de usuario
            $usuarioModel = new UsuarioModel();
            $usuario = $usuarioModel->login($username);
    
            // Verificar si el usuario existe
            if ($usuario && isset($usuario->password)) {
                // Comprobar la contraseña
                $verify = password_verify($password, $usuario->password);
    
                if ($verify) {
                    // Crear entidad de usuario
                    $userEntity = new UserEntity();
                    $userEntity->setId($usuario->id)
                               ->setEmail($usuario->email)
                               ->setApellidos($usuario->apellidos)
                               ->setTelefono($usuario->telefono)
                               ->setNombre($usuario->nombre)
                               ->setUsername($usuario->username);
    
                    // Almacenar usuario en sesión
                    $_SESSION['user'] = $userEntity;
    
                    // Redirigir al dashboard si el login es exitoso
                    if (Authentication::isUserLogged()) {
                        header("Location: " . Parameters::$BASE_URL . "/Usuario/dashboard");
                        exit();
                    } else {
                        // Redirigir si hay un error inesperado
                        $_SESSION['errorLogin'] = "Hubo un problema iniciando sesión.";
                        header("Location: " . Parameters::$BASE_URL . "/Usuario/login");
                        exit();
                    }
                } else {
                    // Contraseña incorrecta
                    $_SESSION['errorLogin'] = "Login incorrecto!!";
                    header("Location: " . Parameters::$BASE_URL . "/Usuario/login");
                    exit();
                }
            } else {
                // Usuario no encontrado
                $_SESSION['errorLogin'] = "Login incorrecto!!";
                header("Location: " . Parameters::$BASE_URL . "/Usuario/login");
                exit();
            }
        }
    }


    public function datos(){
        if (!Authentication::isUserLogged()) {
            header("Location: " . Parameters::$BASE_URL . "Usuario/login");
            exit();
        }else{

            $id = $_SESSION['user']->getid();

            $usuarioModel = new UsuarioModel();
            $datos = $usuarioModel->getOne($id);

            $userEntity = $_SESSION['user'];

            ViewController::show('views/usuarios/datos.php', ['usuario' => $userEntity, 'datos' => $datos]);

        }
    }

    public function editDatos() {
        if (Authentication::isUserLogged()) {
            
            ViewController::show('views/usuarios/editarDatos.php');

        }else {
            header("Location: " . Parameters::$BASE_URL . "Usuario/login");
            exit();
        }
    }

    public function updateDatos() {
        if (Authentication::isUserLogged()) {
            $errores = [];
            $userEntity = $_SESSION['user'];

            // Collect POST data
            $nombre = $_POST['nombre'] ?? '';
            $apellidos = $_POST['apellidos'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $email = $_POST['email'] ?? '';
            $username = $_POST['username'] ?? '';

         /*    if (!Validations::validateName($nombre) || !Validations::validateName($apellidos)) {
                $errores['nombre'] = "Formato incorrecto en el nombre o apellido.";
            }
           if (!Validations::validatePhone($telefono)) {
                $errores['telefono'] = "Número de teléfono no válido.";
            }
            if (!Validations::validateEmail($email)) {
                $errores['email'] = "Correo electrónico no válido.";
            }*/
            if (!empty($errores)) {
                ViewController::show('views/usuarios/editarDatos.php', ['validationsError' => $errores, 'dataPOST' => $_POST]);
                return;
            }   

            $userEntity->setNombre($nombre)
                   ->setApellidos($apellidos)
                   ->setTelefono($telefono)
                   ->setEmail($email)
                   ->setUsername($username);

            $usuarioModel = new UsuarioModel();
            $statusUpdate = $usuarioModel->update($userEntity);

            if ($statusUpdate) {
                $_SESSION['user'] = $userEntity;  // Update session data
                $_SESSION['successMessage'] = "Datos actualizados correctamente.";
                header("Location: " . Parameters::$BASE_URL . "Usuario/datos");
            }else {
                $_SESSION['errorMessage'] = "Hubo un problema al actualizar sus datos.";
                ViewController::show('views/usuarios/editarDatos.php', ['dataPOST' => $_POST]);
            }
        }else {
            header("Location: " . Parameters::$BASE_URL . "Usuario/login");
            exit();
        }
    }

    public function closeSession() {
        if (Authentication::isUserLogged()) unset($_SESSION['user']);   
        
        header("Location: " . PARAMETERS::$BASE_URL);
        exit();
    }

    /*
    public function dashboard() {
        // Verificar si el usuario está logueado
        if (!Authentication::isUserLogged()) {
            header("Location: " . Parameters::$BASE_URL . "/login");
            exit();
        }

        // Obtener el usuario logueado desde la sesión
        $userEntity = $_SESSION['user'];

        // Modelo de videos para obtener videos que el usuario ha estado viendo
     //   $videoModel = new VideoModel();
      //  $videosVistos = $videoModel->getVideosVistosByUser($userEntity->getId());

        // Cargar la vista del dashboard con los datos del usuario y sus videos
        ViewController::show('views/usuarios/dashboard.php', [
            'usuario' => $userEntity
      //      'videosVistos' => $videosVistos
        ]);
    }

    */
    
}