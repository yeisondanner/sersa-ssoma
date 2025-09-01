<?php
class LogsModel extends Mysql
{
    private $title;
    private $description;
    private $typeLog;
    private $idUser;
    public function __construct()
    {
        parent::__construct();
    }
    public function insert_log($title, $description, $typeLog, $idUser)
    {
        $this->title = $title;
        $this->description = $description;
        $this->typeLog = $typeLog;
        $this->idUser = $idUser;
        $arrValues = array(
            $this->title,
            $this->description,
            $this->typeLog,
            $this->idUser
        );
        $sql = "INSERT INTO `tb_log` (`l_title`, `l_description`, `typelog_id`, `user_id`) VALUES (?,?,?,?);";
        $request = $this->insert($sql, $arrValues);
        return $request;
    }
    public function select_logs($minData, $maxData, int $filter_type)
    {
        $this->typeLog = $filter_type;
        if ($this->typeLog == 0 && $minData == 0 && $maxData == 0) {
            $sql = "SELECT tbl.*,tbtl.tl_name,tbu.u_fullname,tbu.u_user,tbu.u_email FROM tb_log AS tbl
            INNER JOIN tb_typelog AS tbtl ON tbtl.idTypeLog=tbl.typelog_id
            LEFT JOIN tb_user AS tbu ON tbu.idUser=tbl.user_id ORDER BY tbl.idLog DESC;";
            $arrValues = [];
        } else if ($filter_type == 0 && $minData != 0 && $maxData != 0) {
            $sql = "SELECT 
                        tbl.*,
                        tbtl.tl_name,
                        tbu.u_fullname,
                        tbu.u_user,
                        tbu.u_email 
                    FROM tb_log AS tbl
                    INNER JOIN tb_typelog AS tbtl ON tbtl.idTypeLog = tbl.typelog_id
                    INNER JOIN tb_user AS tbu ON tbu.idUser = tbl.user_id
                    WHERE tbl.l_registrationDate BETWEEN ? AND ?
                    ORDER BY tbl.idLog DESC;";
            $arrValues = array($minData, $maxData);
        } else {
            $sql = "SELECT 
                        tbl.*,
                        tbtl.tl_name,
                        tbu.u_fullname,
                        tbu.u_user,
                        tbu.u_email 
                    FROM tb_log AS tbl
                    INNER JOIN tb_typelog AS tbtl ON tbtl.idTypeLog = tbl.typelog_id
                    INNER JOIN tb_user AS tbu ON tbu.idUser = tbl.user_id
                    WHERE tbl.typelog_id = ?
                    AND tbl.l_registrationDate BETWEEN ? AND ?
                    ORDER BY tbl.idLog DESC;";
            $arrValues = array($this->typeLog, $minData, $maxData);
        }
        $request = $this->select_all($sql, $arrValues);
        return $request;
    }
}