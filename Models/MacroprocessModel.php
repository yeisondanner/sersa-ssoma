<?php

class MacroprocessModel extends Mysql
{


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
}
