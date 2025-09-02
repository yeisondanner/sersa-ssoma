<?php
class ThreadModel extends Mysql
{
    private string $name;
    private string $description;
    private string $status;
    private int $id;
    private int $macroprocess_id;
    private int $process_id;
    private int $threads_father;
    private string $type;

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Funcion que se encarga de la seleccion de todos los macroprocesos con sus procesos asociados
     * @return array
     */
    public function select_thread_inner_process_inner_macroprocess(): array
    {
        $query = "SELECT
                        tbmp.mp_name,
                        tbp.macroprocess_id,
                        tbp.p_name,
                        tbt.*
                    FROM
                        tb_threads AS tbt
                        INNER JOIN tb_process AS tbp ON tbp.idProcess = tbt.process_id
                        INNER JOIN tb_macroprocess AS tbmp ON tbmp.idMacroprocess = tbp.macroprocess_id
                    ORDER BY
                        tbt.idThreads DESC;";
        $request = $this->select_all($query, []);
        return $request;
    }
    /**
     * Metodo que se encarga de traer todos los subprocesos asociados al proceso
     */
    public function select_threads_by_process_id(int $process_id): array
    {
        $this->process_id = $process_id;
        $query = "SELECT * FROM tb_threads WHERE process_id = ? AND t_type='open_menu'";
        $request = $this->select_all($query, [$this->process_id]);
        return $request;
    }
    /**
     * Metodo que se encarga de registrar un nuevo subproceso
     * @param string $name
     * @param string $description
     * @param int $process_id
     * @param int $threads_father
     * @param string $type
     * @return bool|int|string
     */
    public function insert_thread(string $name, string $description, int $process_id, int $threads_father, string $type)
    {
        $this->name = $name;
        $this->description = $description;
        $this->process_id = $process_id;
        $this->threads_father = $threads_father;
        $this->type = $type;
        $sql = "INSERT INTO 
                        `tb_threads` (`t_name`, `t_description`, `process_id`, `threads_father`, `t_type`) 
                VALUES 
                        (?, ?, ?, ?, ?);";
        $request = $this->insert($sql, [
            $this->name,
            $this->description,
            $this->process_id,
            $this->threads_father == 0 ? null : $this->threads_father,
            $this->type
        ]);
        return $request;
    }
    /**
     * Metodo que permite obtener un subproceso por su id
     * @param int $id
     * @return array
     */
    public function select_thread_by_id(int $id): array
    {
        $query = "SELECT * FROM tb_threads WHERE idThreads = ?";
        $request = $this->select($query, [$id]);
        return $request;
    }    /**
         * Metodo que permite eliminar un subproceso
         * @param int $id
         * @return bool
         */
    public function delete_thread(int $id): bool
    {
        $query = "DELETE FROM tb_threads WHERE idThreads = ?";
        $request = $this->delete($query, [$id]);
        return $request;
    }
}
