<?php

class Dashboard extends Controllers
{
    public function __construct()
    {
        isSession();
        parent::__construct();
    }

    public function dashboard()
    {
        $data['page_id'] = 2;
        $data['page_title'] = "Panel de control";
        $data['page_description'] = "Panel de control";
        $data['page_container'] = "Dashboard";
        $data['page_view'] = 'dashboard';
        $data['page_js_css'] = "dashboard";
        $data['page_vars'] = ["login", "login_info"];
        $data['page_widget'] = array(
            array(
                "title" => "Usuarios",
                "icon" => "fa fa-users",
                "value" => $this->model->select_count_users()['CantidadUsuariosActivos'],
                "link" => base_url() . "/users",
                "text" => "Cantidad de usuarios que tienen acceso al sistema y que estan activos",
                "color" => "primary",
            ),
            array(
                "title" => "Roles",
                "icon" => "fa fa-tags",
                "value" => $this->model->select_count_roles()['CantidadRoles'],
                "link" => base_url() . "/roles",
                "text" => "Cantidad de roles que existen en el sistema y que estan activos",
                "color" => "info",
            ),
            array(
                "title" => "Espacio Disponible",
                "icon" => "fa fa-hdd-o",
                "value" => "Dispo.: 1GB de 2GB",
                "link" => base_url() . "/roles",
                "text" => "Cantidad de espacio disponible en el sistema para su cuenta",
                "color" => "warning",
            ),
        );
        registerLog("Información de navegación", "El usuario entro a :" . $data['page_title'], 3, $_SESSION['login_info']['idUser']);
        $this->views->getView($this, "dashboard", $data);
    }
}
