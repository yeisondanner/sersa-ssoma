<?php
class ClustModel extends Mysql
{
    private int $iduser;
    private int $idfolder;
    private string $name;
    private int $idfather;

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Este metodo obtiene la carpeta raíz del usuario
     * @param int $iduser
     * @param string $name
     * @return array
     */
    public function select_folder_root(int $iduser, string $name = 'root')
    {
        $query = "SELECT*FROM tb_folder WHERE user_id = ? AND f_name = ?;";
        $this->iduser = $iduser;
        $this->name = $name;
        $params = [$this->iduser, $this->name];
        $request = $this->select($query, $params);
        return $request;
    }
    /**
     * Metodo que obtiene las carpetas hijas de una carpeta
     * @param int $idFather
     * @return array
     */
    public function select_folders(int $idFather)
    {
        $this->idfather = $idFather;
        $sql = "SELECT*FROM tb_folder AS tbf WHERE tbf.f_idFather=? AND tbf.idFolder!=?;";
        $params = [$this->idfather, $this->idfather];
        return $this->select_all($sql, $params);
    }
    /**
     * Metodo que obtiene los archivos de una carpeta
     * @param int $idFolder
     * @return array
     */
    public function select_files_by_folder(int $idFolder)
    {
        $this->idfolder = $idFolder;
        $sql = "SELECT*FROM tb_file AS tbf WHERE tbf.folder_id = ?;";
        $params = [$this->idfolder];
        return $this->select_all($sql, $params);
    }
    /**
     * Metodo que inserta una nueva carpeta
     * @param int $iduser
     * @param string $name
     * @param int $idfather
     * @return bool|int|string
     */
    public function insert_folder(int $iduser, string $name, int $idfather)
    {
        $this->iduser = $iduser;
        $this->name = $name;
        $this->idfather = $idfather;
        $sql = "INSERT INTO `tb_folder` (`user_id`, `f_name`, `f_idFather`) VALUES (?, ?,?);";
        $params = [$this->iduser, $this->name, $this->idfather];
        return $this->insert($sql, $params);
    }
    public function select_space_used(int $iduser)
    {
        $this->iduser = strClean($iduser);
        $sql = "SELECT tbf.f_size FROM tb_file AS tbf WHERE tbf.user_id=?;";
        $params = [$this->iduser];
        $requestStorage = $this->select($sql, $params);
        $storageAccount = $_SESSION['login_info']['space_limit'];
        $storageUsed = $requestStorage ? $requestStorage['f_size'] : 0;
        $storageUsed = valConvert($storageUsed)["GB"];
        if ($storageAccount == 0) {
            if ($storageUsed == 0) {
                $width = 0;
            } else if ($storageUsed > 20) {
                $width = 50;
            }
            $componentHtml = '<div class="storage mt-auto">                 
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width:' . $width . '%"></div>
                    </div>
                    <small> ' . $storageUsed . ' GB de <strong>[Ilimitado]</strong> GB utilizado(s)</small>
                </div>';
        } else {
            $width = ($storageUsed / $storageAccount) * 100;
            $componentHtml = '<div class="storage mt-auto">
                    <p>Almacenamiento (' . $width . '% lleno)</p>
                    <div class="progress">
                        <div class="progress-bar bg-warning" style="width:' . $width . '%"></div>
                    </div>
                    <small>' . $storageUsed . ' GB de ' . $storageAccount . ' GB utilizado(s)</small>
                    <button class="btn btn-outline-primary btn-storage">Obtener más almacenamiento</button>
                </div>';
        }

        return $componentHtml;
    }
}