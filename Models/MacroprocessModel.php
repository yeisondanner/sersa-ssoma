<?php
class MacroprocessModel extends Mysql
{
    private string $name;
    private string $description;
    private string $status;
    private int $id;

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Funcion que se encarga de la seleccion de todos los macroprocesos
     * @return array
     */
    public function select_macroprocess(): array
    {
        $query = "SELECT * FROM tb_macroprocess 
                    ORDER BY idMacroprocess DESC;";
        $request = $this->select_all($query, []);
        return $request;
    }
    /**
     * Metodo que permite el registro de un nuevo macroproceso 
     * @param string $name
     * @param string $description
     * @return bool|int|string
     */
    public function insert_macroprocess(string $name, string $description)
    {
        $this->name = $name;
        $this->description = $description;
        $arrValues = [$this->name, $this->description];
        $query = "INSERT INTO tb_macroprocess (mp_name, mp_description) VALUES (?, ?)";
        $request = $this->insert($query, $arrValues);
        return $request;
    }
    /**
     * Metodo que se encarga de actualizar un macroproceso
     * @param string $name
     * @param string $description
     * @param string $status
     * @return bool
     */
    public function update_macroprocess(int $id, string $name, string $description, string $status)
    {
        $this->name = $name;
        $this->description = $description;
        $this->status = $status;
        $this->id = $id;
        $arrValues = [$this->name, $this->description, $this->status, $this->id];
        $query = "UPDATE tb_macroprocess SET mp_name = ?, mp_description = ?, mp_status = ? WHERE idMacroprocess = ?";
        $request = $this->update($query, $arrValues);
        return $request;
    }
    /**
     * Metodo que permite obtener un macroproceso por su id
     * @param int $id
     * @return array
     */
    public function select_macroprocess_by_id(int $id): array
    {
        $query = "SELECT * FROM tb_macroprocess WHERE idMacroprocess = ?";
        $request = $this->select($query, [$id]);
        return $request;
    }
    /**
     * Metodo que permite eliminar un macroproceso
     * @param int $id
     * @return bool
     */
    public function delete_macroprocess(int $id): bool
    {
        $query = "DELETE FROM tb_macroprocess WHERE idMacroprocess = ?";
        $request = $this->delete($query, [$id]);
        return $request;
    }
    /**
     * consultamos si el macroproceso tiene mas registros asociados a el
     * @param int $id
     * @return bool
     */
    public function has_associated_records(int $id)
    {
        $query = "SELECT
                        COUNT(*) AS 'totalProcess'
                    FROM
                        tb_process AS tbp
                    WHERE
                        tbp.macroprocess_id =  ?;";
        $this->id = $id;
        $arrValues = [$this->id];
        $request = $this->select($query, $arrValues);
        //validamos que el request no esté vacío, esto significa que el macroproceso tiene registros asociados, devolvera true y si no false
        return $request;
    }
    /**
     * Metodo que te permite obtener los macroprocesos con el nombre
     * @param string $name
     * @return array
     */
    public function select_macroprocess_by_name(string $name)
    {
        $this->name = $name;
        $sql = "SELECT*FROM tb_macroprocess AS tbmp WHERE tbmp.mp_name=?;";
        $request = $this->select($sql, [$this->name]);
        return $request;
    }
}
