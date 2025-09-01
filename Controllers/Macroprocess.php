<?php

class Macroprocess extends Controllers
{
    /**
     * Constructor de la clase
     */
    public function __construct()
    {
        isSession();
        parent::__construct();
    }
    /**
     * Funcion que devuelve la vista de la gestion de usuarios
     * @return void
     */
    public function macroprocess()
    {
        $data['page_id'] = 12;
        permissionInterface($data['page_id']);
        $data['page_title'] = "Gestión de Macroprocesos";
        $data['page_description'] = "Permite gestionar los macroprocesos del sistema GSSOHMA.";
        $data['page_container'] = "Macroprocess";
        $data['page_view'] = 'macroprocess';
        $data['page_js_css'] = "macroprocess";
        $data['page_vars'] = ["login", "login_info", "lastConsult"];
        registerLog("Información de navegación", "El usuario entro a: " . $data['page_title'], 3, $_SESSION['login_info']['idUser']);
        $this->views->getView($this, "macroprocess", $data);
    }
    /**
     * Metodo que devuelve todos los macroprocesos a la vista de macroprocesos
     * @return void
     */
    public function getMacroprocess()
    {
        $data = $this->model->select_macroprocess();
        toJson($data);
    }
}