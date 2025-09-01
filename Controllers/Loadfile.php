<?php

class Loadfile extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Funcion que carga la imagen de perfil del usuario
     * @return void
     */
    public function profile()
    {
        if (isset($_GET['f'])) {
            $nameFile = $_GET['f'];
            $path = getRoute();
            $filePath = $path . "Profile/Users/" . basename($nameFile);
            $fileType = pathinfo($filePath, PATHINFO_EXTENSION);
            if (file_exists($filePath) && in_array($fileType, ["jpg", "jpeg", "png", "JPG", "JPEG", "PNG"])) {
                header("Content-Type: image/$fileType");
                readfile($filePath);
                exit;
            } else {
                //cargamos una imagen por defecto
                header("Content-Type: image/png");
                readfile(getRoute() . "Profile/Users/user.png");
            }
        } else {
            //cargamos una imagen por defecto
            header("Content-Type: image/png");
            readfile(getRoute() . "Profile/Users/user.png");
        }
    }
    /**
     * Funcion que carga la imagen de perfil del sistema
     * @return void
     */
    public function icon()
    {
        if (isset($_GET['f'])) {
            $nameFile = $_GET['f'];
            $path = getRoute();
            $filePath = $path . "Profile/Logo/" . basename($nameFile);
            $fileType = pathinfo($filePath, PATHINFO_EXTENSION);
            if (file_exists($filePath) && in_array($fileType, ["jpg", "jpeg", "png", "JPG", "JPEG", "PNG"])) {
                header("Content-Type: image/$fileType");
                readfile($filePath);
                exit;
            } else {
                //cargamos una imagen por defecto
                header("Content-Type: image/png");
                readfile($filePath . "Profile/Logo/sin-content.png");
            }
        } else {
            //cargamos una imagen por defecto
            header("Content-Type: image/png");
            readfile(getRoute() . "Profile/Logo/sin-content.png");
        }
    }

}