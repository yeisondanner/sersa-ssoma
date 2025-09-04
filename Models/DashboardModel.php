<?php
class DashboardModel extends Mysql
{
    private int $id;
    private int $idprocess;
    private int $idmacroprocess;
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
    /**
     * Metodo que obtiene todos procesos asociados al macroproceso
     * @param  int $id
     * @return mixed
     */
    public function select_process_associed_macroprocess_by_id(int $id)
    {
        $this->id = $id;
        $sql = "SELECT*FROM tb_process AS tbp WHERE tbp.macroprocess_id=? AND tbp.p_status='Activo';";
        $request = $this->select_all($sql, [$this->id]);
        return $request;
    }
    /**
     * Metodo que obtiene la informacion de los procesos
     * @param  int $id
     * @return mixed
     */
    public function select_process_by_id(int $id)
    {
        $this->id = $id;
        $sql = "SELECT*FROM tb_process AS tbp WHERE tbp.idProcess=? AND tbp.p_status='Activo'";
        $request = $this->select($sql, [$this->id]);
        return $request;
    }
    /**
     * Metodo que obtiene el thread asociado al process que no tiene otro thread padres
     * @param int $idprocess
     * @return mixed
     */
    public function select_thread_associed_process_associed_macroprocess_by_id(int $idprocess, int $idmacroprocess)
    {
        $this->idprocess = $idprocess;
        $this->idmacroprocess = $idmacroprocess;
        $sql = "SELECT tbt.*FROM tb_threads AS tbt 
                INNER JOIN tb_process AS tbp ON tbp.idProcess=tbt.process_id
                WHERE tbp.macroprocess_id=?  AND  tbt.process_id=? AND tbt.threads_father IS NULL AND tbt.t_status = 'Activo';";
        $request = $this->select_all($sql, [$this->idmacroprocess, $this->idprocess]);
        return $request;
    }
    /**
     * Metodo que obtiene  informacion de Thread por us ID
     * @param  int  $$id
     * @return mixed
     */
    public function select_thread_id(int $id)
    {
        $this->id = $id;
        $sql = "SELECT*FROM tb_threads AS tbt WHERE tbt.idThreads=? AND tbt.t_status='Activo'";
        $request = $this->select($sql, [$this->id]);
        return $request;
    }
    /**
     * Metodo que se encarga de obtener threads hijos de un thread de un process de un macroprocess
     * @param int $idfather
     * @param int $idProcess
     * @param int $idMacroprocess
     * @return mixed
     */
    public function select_subthread_associed_thread_associed_process_associed_macroprocess(int $idfather, int $idprocess, int $idmacroprocess)
    {
        $this->id = $idfather;
        $this->idprocess = $idprocess;
        $this->idmacroprocess = $idmacroprocess;
        $sql = "SELECT
                    tbt.*
                FROM
                    tb_threads AS tbt
                    INNER JOIN tb_process AS tbp ON tbp.idProcess = tbt.process_id
                    INNER JOIN tb_macroprocess AS tbm ON tbm.idMacroprocess = tbp.macroprocess_id
                WHERE
                    tbm.mp_status = 'Activo'
                    AND tbp.p_status = 'Activo'
                    AND tbt.t_status = 'Activo'
                    AND tbt.threads_father = ?
                    AND tbm.idMacroprocess=?
                    AND tbp.idProcess=?;";
        $request = $this->select_all($sql, [$this->id, $this->idmacroprocess, $this->idprocess]);
        return $request;
    }
}