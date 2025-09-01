<?php

class MacroprocessModel extends Mysql
{
    private string $name;
    private string $description;

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
                    ORDER BY idMacroprocess ASC;";
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
}
