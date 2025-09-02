<?php
class ThreadModel extends Mysql
{
    private string $name;
    private string $description;
    private string $status;
    private int $id;
    private int $macroprocess_id;
    private int $process_id;

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
                        tbmp.idMacroprocess DESC;";
        $request = $this->select_all($query, []);
        return $request;
    }
    /**
     * Metodo que permite el registro de un nuevo proceso
     * @param string $name
     * @param string $description
     * @param int $macroprocess_id
     * @return bool|int|string
     */
    public function insert_process(string $name, string $description, int $macroprocess_id)
    {
        $this->name = $name;
        $this->description = $description;
        $this->macroprocess_id = $macroprocess_id;
        $arrValues = [$this->name, $this->description, $this->macroprocess_id];
        $query = "INSERT INTO `tb_process` (`p_name`, `p_description`, `macroprocess_id`) VALUES (?, ?, ?)";
        $request = $this->insert($query, $arrValues);
        return $request;
    }
    /**
     * Metodo que se encarga de actualizar un proceso
     * @param string $name
     * @param string $description
     * @param string $status
     * @param int $macroprocess_id
     * @return bool
     */
    public function update_process(int $id, string $name, string $description, string $status, int $macroprocess_id)
    {
        $this->name = $name;
        $this->description = $description;
        $this->status = $status;
        $this->id = $id;
        $this->macroprocess_id = $macroprocess_id;
        $arrValues = [$this->name, $this->description, $this->status, $this->macroprocess_id, $this->id];
        $query = "UPDATE tb_process SET p_name = ?, p_description = ?, p_status = ?, macroprocess_id = ? WHERE idProcess = ?";
        $request = $this->update($query, $arrValues);
        return $request;
    }
    /**
     * Metodo que permite obtener un prceso por su id
     * @param int $id
     * @return array
     */
    public function select_process_by_id(int $id): array
    {
        $query = "SELECT * FROM tb_process WHERE idProcess = ?";
        $request = $this->select($query, [$id]);
        return $request;
    }
    /**
     * Metodo que permite eliminar un proceso
     * @param int $id
     * @return bool
     */
    public function delete_process(int $id): bool
    {
        $query = "DELETE FROM tb_process WHERE idProcess = ?";
        $request = $this->delete($query, [$id]);
        return $request;
    }
    /**
     * consultamos si el proceso tiene mas registros asociados a el
     * @param int $id
     * @return bool
     */
    public function has_associated_threads(int $id)
    {
        $query = "SELECT
                        COUNT(*) AS 'totalThreads'
                    FROM
                        tb_threads AS tbt
                    WHERE
                        tbt.process_id = ?;";
        $this->id = $id;
        $arrValues = [$this->id];
        $request = $this->select($query, $arrValues);
        //validamos que el request no esté vacío, esto significa que el proceso tiene registros asociados, devolvera true y si no false
        return $request;
    }
}
