<?php
class DashboardModel extends Mysql
{
    private int $id;
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
    /**
     * Funcion que se encarga de la seleccion de todos los macroprocesos activos
     * @return array
     */
    public function select_macroprocess_active(): array
    {
        $query = "SELECT * FROM tb_macroprocess 
                WHERE mp_status='Activo'
                    ORDER BY idMacroprocess ASC;";
        $request = $this->select_all($query, []);
        return $request;
    }
    /**
     * Metodo que se encarga de obtener el macroproceso por su id y verificar si esta activo
     * @param  int $id
     * @return mixed
     */
    public function select_macroprocess_by_id(int $id)
    {
        $this->id = $id;
        $sql = "SELECT*FROM tb_macroprocess as tbmp WHERE tbmp.idMacroprocess = ?  AND tbmp.mp_status='Activo'";
        $request = $this->select($sql, [$this->id]);
        return $request;
    }

}