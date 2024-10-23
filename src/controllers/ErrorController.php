<?php
namespace cesar\ProyectoTest\Controllers;

class ErrorController{
    public function index(){}

    public function show404(){
        echo "<p class='error'>Error 404, el recurso solicitado no existe </p>";
    }

    public function show403(){
        echo "<p class='error'>Error 403, acceso prohibido para todas las personas sin autorización </p>";
    }
    
}