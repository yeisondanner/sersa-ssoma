<?php
class Clust extends Controllers
{
    public function __construct()
    {
        isSession();
        parent::__construct();
    }
    /**
     * Metodo para gestionar archivos y carpetas
     * @return void
     */
    public function clust()
    {
        $data['page_id'] = 11;
        $data['page_title'] = "Clust - Gestion de archivos y carpetas";
        $data['page_description'] = "Aqui podras gestionar tus archivos y carpetas de manera eficiente.";
        $data['page_container'] = "Clust";
        $data['page_view'] = 'clust';
        $data['page_js_css'] = "clust";
        $data['page_vars'] = ["login", "login_info"];
        $data['page_components'] = array(
            'storage' => $this->model->select_space_used($_SESSION['login_info']['idUser'])
        );
        registerLog("Información de navegación", "El usuario entro a :" . $data['page_title'], 3, $_SESSION['login_info']['idUser']);
        $this->views->getView($this, "clust", $data);
    }
    /**
     * Metodo que obtiene los archivos y carpetas
     * @return void
     */
    public function getFiles()
    {
        $requestFiles = $this->model->select_folder_root($_SESSION['login_info']['idUser'], $_SESSION['login_info']['folder_name']);
        $idFolder = $requestFiles["idFolder"];
        $requestFolders = $this->model->select_folders($idFolder);
        $requestFiles = $this->model->select_files_by_folder($idFolder);
        $array = [
            "folders" => $requestFolders,
            "files" => $requestFiles
        ];
        toJson($array);
    }
    public function createFolder()
    {
        $name = strClean($_POST['name']);
        $idFather = strClean($_POST['idFather']);
        $idUser = $_SESSION['login_info']['idUser'];

    }

}
