<?php
class DashboardModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Metodo que se encarga de obtener los datos de los usuarios activos
     */
    public function select_count_users()
    {
        $query = "SELECT COUNT(*) AS CantidadUsuariosActivos FROM tb_user AS tbu WHERE tbu.u_status='Activo';";
        $request = $this->select($query);
        return $request;

    }
    /**
     * Metodo que se encarga de obtener los datos de los roles
     */
    public function select_count_roles()
    {
        $query = "SELECT COUNT(*) AS CantidadRoles FROM tb_role AS tbr WHERE tbr.r_status='Activo';";
        $request = $this->select($query);
        return $request;
    }

}