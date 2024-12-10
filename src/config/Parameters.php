<?php
namespace cesar\ProyectoTest\Config;

class Parameters{
    public static $CONTROLLER_DEFAULT = "Inicio";
    public static $ACTION_DEFAULT = "index";

    public static $PASSWORD_MIN_LENGTH = 6;
    
    public static $BASE_URL = "http://localhost/VideoFlix_PHP/";
    public static $COMENTARIO_MAX_LENGTH = 150;
    public static $EMAIL_PAGINA = "cesar.perpob.1@educa.jcyl.es";

    public static $API_URL = "http://localhost/VideoFlix_PHP/DocumentalesApi/getDocumentales";
    //public static $API_URL = self::$BASE_URL . "DocumentalesApi/getDocumentales";
}