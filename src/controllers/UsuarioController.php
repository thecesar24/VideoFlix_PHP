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
            $erroresSpan = [];
    
            // Obtener los valores del formulario
            $nombre = $_POST['nombre'] ?? '';
            $apellidos = $_POST['apellidos'] ?? '';
            $email = $_POST['email'] ?? '';
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $password2 = $_POST['password2'] ?? '';
            $rol = Parameters::$ROL_USUARIO;
            
            // Validaciones
            if (!Validations::validateName($nombre)) {
                $erroresSpan['nombre'] = "Nombre no valido";
            }
            
            if (!Validations::validateName($apellidos)) {
                $erroresSpan['apellidos'] = "Apellido no valido";
            }

            if (!Validations::validateUsername($username)) {
                $erroresSpan['username'] = "Introduce un nombre de usuario valido.";
            }

            if (!Validations::validateEmail($email)) {
                $erroresSpan['email'] = "Correo electrónico no válido.";
            }

            if (!Validations::validateFormatPassword($password)) {
                $erroresSpan['contraseña'] = "Formato Contraseña no válido. Debe ser una cadena de mínimo " . Parameters::$PASSWORD_MIN_LENGTH . " caracteres, Contener una letra Mayuscula y un caracter especial.";
            }
    
            if ($password !== $password2) {
                $erroresSpan['contraseña'] = "Las contraseñas no coinciden";
            }
            
            $usuarioModel = new UsuarioModel();
            $existe = $usuarioModel->login($username);

            $mailExistente = $usuarioModel->mailExistente($email);

            if ($mailExistente) {
                $errores['email'] = "El Email ya esta en uso.";
            }

            if ($existe) {
                $errores['existe'] = "El Usuario ya existe, por favor Inicie Sesión.";
            }

            if (!empty($erroresSpan)) {
                $_SESSION['errores-span'] = $erroresSpan;
                header("Location: " . Parameters::$BASE_URL . "Usuario/register");
                exit();
            }

            if (!empty($errores)) {
                $_SESSION['errores'] = $errores;
                header("Location: " . Parameters::$BASE_URL . "Usuario/register");
                exit();
            }
            
            if ($username == Parameters::$ROL_ADMIN) {
                $rol = Parameters::$ROL_ADMIN;
            }
            
            if (empty($errores)) {
                $userEntity = new UserEntity();
                $userEntity->setNombre($nombre)
                           ->setApellidos($apellidos)
                           ->setEmail($email)
                           ->setUsername($username)
                           ->setPassword($password)
                           ->setRol($rol);

                $usuarioModel->register($userEntity);
                $_SESSION['mensaje'] = "Usuario registrado correctamente.";

                
                $usuario = $usuarioModel->login($username);
                $userEntity->setId($usuario->id);
                $_SESSION['user'] = $userEntity;    

                if ($usuario->estado == 0) {
                    $_SESSION['errores'][] = "La cuenta esta bloqueada, contacta con un administrador.";
                    header("Location: " . Parameters::$BASE_URL . "Usuario/login");
                    exit();
                }
                
                if ($username == Parameters::$ROL_ADMIN) {
                    $_SESSION['admin'] = $userEntity;
                }

                if (Authentication::isUserLogged()) {
                    header("Location: " . Parameters::$BASE_URL . "SeguirViendo/miEspacio");
                    exit();
                }
            } else {
                // Si hay errores, mostrar el formulario nuevamente con los errores
                ViewController::show('views/usuarios/registrar.php', ['dataPOST' => $_POST]);
            }
        }
    }    
    

    public function login() {
        ViewController::show('views/usuarios/login.php');
    }
   
    public function loginsave(): void {
        if (isset($_POST['btnLogin'])) {
            $erroresSpan = [];

            $username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
            $password = $_POST["password"] ?? "";

            if (!Validations::validateUsername($username)) {
                $erroresSpan['username'] = "Introduce un nombre de usuario valido.";
            }

            if (!Validations::validateFormatPassword($password)) {
                $erroresSpan['password'] = "Contraseña incorrecta (Minimo 6 caracteres).";
            }

            if (!empty($erroresSpan)) {
                $_SESSION['errores-span'] = $erroresSpan;
                header("Location: " . Parameters::$BASE_URL . "Usuario/login");
                exit();
            }
    
            // Cargar modelo de usuario
            $usuarioModel = new UsuarioModel();
            $usuario = $usuarioModel->login($username);
    
            // Verificar si el usuario existe
            if ($usuario && isset($usuario->password)) {
                // Comprobar la contraseña
                $verify = password_verify($password, $usuario->password);
    
                if ($usuario->estado == 0) {
                    $_SESSION['errores'][] = "La cuenta esta bloqueada, contacta con un administrador.";
                    header("Location: " . Parameters::$BASE_URL . "Usuario/login");
                    exit();
                }

                if ($verify) {
                    $userEntity = new UserEntity();
                    $userEntity->setId($usuario->id)
                               ->setEmail($usuario->email)
                               ->setApellidos($usuario->apellidos)
                               ->setNombre($usuario->nombre)
                               ->setUsername($usuario->username)
                               ->setRol($usuario->rol);
    
                    $_SESSION['user'] = $userEntity;
                    
                    if ($username == Parameters::$ROL_ADMIN) {
                        $_SESSION['admin'] = $userEntity;
                    }
    
                    if (Authentication::isUserLogged()) {
                        header("Location: " . Parameters::$BASE_URL . "SeguirViendo/miEspacio");
                        exit();
                    } else {
                        $_SESSION['errores'][] = "Hubo un problema iniciando sesión.";
                        header("Location: " . Parameters::$BASE_URL . "Usuario/login");
                        exit();
                    }
                } else {
                    $_SESSION['errores'][] = "Usuario o Contraseña incorrectos";
                    header("Location: " . Parameters::$BASE_URL . "Usuario/login");
                    exit();
                }
            } else {
                $_SESSION['errores'][] = "Usuario no encontrado";
                header("Location: " . Parameters::$BASE_URL . "Usuario/login");
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
            $email = $_POST['email'] ?? '';
            $username = $_POST['username'] ?? '';

            if (!Validations::validateName($nombre) || !Validations::validateName($apellidos)) {
                $errores['nombre'] = "Formato incorrecto en el nombre o apellido.";
            }
            if (!Validations::validateEmail($email)) {
                $errores['email'] = "Correo electrónico no válido.";
            }
            if (!empty($errores)) {
                $_SESSION['errores'] = $errores;
                ViewController::show('views/usuarios/editarDatos.php', ['dataPOST' => $_POST]);
                exit();
            }   

            $userEntity->setNombre($nombre)
                   ->setApellidos($apellidos)
                   ->setEmail($email)
                   ->setUsername($username);

            $usuarioModel = new UsuarioModel();
            $statusUpdate = $usuarioModel->update($userEntity);

            if ($statusUpdate) {
                $_SESSION['user'] = $userEntity;
                $_SESSION['mensaje'] = "Datos actualizados correctamente.";
                header("Location: " . Parameters::$BASE_URL . "Usuario/datos");
            }else {
                $errores['error'] = "Hubo un problema al actualizar sus datos.";
                ViewController::show('views/usuarios/editarDatos.php', ['dataPOST' => $_POST]);
            }
        }else {
            header("Location: " . Parameters::$BASE_URL . "Usuario/login");
            exit();
        }
    }

    public function closeSession() {
        if (Authentication::isUserLogged()) unset($_SESSION['user']);   
        if (Authentication::isAdminLogged()) unset($_SESSION['admin']);   
        header("Location: " . PARAMETERS::$BASE_URL . 'Inicio/Index');

        exit();
    }

    public function GestionarUsers() {   
        if (Authentication::isAdminLogged()) {
            $userEntity = $_SESSION['admin'];
            $username = $userEntity->getUsername();

            $UsuarioModel = new UsuarioModel;
            $todosUsuarios = $UsuarioModel->getAllMenosAdmin($username); 

            ViewController::show('views/usuarios/gestionarUsuarios.php', ['todosUsuarios' => $todosUsuarios]);
            exit();

        } else {
            ViewController::showError(403);
            exit();
        }
    }    

    public function cambiarEstadoUsuario() {
        if (Authentication::isAdminLogged()) {
            $errores = [];
    
            $usuarioModel = new UsuarioModel();
            $idUsuario = $_GET['idUsuario'];
            $usuario = $usuarioModel->getOne($idUsuario);

            if (!empty($errores)) {
                $_SESSION['errores'] = $errores;
                header("Location: " . Parameters::$BASE_URL . "Usuario/GestionarUsers");
                exit();
            }
    
            if ($usuario) {
                if ($usuario->estado == 1) {
                    $estado = 0;
                    $usuarioModel->cambiarEstadoUsuario($idUsuario, $estado);
                    $_SESSION['mensaje'] = "El usuario esta de baja";
                    header("Location: " . Parameters::$BASE_URL . "Usuario/GestionarUsers");
                    exit();
                } if ($usuario->estado == 0) {
                    $estado = 1;
                    $usuarioModel->cambiarEstadoUsuario($idUsuario, $estado);
                    $_SESSION['mensaje'] = "El usuario esta de alta";
                    header("Location: " . Parameters::$BASE_URL . "Usuario/GestionarUsers");
                    exit();
                } else {
                    $errores[] = 'Error al cambiar el estado';
                }
            } else {
                $errores[] = 'El usuario no existe';
            }
        } else {
            ViewController::showError(403);
        }
    }
}